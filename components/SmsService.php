<?php

namespace app\components;

use app\models\SmsNotification;
use app\models\User;
use AfricasTalking\SDK\AfricasTalking;
use Yii;
use yii\base\Component;
use yii\helpers\Json;

class SmsService extends Component
{
    public bool $enabled = false;
    public string $username = '';
    public string $apiKey = '';
    public string $senderId = '';
    public string $countryCode = '+255';
    public bool $enqueue = true;
    public int $maxAttempts = 5;
    public bool $dryRun = false;

    public function queueMemberRegistration(User $member): ?SmsNotification
    {
        $phone = $this->normalizePhone((string) $member->phone);
        if ($phone === '') {
            Yii::warning("SMS confirmation skipped for member {$member->id}: missing phone number.", __METHOD__);
            return null;
        }

        $notification = new SmsNotification([
            'member_id' => $member->id,
            'phone' => $phone,
            'message' => $this->buildRegistrationMessage($member),
        ]);

        if (!$notification->save()) {
            Yii::error('Failed to queue SMS notification: ' . Json::encode($notification->errors), __METHOD__);
            return null;
        }

        return $notification;
    }

    public function sendQueued(SmsNotification $notification): bool
    {
        if ($notification->status === SmsNotification::STATUS_SENT) {
            return true;
        }

        $notification->attempts++;

        try {
            $response = $this->send($notification->phone, $notification->message);
            $notification->status = SmsNotification::STATUS_SENT;
            $notification->provider_response = $response;
            $notification->last_error = null;
            $notification->sent_at = date('Y-m-d H:i:s');
            $notification->save(false);

            return true;
        } catch (\Throwable $e) {
            $notification->last_error = $e->getMessage();
            $notification->status = $notification->attempts >= $this->maxAttempts
                ? SmsNotification::STATUS_FAILED
                : SmsNotification::STATUS_PENDING;
            $notification->save(false);

            Yii::warning("SMS send failed for notification {$notification->id}: {$e->getMessage()}", __METHOD__);
            return false;
        }
    }

    public function retryPending(int $limit = 50): array
    {
        $notifications = SmsNotification::find()
            ->where(['status' => SmsNotification::STATUS_PENDING])
            ->orderBy(['created_at' => SORT_ASC])
            ->limit($limit)
            ->all();

        $sent = 0;
        $failed = 0;
        foreach ($notifications as $notification) {
            $this->sendQueued($notification) ? $sent++ : $failed++;
        }

        return ['sent' => $sent, 'failed' => $failed, 'checked' => count($notifications)];
    }

    public function buildRegistrationMessage(User $member): string
    {
        $name = trim(implode(' ', array_filter([
            $member->first_name,
            $member->middle_name,
            $member->last_name,
        ])));

        return "Ndugu {$name}, usajili wako wa usharika umekamilika. Karibu sana.";
    }

    private function send(string $phone, string $message): string
    {
        if ($this->dryRun) {
            return Json::encode(['dryRun' => true, 'phone' => $phone]);
        }

        if (!$this->enabled) {
            throw new \RuntimeException('SMS API is disabled.');
        }

        if ($this->username === '' || $this->apiKey === '') {
            throw new \RuntimeException('Africa\'s Talking username or API key is not configured.');
        }

        $options = [
            'to' => [$phone],
            'message' => $message,
            'enqueue' => $this->enqueue,
        ];

        if ($this->senderId !== '') {
            $options['from'] = $this->senderId;
        }

        $africasTalking = new AfricasTalking($this->username, $this->apiKey);
        $response = $africasTalking->sms()->send($options);

        if (($response['status'] ?? null) !== 'success') {
            throw new \RuntimeException('Africa\'s Talking SMS failed: ' . Json::encode($response));
        }

        return Json::encode($response['data'] ?? $response);
    }
    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^\d+]/', '', $phone) ?: '';
        if ($phone === '') {
            return '';
        }

        if (str_starts_with($phone, '+')) {
            return $phone;
        }

        if (str_starts_with($phone, '0')) {
            return $this->countryCode . substr($phone, 1);
        }

        $countryDigits = ltrim($this->countryCode, '+');
        if (str_starts_with($phone, $countryDigits)) {
            return '+' . $phone;
        }

        return $phone;
    }
}
