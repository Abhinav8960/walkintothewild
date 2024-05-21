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
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Calcutta',

    'modules' => [
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
        'sharesafari' => [
            'class' => 'backend\modules\sharesafari\Module',
        ]
    ],
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '500526108747-sat0quehomhc59pogk8mm50ch2id5kp7.apps.googleusercontent.com',
                    'clientSecret' => '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',
                    'returnUrl' => 'http://admin.walkintothewild.io/site/auth?authclient=google',
                ],
                // 'facebook' => [
                //     'class' => 'yii\authclient\clients\Facebook',
                //     'clientId' => 'facebook_client_id',
                //     'clientSecret' => 'facebook_client_secret',
                // ],
                // etc.
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],

    ],
    'params' => $params,
];
