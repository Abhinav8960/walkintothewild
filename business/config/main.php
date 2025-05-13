<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-business',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'business\controllers',
    'bootstrap' => ['log', '\business\components\AppBootstrap'],
    'timeZone' => 'Asia/Calcutta',
    'modules' => [
        'package' => [
            'class' => 'business\modules\package\Module',
        ],
        'sharesafari' => [
            'class' => 'business\modules\sharesafari\Module',
        ],
        'chat' => [ // Chating and Messaging Module
            'class' => 'business\modules\chat\Module',
        ],
        'sightings' => [ // Chating and Messaging Module
            'class' => 'business\modules\sightings\Module',
        ],
        'posts' => [ // Chating and Messaging Module
            'class' => 'business\modules\posts\Module',
        ],
        'settings' => [
            'class' => 'business\modules\settings\Module',
        ],
        'leads' => [
            'class' => 'business\modules\leads\Module',
        ],


    ],
    'components' => [
        'reCaptcha3' => [
            'class'      => 'kekaadrenalin\recaptcha3\ReCaptcha',
            'site_key'   => isset($_SERVER['GOOGLE_CAPTCHA_SITE_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SITE_KEY'] : '6LdlvuYpAAAAAK2nW4xcNThJOMxVl2S6cGKqVJ9C',
            'secret_key' => isset($_SERVER['GOOGLE_CAPTCHA_SECRET_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SECRET_KEY'] : '6LdlvuYpAAAAABTlzZZ2dSAH3BhHL9WkxG7gfyUi',
        ],
        'request' => [
            'csrfParam' => '_csrf-business',
        ],
        'user' => [
            'class' => 'common\components\WebUser', // For Tracking the Sessions
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-business', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the business
            'class' => 'yii\web\DbSession',
            'name' => 'advanced-business',
            'timeout' => 3600 * 24 * 30,
            'cookieParams' => [
                'lifetime' => 3600 * 24 * 30, // Cookie lifetime, e.g., 30 days
            ],
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
            'errorAction' => 'site/error',
            'on ' . \yii\web\Response::EVENT_BEFORE_SEND => function ($event) {
                if ($event->sender->statusCode == null || $event->sender->statusCode == 200) {
                    $event->sender->setStatusCode(500);
                }
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/partner-registration' => '/partner-registration/create',
                '/chat/message/<user_handle>' => '/chat/default/message',
                '/chat/message/<user_handle>/<chat_id>' => '/chat/default/message',
                '/chat/quote/<user_handle>/<chat_id>' => '/chat/default/message',
            ],
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
