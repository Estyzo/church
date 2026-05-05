<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class SmsController extends Controller
{
    public function actionRetry(int $limit = 50): int
    {
        $result = Yii::$app->smsService->retryPending($limit);

        $this->stdout("Checked: {$result['checked']}\n");
        $this->stdout("Sent: {$result['sent']}\n");
        $this->stdout("Still pending/failed: {$result['failed']}\n");

        return ExitCode::OK;
    }
}
