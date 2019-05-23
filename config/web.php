<?php

$common = require __DIR__ . '/common.php';

$cookieSuffix = '_' . md5($common['id']);

$config = [
    'id' => 'basic',
    'layout' => '@app/modules/frontend/views/layouts/main.php',
    'bootstrap' =>[
        \app\modules\frontend\components\LanguageSelector::class,
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'rXVaWYxMOJyzDm8xNAyotFsGxZDT5WEk',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ],
        ],
        'user' => [
            'identityClass' => \app\models\User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' => [
        'shop' => [
            'user' => [
                'identityClass' => \app\models\User::class,
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_shop' . $cookieSuffix, 'httpOnly' => true],
                'loginUrl' => ['/site/login'],
            ],
        ],
        'frontend' => [
            'user' => [
                'identityClass' => \app\models\User::class,
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => '_frontend' . $cookieSuffix, 'httpOnly' => true],
                'loginUrl' => ['/site/login'],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return \yii\helpers\ArrayHelper::merge($common, $config);
