<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\components\AuthHandler;
use common\models\MailLog;
//use common\models\trierror\BackendErrorLog;
//use common\models\trierror\form\BackendErrorLogForm;
use common\models\trierror\form\ErrorLogForm;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'auth'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'auth'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->user;
            // echo '<pre>';
            // print_r($user);
            // die();
            $to_mail = $user->email;
            $subject = 'User Login';
            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_LOGIN;
            $req = ['username' => $user->name];

            MailLog::createMailLog($to_mail, $subject, $template, $req, []);

            return $this->goBack();
        }

        $model->password = '';

        return $this->render('@frontend/views/site/signin', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /*
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
       
        $request = Yii::$app->request;
        $user_session_id = Yii::$app->user->id;
        $error_type = $exception->statusCode;
        $error_msg = $exception->getMessage();
        $pathInfo = $request->pathInfo;
        $source = $request->userAgent;
        $request_url = $request->absoluteUrl;
        $reference_url = $request->referrer;
        $method = $request->getMethod();
        $ip_address = $request->getRemoteIP();
        $error_model = new BackendErrorLogForm();
        $error_model->scenario = 'create';
        $error_model->backend_errorlog->setAttributes([
            'error_type'            => $error_type,
            'request_url'           => $request_url,
            'reference_url'         => $reference_url,
            'ip_address'            => $ip_address,
            'request_type'          => $method,
            'error_msg'             => $error_msg,
            'user_session_id'       => $user_session_id,
            'source'                => $source,
            'user_agent'            => Yii::$app->request->userAgent,
        ]);
        $error_model->backend_errorlog->save(false);

        return $this->render(
            'error',
            [
                'name' => $exception->getMessage() . '(#' . $exception->statusCode . ')',
                'message' => $exception->getMessage(),
                'exception' => $exception
            ]
        );
    }
    */
}
