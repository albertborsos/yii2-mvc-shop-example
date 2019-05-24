<?php
/* @var codemix\yii2confload\Config $this */
return [
    'id' => 'mvvshopexample',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'shop'],
    'name' => 'Shop',
    'language' => 'en',
    'sourceLanguage' => 'en',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authClientCollection' => [
            'class' => \yii\authclient\Collection::class,
            'clients' => [
                'google' => [
                    'class' => \yii\authclient\clients\Google::class,
                    'clientId' => self::env('GOOGLE_CLIENT_ID'),
                    'clientSecret' => self::env('GOOGLE_CLIENT_SECRET'),
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => self::env('DB_DSN'),
            'username' => self::env('DB_USER'),
            'password' => self::env('DB_PASS'),
            'charset' => 'utf8',

            // Schema cache options (for production environment)
            //'enableSchemaCache' => true,
            //'schemaCacheDuration' => 60,
            //'schemaCache' => 'cache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'normalizer' => [
                'class' => \yii\web\UrlNormalizer::class,
                // use temporary redirection instead of permanent for debugging
                'action' => \yii\web\UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
            ],
            'rules' => [
                '/' => 'frontend/default/home',
                '/webshop/<slug:[a-zA-Z0-9-]+>' => 'frontend/default/index',
                '/webshop' => 'frontend/default/index',

                '/admin' => 'shop/default/login',
            ],
        ],
        'i18n' => [
            'class' => \yii\i18n\I18N::class,
            'translations' => [
                '*' => [
                    'basePath' => '@app/messages',
                    'class' => yii\i18n\PhpMessageSource::class,
                    'sourceLanguage' => 'en',
                ],
            ],
        ],
        'formatter' =>[
            'class' => \yii\i18n\Formatter::class,
            'currencyCode' => 'HUF',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
        ],
    ],
    'modules' => [
        'shop' => ['class' => \app\modules\shop\Module::class],
        'frontend' => ['class' => \app\modules\frontend\Module::class],
    ],
    'params' => [
        'adminEmail' => 'admin@example.com',
        'senderEmail' => 'noreply@example.com',
        'senderName' => 'Example.com mailer',
    ],
];
