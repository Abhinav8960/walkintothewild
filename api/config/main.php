<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'timezone' => 'Asia/Kolkata',
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
        ],
        'plan' => [
            'class' => 'api\modules\plan\Module',
        ],
        'package' => [
            'class' => 'api\modules\package\Module',
        ],
        'operator' => [
            'class' => 'api\modules\operator\Module',
        ],
        'profile' => [
            'class' => 'api\modules\profile\Module',
        ],
        'account' => [
            'class' => 'api\modules\account\Module'
        ],
        'manage' => [
            'class' => 'api\modules\manage\Module'
        ],
        'feeds' => [
            'class' => 'api\modules\feeds\Module',
        ],
        'sighting' => [
            'class' => 'api\modules\sighting\Module',
        ],
        'chat' => [
            'class' => 'api\modules\chat\Module',
        ],

    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
            'class' => 'api\components\CustomErrorHandler',
        ],
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
                ]
            ],
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'site/error' => 'site/error',
                'site/file' => 'site/file',
                'master-meta-info' => 'site/master-meta-info',
                'social-login' => 'site/social-login',
                'profile' => 'site/profile',
                'logout' => 'site/logout',
                'termofuse' => 'site/termofuse',
                'privacypolicy' => 'site/privacypolicy',
                'update-token' => 'site/update-token',
                'meta/<action>' => 'meta/default/<action>',
                'master/<action>' => 'master/default/<action>',
                'master/<action>/<slug>' => 'master/default/<action>',
                'park' => 'park/default/index',
                'filter-parklist' => 'park/default/filter-parklist',
                'park/<slug>' => 'park/default/view',
                'park/<slug>/<action>' => 'park/default/<action>',
                'cms/<action>' => 'cms/default/<action>',
                'sharesafari' => 'sharesafari/default/index',
                'sharesafari/organize-safari' => 'sharesafari/default/organize-safari',
                'sharesafari/flagreason' => 'sharesafari/default/flagreason',
                'sharesafari/<slug>/<action>' => 'sharesafari/default/<action>',
                'posts' => 'posts/default/index',
                'posts-images' => 'posts/default/posts-images',
                'posts/<action>' => 'posts/default/<action>',

                'sighting' => 'sighting/default/index',
                'sighting/<action>' => 'sighting/default/<action>',




                'featured-park' => 'plan/default/featured-park',
                'rare-animal' => 'plan/default/rare-animal',

                'package' => 'package/default/index',
                'package/staycategory' => 'package/default/staycategory',
                'package/<slug>' => 'package/default/view',
                'package/<slug>/<action>' => 'package/default/<action>',

                'operator/<slug>' => 'operator/default/view',
                'operator/<slug>/<action>' => 'operator/default/<action>',

                'about-us' => 'static-page/about-us',
                'faqs' => 'static-page/faqs',
                'contact-us' => 'static-page/contact-us',

                'user-profile' => 'profile/default/index',
                'organizedby' => 'profile/default/organizedby',
                'joinedby' => 'profile/default/joinedby',
                'useractivity' => 'profile/default/useractivity',
                'profile/follow' => 'profile/default/follow',
                'profile/unfollow' => 'profile/default/unfollow',

                'account' => 'account/default/index',
                'account/<action>' => 'account/default/<action>',

                'manage' => 'manage/default/index',
                'manage/<action>' => 'manage/default/<action>',
                'manage/sharedsafari/create-fixed-departure' => 'manage/sharedsafari/create-fixed-departure',
                'manage/sharedsafari/<action>/<slug>' => 'manage/sharedsafari/<action>',
                'manage/sharedsafari/<action>/<slug>/<day>' => 'manage/sharedsafari/<action>',

                /**Manage Package */
                'manage/package/create' => 'manage/package/create',
                'manage/package/<action>/<slug>' => 'manage/package/<action>',
                'manage/package/<action>/<slug>/<day>' => 'manage/package/<action>',

                /** feeds */
                'feeds' => 'feeds/default/index',
                'feeds/sighting-home' => 'feeds/default/sighting-home',

                // ** Chat */
                'chat/direct-user-chat'      => 'chat/default/direct-user-chat',
                'chat/quatation-chat'   => 'chat/default/quatation-chat',
                'chat/operator-list'   => 'chat/default/operator-list',
                'chat/user-list'   => 'chat/default/user-list',
                'chat/messages/<chat_hash>'   => 'chat/default/messages',
                
                

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
