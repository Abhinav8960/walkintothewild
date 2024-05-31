<?php
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
    'modules' => [
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            // the layout that should be applied for views within this module
            // 'layout' => 'main',
            'layout' => '@backend/themes/nova/views/layouts/db_audit_main',
            // 'layout' => '@app/themes/prsadmin/views/layouts/main',
            // Name of the component to use for database access
            'db' => 'db_audit_frontend',
            // List of actions to track. '*' is allowed as the last character to use as wildcard
            'trackActions' => ['*'],
            // Actions to ignore. '' is allowed as the last character to use as wildcard (eg 'debug/')
            'ignoreActions' => ['audit/', 'debug/',],
            // Maximum age (in days) of the audit entries before they are truncated
            // 'maxAge' => 'debug',
            'maxAge' => '15',
            // IP address or list of IP addresses with access to the viewer, null for everyone (if the IP matches)
            // 'accessIps' => ['127.0.0.1', '192.168.*'], 
            // Role or list of roles with access to the viewer, null for everyone (if the user matches)
            'accessRoles' => [],
            // User ID or list of user IDs with access to the viewer, null for everyone (if the role matches)
            'accessUsers' => [1],
            // Compress extra data generated or just keep in text? For people who don't like binary data in the DB
            'compressData' => true,
            // The callback to use to convert a user id into an identifier (username, email, ...). Can also be html.
            // 'userIdentifierCallback' => ['app\models\User', 'userIdentifierCallback'],
            'userIdentifierCallback' => ['common\models\User', 'userIdentifierCallback'],

            // If the value is a simple string, it is the identifier of an internal to activate (with default settings)
            // If the entry is a '<key>' => '<string>|<array>' it is a new panel. It can optionally override a core panel or add a new one.
            'panels' => [
                'audit/request',
                'audit/error',
                // 'audit/trail',
                'audit/javascript',
                'app/views' => [
                    'class' => 'backend\panels\ViewsPanel',
                ],
            ],
            // 'panelsMerge' => [
            //    // ... merge data (see below)
            // ]
        ],
    ],
    'components' => [
        'reCaptcha3' => [
            'class'      => 'kekaadrenalin\recaptcha3\ReCaptcha',
            'site_key'   => isset($_SERVER['GOOGLE_CAPTCHA_SITE_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SITE_KEY'] : '6LdlvuYpAAAAAK2nW4xcNThJOMxVl2S6cGKqVJ9C',
            'secret_key' => isset($_SERVER['GOOGLE_CAPTCHA_SECRET_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SECRET_KEY'] : '6LdlvuYpAAAAABTlzZZ2dSAH3BhHL9WkxG7gfyUi',
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
            'rules' => [],
        ],

    ],
    'params' => $params,
];
