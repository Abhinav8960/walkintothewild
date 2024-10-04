<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    // 'bootstrap' => ['log'],
    'bootstrap' => ['log', 'api\components\RequestSanitization'],
    'modules' => [
        'meta' => [
            'class' => 'api\modules\meta\Module',
        ],
        'master' => [
            'class' => 'api\modules\master\Module',
        ],
        'park' => [
            'class' => 'api\modules\park\Module',
        ],
        'cms' => [
            'class' => 'api\modules\cms\Module',
        ],
        'sharesafari' => [
            'class' => 'api\modules\sharesafari\Module',
        ],
        'posts' => [
            'class' => 'api\modules\posts\Module',
        ]

    ],
    'components' => [
        'api' => [
            'class' => 'api\components\Api',
        ],
        /* 'request' => [
             'csrfParam' => '_csrf-backend',
         ], */
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            // ...
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-api',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'site/file' => 'site/file',
                'master-meta-info' => 'site/master-meta-info',
                'social-login' => 'site/social-login',
                'profile' => 'site/profile',
                'logout' => 'site/logout',

                'meta/<action>' => 'meta/default/<action>',
                'master/<action>' => 'master/default/<action>',
                'master/<action>/<slug>' => 'master/default/<action>',

                'park' => 'park/default/index',
                'filter-parklist' => 'park/default/filter-parklist',
                'park/<slug>' => 'park/default/view',

                'cms/<action>' => 'cms/default/<action>',
                'sharesafari' => 'sharesafari/default/index',
                'sharesafari/organize-safari' => 'sharesafari/default/organize-safari',
                'sharesafari/<slug>/<action>' => 'sharesafari/default/<action>',




            ],

        ],


        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'employee'],
            ],
        ],
        */


        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */

    ],
    'params' => $params,
];
