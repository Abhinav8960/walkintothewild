<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-support',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'support\controllers',
    'bootstrap' => ['log', '\support\components\AppBootstrap'],
    'timeZone' => 'Asia/Calcutta',

    'modules' => [
        'leads' => [
            'class' => 'support\modules\leads\Module',
        ],

        'sightings' => [
            'class' => 'support\modules\sightings\Module',
        ],

        'posts' => [
            'class' => 'support\modules\posts\Module',
        ],

        'operator' => [
            'class' => 'support\modules\operator\Module',
        ],
        
        'galleryapproval' => [
            'class' => 'support\modules\galleryapproval\Module',
        ],

        'gallery' => [
            'class' => 'support\modules\gallery\Module',
        ],

        'package' => [
            'class' => 'support\modules\package\Module',
        ],

        'sharesafari' => [
            'class' => 'support\modules\sharesafari\Module',
        ],
        
    ],



    'components' => [
        'reCaptcha3' => [
            'class'      => 'kekaadrenalin\recaptcha3\ReCaptcha',
            'site_key'   => isset($_SERVER['GOOGLE_CAPTCHA_SITE_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SITE_KEY'] : '6LdlvuYpAAAAAK2nW4xcNThJOMxVl2S6cGKqVJ9C',
            'secret_key' => isset($_SERVER['GOOGLE_CAPTCHA_SECRET_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SECRET_KEY'] : '6LdlvuYpAAAAABTlzZZ2dSAH3BhHL9WkxG7gfyUi',
        ],
        'request' => [
            'csrfParam' => '_csrf-support',
        ],
        'user' => [
            'class' => 'common\components\WebUser', // For Tracking the Sessions
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-support', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the support
            'class' => 'yii\web\DbSession',
            'name' => 'advanced-support',
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
