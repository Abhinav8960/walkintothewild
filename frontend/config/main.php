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
    'bootstrap' => ['log', 'audit', '\frontend\components\AppBootstrap'],
    'defaultRoute' => '/park',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'reCaptcha3' => [
            'class'      => 'kekaadrenalin\recaptcha3\ReCaptcha',
            'site_key'   => isset($_SERVER['GOOGLE_CAPTCHA_SITE_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SITE_KEY'] : '6LdlvuYpAAAAAK2nW4xcNThJOMxVl2S6cGKqVJ9C',
            'secret_key' => isset($_SERVER['GOOGLE_CAPTCHA_SECRET_KEY']) ? $_SERVER['GOOGLE_CAPTCHA_SECRET_KEY'] : '6LdlvuYpAAAAABTlzZZ2dSAH3BhHL9WkxG7gfyUi',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    // 'clientId' => '500526108747-sat0quehomhc59pogk8mm50ch2id5kp7.apps.googleusercontent.com',
                    // 'clientSecret' => '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',
                    // 'returnUrl' => 'http://admin.walkintothewild.io/site/auth?authclient=google',

                    'clientId' => '631766851704-lbmn5e7lqhp6gnhf1jnumdrelbg5b00k.apps.googleusercontent.com',
                    'clientSecret' => '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',
                    'returnUrl' => 'https://staging.walkintothewild.in/site/auth?authclient=google',
                ],
            ],
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
                '/park' => '/park/default/index', //home page url
                '/park/<slug>' => '/park/default/view', //park view url

                '/parklist/<master_location_id:\w+>/<session_id:\w+>/<master_animal_id:\w+>/<master_vehicle_id:\w+>' => '/park/default/parklist',
                '/parklist' => '/park/default/parklist', //park listing url
                '/rareanimal/<slug>' => '/park/default/rareanimal', //park listing url

                '/article' => '/article/default/index',
                '/article/tag/<slug>' => '/article/default/tag',
                [
                    'pattern' => '/article/tag/<slug:\w+>',
                    'route' => '/article/default/tag',
                    'defaults' => ['slug' => '']
                ],
                '/article/topic/<slug>' => '/article/default/topic',
                [
                    'pattern' => '/article/topic/<slug:\w+>',
                    'route' => '/article/default/topic',
                    'defaults' => ['slug' => '']
                ],
                '/article/author/<slug>' => '/article/default/author',
                [
                    'pattern' => '/article/author/<slug:\w+>',
                    'route' => '/article/default/author',
                    'defaults' => ['slug' => '']
                ],
                '/article/<slug>' => '/article/default/view', //article view url



                // Shared Safari URLs
                '/sharedsafari' => '/sharedsafari/default/index',
                '/sharedsafari/default/validate' => '/sharedsafari/default/validate',
                '/sharedsafari/default/update' => '/sharedsafari/default/update',
                '/sharedsafari/default/join' => '/sharedsafari/default/join',
                '/sharedsafari/default/unjoin' => '/sharedsafari/default/unjoin',
                '/sharedsafari/default/organize-safari' => '/sharedsafari/default/organize-safari',
                '/sharedsafari/<slug>' => '/sharedsafari/default/view',


                '/operator/<slug>/reviewlist' => '/operator/default/reviewlist', //operator view url
                '/operator/<slug>/sharedsafari' => '/operator/default/sharedsafari', //operator view url
                '/operator/<slug>' => '/operator/default/view', //operator view url
                '/operator/resort/<id>' => '/operator/default/resort', //operator view url
                '/operator/shared-safari/<id>' => '/operator/default/shared-safari', //operator view url
                '/operator/review/<id>' => '/operator/default/review', //operator view url

                '/package' => '/package/default/index', //package page url
                '/package/<slug>' => '/package/default/view', //package page url
                '/package/create' => '/package/default/create', //package create url          
                '/package/profile/<package_id>' => '/package/profile/index', //package profile  url          
                '/package/profile/itinerary/<package_id>/<day>' => '/package/profile/itinerary', //package profile itenary url          
                '/package/profile/inclusion/<package_id>' => '/package/profile/inclusion', //package profile inclusion url          
                '/package/profile/getting-there/<package_id>' => '/package/profile/getting-there', //package profile getting-there url          
                '/package/profile/policy-info/<package_id>' => '/package/profile/policy-info', //package profile policy-info url          
                '/package/profile/faq/<package_id>' => '/package/profile/faq', //package profile faq url          
                '/package/profile/create-faq/<package_id>' => '/package/profile/create-faq', //package profile create faq url          
                '/package/profile/select-faq/<package_id>' => '/package/profile/select-faq', //package profile select faq url          
            ],
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
        'operator' => [
            'class' => 'frontend\modules\operator\Module',
        ],
        'sharedsafari' => [
            'class' => 'frontend\modules\sharedsafari\Module',
        ],
        'package' => [
            'class' => 'frontend\modules\package\Module',
        ],
    ],
    'params' => $params,
];
