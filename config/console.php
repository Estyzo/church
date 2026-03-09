<?php

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,

    // define modules key so we can safely add dev modules later
    'modules' => [],
];

/**
 * DEV-ONLY modules/tools.
 * Do NOT enable these in production.
 */
if (YII_ENV_DEV) {

    // Gii (code generator) - DEV only
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];

    // Debug - DEV only
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // 'allowedIPs' => ['127.0.0.1', '::1'], // add your IP if needed
    ];

    /**
     * migrik (yii2-migration-generator) - DEV only
     * WARNING: migrik expects Gii to be installed/enabled.
     * If you don't use migrik, leave this disabled.
     */
    // $config['bootstrap'][] = 'migrik';
    // $config['modules']['migrik'] = [
    //     'class' => 'insolita\migrik\Module',
    // ];
}

return $config;