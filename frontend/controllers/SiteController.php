<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use yii\filters\AccessControl;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\RenderedContent;
use frontend\components\AuthHandler;
use frontend\models\VerifyEmailForm;
use yii\web\BadRequestHttpException;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use common\models\trierror\form\ErrorLogForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use common\models\trierror\form\FrontendErrorLogForm;

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
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'auth'],
                'rules' => [
                    [
                        'actions' => ['signup', 'error', 'auth'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'auth'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    // 'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if ($action->id == 'auth') {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'user_login_redirect',
                'value' => Yii::$app->request->referrer,
                'expire' => time() + 86400 * 365 * 365,
            ]));
        }

        return parent::beforeAction($action);
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
            // 'error' => [
            //     'class' => \yii\web\ErrorAction::class,
            // ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function init()
    {
        parent::init();
        Yii::$app->view->on(\yii\web\View::EVENT_AFTER_RENDER, function ($event) {
            // Save rendered content and other details to the database
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $renderedContent = new RenderedContent();
                $renderedContent->created_at = date('Y-m-d H:i:s');
                $renderedContent->url = Yii::$app->request->absoluteUrl;
                $renderedContent->title = Yii::$app->view->title;
                $renderedContent->action_url = Yii::$app->request->url;

                // Save query parameters to a separate column
                $queryParams = Yii::$app->request->getQueryParams();
                $renderedContent->query_params = json_encode($queryParams); // Save query parameters as JSON

                // Add device info and IP address
                $renderedContent->user_agent = Yii::$app->request->userAgent;
                $renderedContent->ip_address = Yii::$app->request->userIP;

                if ($renderedContent->save()) {
                    $transaction->commit();
                } else {
                    Yii::error('Failed to save rendered content: ' . json_encode($renderedContent->errors));
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                Yii::error('Exception occurred while saving rendered content: ' . $e->getMessage());
                $transaction->rollBack();
            }
        });
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/park');
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/park');
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }


    public function onAuthSuccess($client)
    {
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('user_login_redirect')) {
            $referrer = $cookies->get('user_login_redirect')->value;
        } else {
            $referrer = Yii::$app->request->referrer;
        }
        (new AuthHandler($client, $referrer))->handle();
    }


    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        // if ($exception !== null) {
        //     var_dump($exception); // Output the exception object for debugging
        // }
        // echo "<pre>";
        // print_r($exception);
        // die();
        // error log reporting
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
        $error_model = new FrontendErrorLogForm();
        $error_model->scenario = 'create';
        $error_model->frontend_errorlog->setAttributes([
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
        $error_model->frontend_errorlog->save(false);

        return $this->render(
            'error',
            [
                'name' => $exception->getMessage() . '(#' . $exception->statusCode . ')',
                'message' => $exception->getMessage(),
                'exception' => $exception
            ]
        );
    }
}
