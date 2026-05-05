<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int|null $member_id
 * @property string $phone
 * @property string $message
 * @property string $status
 * @property int $attempts
 * @property string|null $last_error
 * @property string|null $provider_response
 * @property string|null $sent_at
 * @property string $created_at
 * @property string $updated_at
 */
class SmsNotification extends ActiveRecord
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    public static function tableName()
    {
        return 'sms_notifications';
    }

    public function rules()
    {
        return [
            [['phone', 'message'], 'required'],
            [['member_id', 'attempts'], 'integer'],
            [['message', 'last_error', 'provider_response'], 'string'],
            [['sent_at', 'created_at', 'updated_at'], 'safe'],
            [['phone'], 'string', 'max' => 32],
            [['status'], 'string', 'max' => 20],
            [['status'], 'default', 'value' => self::STATUS_PENDING],
            [['attempts'], 'default', 'value' => 0],
            [['member_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['member_id' => 'id']],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        if ($insert) {
            $this->created_at = $this->created_at ?: $now;
        }
        $this->updated_at = $now;

        return true;
    }

    public function getMember()
    {
        return $this->hasOne(User::class, ['id' => 'member_id']);
    }
}
