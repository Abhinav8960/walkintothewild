<?php

use yii\web\UrlNormalizer;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$rules = array_merge(
    require __DIR__ . '/rules.php',
);

return [
    'id' => 'app-frontend',
    'timezone' => 'Asia/Kolkata',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'audit', '\frontend\components\AppBootstrap'],
    'defaultRoute' => '/plan-safari',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'reCaptcha3' => [
            'class'      => 'kekaadrenalin\recaptcha3\ReCaptcha',
            'site_key'   => isset($_SERVER['GOOGLE_CAPTCHA_SITE_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SITE_KEY'] : '6LdlvuYpAAAAAK2nW4xcNThJOMxVl2S6cGKqVJ9C',
            'secret_key' => isset($_SERVER['GOOGLE_CAPTCHA_SECRET_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SECRET_KEY'] : '6LdlvuYpAAAAABTlzZZ2dSAH3BhHL9WkxG7gfyUi',
        ],
        'view' => [
            //'class' => 'daxslab\taggedview\View',
            //'image' => 'https://walkintothewild.in/img/default_witw_jeep.png',
            'on afterRender' => function ($event) {
                // Your custom logic here
                $event->output .= "\n<!-- Rendered on " . date('Y-m-d H:i:s') . " -->";
            },
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'class' => 'common\components\WebUser', // For Tracking the Sessions
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'timeout' => 3600 * 24 * 30
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error'],
                ],
            ],
        ],
        'errorHandler' => [
            'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $rules,
        ],
        'mobileDetect' => [
            'class' => '\skeeks\yii2\mobiledetect\MobileDetect'
        ],
    ],

    'modules' => [
        'park' => [
            'class' => 'frontend\modules\park\Module',
        ],
        'article' => [
            'class' => 'frontend\modules\article\Module',
        ],
        'operator' => [ // Safari Operator Public Page
            'class' => 'frontend\modules\operator\Module',
        ],
        'sharedsafari' => [
            'class' => 'frontend\modules\sharedsafari\Module',
        ],
        'package' => [
            'class' => 'frontend\modules\package\Module',
        ],
        'profile' => [ // User Profile
            'class' => 'frontend\modules\profile\Module',
        ],
        'account' => [ // User Account Related Settings
            'class' => 'frontend\modules\account\Module',
        ],
        'manage' => [ // Operator Businesss Page Manage
            'class' => 'frontend\modules\manage\Module',
        ],
        'chat' => [ // Chating and Messaging Module
            'class' => 'frontend\modules\chat\Module',
        ],
    ],
    'container' => [
        'definitions' => [
            \yii\widgets\LinkPager::class => \yii\bootstrap5\LinkPager::class,
            'yii\bootstrap5\LinkPager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
                'options' => ['class' => 'pagination pagination-primary mg-sm-b-0']
            ],
        ],
    ],
    'params' => $params,
];
