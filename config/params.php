<?php

$params = [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'sms' => [
        'enabled' => (bool) getenv('AT_SMS_ENABLED'),
        'username' => getenv('AT_USERNAME') ?: 'sandbox',
        'apiKey' => getenv('AT_API_KEY') ?: '',
        'senderId' => getenv('AT_SENDER_ID') ?: '',
        'countryCode' => getenv('SMS_COUNTRY_CODE') ?: '+255',
        'enqueue' => getenv('AT_SMS_ENQUEUE') === false ? true : (bool) getenv('AT_SMS_ENQUEUE'),
        'maxAttempts' => 5,
        'dryRun' => (bool) getenv('AT_SMS_DRY_RUN'),
    ],
];

$localParams = __DIR__ . '/params-local.php';

return file_exists($localParams)
    ? array_replace_recursive($params, require $localParams)
    : $params;
