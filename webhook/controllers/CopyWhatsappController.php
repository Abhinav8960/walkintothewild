<?php

namespace webhook\controllers;


use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii;
use Netflie\WhatsAppCloudApi\WebHook;

/**
 * Default controller for the `error` module
 */
class CopyWhatsappController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['POST', 'GET']
                ],
            ],
        ];
    }


    public function beforeAction($action)
    {
        if (in_array($action->id, ['index'])) {
            // Disable CSRF validation for the payu-response action
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
         /* ------------TO VERIFY TOKEN (UnCOMMENT ME)---- */
        // $webhook = new WebHook();

        // echo $webhook->verify($_GET, "white-elephant");
        // die();
        /* --------------------------------------------------------- */
        $payload = file_get_contents('php://input');
        \Yii::info(time(). 'whatsapp-webhook Response: ' . $payload, 'whatsapp-webhook');
    }
}
