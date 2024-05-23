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
        ],
        'user' => [
            'class' => 'backend\modules\user\Module',
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
        // 'mailer' => [
        //     'class' => \yii\symfonymailer\Mailer::class,
        //     'viewPath' => '@app/mail',
        //     // send all mails to a file by default.
        //     'useFileTransport' => true,
        // ],
        // 'mailer' => [
        //     'class' => 'yii\swiftmailer\Mailer',
        //     'useFileTransport' => false,
        //     'transport' => [
        //         'class' => 'Swift_SmtpTransport',
        //         'host' => 'smtp.gmail.com',
        //         'username' => 'smritipal2201@gmail.com',
        //         'password' => 'ybsaphazhjtlakau',
        //         'port' => '587',
        //         'encryption' => 'tls',
        //     ]
        // ],


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
            'rules' => [],
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
