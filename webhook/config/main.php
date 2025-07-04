<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-webhook',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'webhook\controllers',
    'bootstrap' => ['log', '\webhook\components\AppBootstrap'],
    'timeZone' => 'Asia/Calcutta',
   
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['payu'],
                    'logFile' => '@runtime/logs/payu.log',
                    'maxFileSize' => 1024 * 2, // 2MB
                    'maxLogFiles' => 5,
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
                'payu-response' => 'payment-response/payu-response',
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
