<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', '\backend\components\AppBootstrap'],
    'timeZone' => 'Asia/Calcutta',
    'modules' => [
        'webshell' => [
            'class' => 'samdark\webshell\Module',
            'yiiScript' => Yii::getAlias('@yii') . '/yii', // adjust path to point to your ./yii script
        ],
        'cms' => [
            'class' => 'backend\modules\cms\Module',
        ],
        'master' => [
            'class' => 'backend\modules\master\Module',
        ],
        'meta' => [
            'class' => 'backend\modules\meta\Module',
        ],
        'park' => [
            'class' => 'backend\modules\park\Module',
        ],
        'progresstracking' => [
            'class' => 'backend\modules\progresstracking\Module',
        ],
        'registration' => [
            'class' => 'backend\modules\registration\Module',
        ],
        'operator' => [
            'class' => 'backend\modules\operator\Module',
        ],
        'sharesafari' => [
            'class' => 'backend\modules\sharesafari\Module',
        ],
        'package' => [
            'class' => 'backend\modules\package\Module',
        ],
        'user' => [
            'class' => 'backend\modules\user\Module',
        ],
        'log' => [
            'class' => 'backend\modules\log\Module',
        ],
        'trierror' => [
            'class' => 'backend\modules\trierror\Module',
        ],
        'deploymentphase' => [
            'class' => 'backend\modules\deploymentphase\Module',
        ],
        'portalsetting' => [
            'class' => 'backend\modules\portalsetting\Module',
        ],
        'operatordashboard' => [
            'class' => 'backend\modules\operatordashboard\Module',
        ],
        'article' => [
            'class' => 'backend\modules\article\Module',
        ],
        'pendingapproval' => [
            'class' => 'backend\modules\pendingapproval\Module',
        ],
        'flag' => [
            'class' => 'backend\modules\flag\Module',
        ],
        'contact' => [
            'class' => 'backend\modules\contact\Module',
        ],
        'reportsection' => [
            'class' => 'backend\modules\reportsection\Module',
        ],
    ],
    'components' => [
        'reCaptcha3' => [
            'class'      => 'kekaadrenalin\recaptcha3\ReCaptcha',
            'site_key'   => isset($_SERVER['GOOGLE_CAPTCHA_SITE_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SITE_KEY'] : '6LdlvuYpAAAAAK2nW4xcNThJOMxVl2S6cGKqVJ9C',
            'secret_key' => isset($_SERVER['GOOGLE_CAPTCHA_SECRET_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SECRET_KEY'] : '6LdlvuYpAAAAABTlzZZ2dSAH3BhHL9WkxG7gfyUi',
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'class' => 'common\components\WebUser', // For Tracking the Sessions
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'class' => 'yii\web\DbSession',
            'name' => 'advanced-backend',
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
            // 'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
            'errorAction' => 'site/error',
            // 'class' => 'yii\web\ErrorHandler',
            'on ' . \yii\web\Response::EVENT_BEFORE_SEND => function ($event) {
                // Check if the response status code is not already set
                if ($event->sender->statusCode == null || $event->sender->statusCode == 200) {
                    // Set the response status code to 500 (Internal Server Error)
                    $event->sender->setStatusCode(500);
                }
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/aws-mailer-notification' => '/aws-mailer-notification/index'
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
