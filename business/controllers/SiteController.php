<?php

namespace business\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use bussiness\components\AuthHandler;
use common\models\MailLog;
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
                        'actions' => ['login', 'error', 'auth', 'redirect'],
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

            /**Email for login user */
            $user = $model->user;
            $to_mail = $user->email;
            $subject = 'User Login';
            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_LOGIN;
            $req = ['username' => $user->name, 'is_email_sending' => true];
            MailLog::createMailLog($to_mail, $subject, $template, $req, []);
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('signin', [
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

        $session = Yii::$app->session;
        if ($session->get('user_session_id')) {
            Yii::$app->db->createCommand()
                ->delete('user_session', ['id' => $session->get('user_session_id')])
                ->execute();
            $session->remove('user_session_id');
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }



    /**
     * Redirect Url to another link
     */
    public function actionRedirect()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($userAgent, 'Instagram')) {
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename=tmp');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile('tmp');
        } else {
            $this->redirect(Yii::$app->request->referrer);
        }
    }

}
