<?php

use yii\web\UrlNormalizer;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'audit'],
    'defaultRoute' => '/coming-soon',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'reCaptcha3' => [
            'class'      => 'kekaadrenalin\recaptcha3\ReCaptcha',
            'site_key'   => isset($_SERVER['GOOGLE_CAPTCHA_SITE_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SITE_KEY'] : '6LdlvuYpAAAAAK2nW4xcNThJOMxVl2S6cGKqVJ9C',
            'secret_key' => isset($_SERVER['GOOGLE_CAPTCHA_SECRET_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SECRET_KEY'] : '6LdlvuYpAAAAABTlzZZ2dSAH3BhHL9WkxG7gfyUi',
        ],
        'view' => [
            'on afterRender' => function ($event) {
                // Your custom logic here
                $event->output .= "\n<!-- Rendered on " . date('Y-m-d H:i:s') . " -->";
            },
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
            'errorAction' => 'site/error',
        ],

        'mailer' => [
            // 'class' => 'yii\swiftmailer\Mailer',
            // 'class' => 'yii\symfonymailer\Mailer',
            'class' => 'common\Mailer\Mailer',
            // 'class' => 'apps\Mailer\AWSCustomMailer',
            // 'transportFactory' => apps\Mailer\MailerTransportFactory::class,
            'useFileTransport' => false,
            'transport' => [
                // 'class' => 'Swift_SmtpTransport',
                // 'class' => 'Swift_AWSTransport',
                // 'scheme' => 'smtps',
                // 'host' => 'email-smtp.ap-south-1.amazonaws.com', // amazon smtp host 
                // 'username' => 'AKIAX7HOT7POHICMCIWC', // ses user username
                // 'password' => 'BK+0TXPP/u/jirG56C7E99hnkHm0liK6cvYYXrhfpadI', // ses user password
                // 'port' => 465,
                // 'encryption' => 'tls',
                // 'dsn' => 'ses+smtp://AKIAX7HOT7POMUCN434G:urlencode(sOplW2xa1TCJ7+BhMMw1a8PwNYe8+oBj3zOqWY38)@email-smtp.ap-south-1.amazonaws.com?region=ap-south-1',
                'dsn' => 'ses+api://AKIAX7HOT7PONBYCE4L3:kQQEyuej8UzSNMHEMBRGDOB2lzqj17zBRcvuMu4E@default?region=ap-south-1',
                // 'dsn' => 'ses+api://AKIAX7HOT7POC2MAKZFN:OplW2xa1TCJ7+BhMMw1a8PwNYe8+oBj3zOqWY38@default?region=ap-south-1',
                // 'dsn' => 'ses+api://AKIAX7HOT7POCAH4YAUW:fX+bZbSoAl2mUvTn5qldDzp+X9l5OyHmL3m1Vv5c@default?region=ap-south-1',






            ],
            'viewPath' => '@common/mail',

        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/park' => '/park/default/index',
                '/park/<slug>' => '/park/default/view',
                '/parklist' => '/park/default/parklist',
            ],
        ],

    ],

    'modules' => [
        'park' => [
            'class' => 'frontend\modules\park\Module',
        ],

    ],
    'params' => $params,
];
