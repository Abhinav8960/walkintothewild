<?php

namespace frontend\controllers;

use Yii;
use common\models\Auth;
use common\models\User;
use yii\web\Controller;
use common\models\PreAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use frontend\models\AuthTemp;
use frontend\models\LoginForm;
use frontend\models\GmailLoginForm;
use yii\filters\AccessControl;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\RenderedContent;
use yii\authclient\ClientInterface;
use frontend\components\AuthHandler;
use frontend\models\VerifyEmailForm;
use yii\web\BadRequestHttpException;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use common\models\trierror\form\ErrorLogForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use common\models\notification\FrontendNotification;
use common\models\trierror\form\FrontendErrorLogForm;

/**
 * Site controller
 */
class SiteController extends FrontendBaseController
{
    public $action_ids = ['login', 'logout', 'auth'];

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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'auth' || $action->id == 'login') {
            $referrer = Yii::$app->request->referrer;
            if (isset($this->request->queryParams['referrer'])) {
                $referrer = $this->request->queryParams['referrer'];
            }
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'user_login_redirect',
                'value' => $referrer,
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


    // public function init()
    // {
    //     parent::init();
    //     Yii::$app->view->on(\yii\web\View::EVENT_AFTER_RENDER, function ($event) {
    //         // Save rendered content and other details to the database
    //         $transaction = Yii::$app->db->beginTransaction();
    //         try {
    //             $renderedContent = new RenderedContent();
    //             $renderedContent->created_at = date('Y-m-d H:i:s');
    //             $renderedContent->url = Yii::$app->request->absoluteUrl;
    //             $renderedContent->title = Yii::$app->view->title;
    //             $renderedContent->action_url = Yii::$app->request->url;

    //             // Save query parameters to a separate column
    //             $queryParams = Yii::$app->request->getQueryParams();
    //             $renderedContent->query_params = json_encode($queryParams); // Save query parameters as JSON

    //             // Add device info and IP address
    //             $renderedContent->user_agent = Yii::$app->request->userAgent;
    //             $renderedContent->ip_address = Yii::$app->request->userIP;

    //             if ($renderedContent->save()) {
    //                 $transaction->commit();
    //             } else {
    //                 Yii::error('Failed to save rendered content: ' . json_encode($renderedContent->errors));
    //                 $transaction->rollBack();
    //             }
    //         } catch (\Exception $e) {
    //             Yii::error('Exception occurred while saving rendered content: ' . $e->getMessage());
    //             $transaction->rollBack();
    //         }
    //     });
    // }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect('/');
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionSigninagree($key)
    {
        $model = AuthTemp::find()->where(['rand_key' => $key])->one();
        if (empty($model)) {
            return Yii::$app->response->redirect('/');
        }

        if ($model->load(Yii::$app->request->post())) {
            $data = Yii::$app->request->post('AuthTemp');

            $password = Yii::$app->security->generateRandomString(6);
            $user = new User([
                'name' => $model->name,
                'username' => $model->username,
                'gmail' => $model->gmail,
                'email' => $model->email,
                'google_source_id' => $model->source_id,
                'avatar' => $model->avatar,
                'password' => $password,
                'status' => User::STATUS_ACTIVE // make sure you set status properly
            ]);
            $user->generateAuthKey();
            //$user->generatePasswordResetToken();

            $transaction = User::getDb()->beginTransaction();

            if ($user->save()) {
                $auth = new Auth([
                    'user_id' => $user->id,
                    'source' => $model->source,
                    'source_id' => $model->source_id,
                ]);
                if ($auth->save()) {
                    $transaction->commit();
                    $this->loginUser($user);
                    return Yii::$app->response->redirect($model->redirect_to);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to save {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', 'Unable to save user: {errors}', [
                        'client' => $this->client->getTitle(),
                        'errors' => json_encode($user->getErrors()),
                    ]),
                ]);
            }
        }

        return $this->render(
            'signinagree',
            [
                'model' => $model,
                'key' => $key
            ]
        );
    }

    public function actionLogin()
    {
        /*
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/park');
        }
        */

        $model = new LoginForm();
        $model->action_url = '/site/login';
        $model->action_validate_url = '/site/signinvalidate';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    if ($model->login()) {
                        return $this->redirect('/park');
                    }
                }
            }
        } else {
            $model->password = '';
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('signin', [
                'model' => $model,
            ]);
        } else {
            return $this->render('signin', [
                'model' => $model,
            ]);
        }
    }

    public function actionSigninvalidate()
    {
        $model = new LoginForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionLogin_old()
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
    // public function actionVerifyEmail($token)
    // {
    //     try {
    //         $model = new VerifyEmailForm($token);
    //     } catch (InvalidArgumentException $e) {
    //         throw new BadRequestHttpException($e->getMessage());
    //     }
    //     if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
    //         Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
    //         return $this->goHome();
    //     }

    //     Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
    //     return $this->goHome();
    // }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    // public function actionResendVerificationEmail()
    // {
    //     $model = new ResendVerificationEmailForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
    //             return $this->goHome();
    //         }
    //         Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
    //     }

    //     return $this->render('resendVerificationEmail', [
    //         'model' => $model
    //     ]);
    // }


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

        // error log reporting
        $request = Yii::$app->request;
        $userid = 0;
        if (isset(Yii::$app->user->id)) {
            $userid = Yii::$app->user->id;
        }

        $user_session_id = $userid;
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

    private function loginUser($user)
    {
        //$this->updateUserInfo($user);
        Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
    }

    /**
     * New Notification
     *
     * @return void
     */
    public function actionNotification($notice_id = null, $update_is_seen = false)
    {
        $model = [];
        if ($notice_id) {
            $model = FrontendNotification::find()->where(['status' => 1, 'id' => $notice_id])->limit(1)->one();
        } else {
            $model = FrontendNotification::find()->where(['status' => 1, 'attender_user_id' => \Yii::$app->user->identity->id, 'user_id' => \Yii::$app->user->identity->id])->andWhere("created_at < " . time() . "-coalesce(delay_time,0)")->orderBy(['id' => SORT_DESC])->limit(1)->one();
        }
        if ($model) {
            $model->is_seen = 1;
            $model->seen_datetime = date('Y-m-d H:i:s');
            // $model->is_read = 1;
            $model->read_datetime = date('Y-m-d H:i:s');
            $model->save(false);
        }
        if ($update_is_seen && $model) {
            $model->is_seen = 1;
            $model->seen_datetime = date('Y-m-d H:i:s');
            // $model->is_read = 1;
            $model->read_datetime = date('Y-m-d H:i:s');
            $model->save(false);
        }
    }

    /**
     * Update Notification List
     */
    public function actionUpdatenotificationlist()
    {
        $notification_list = FrontendNotification::find()->where(['status' => 1, 'user_id' => Yii::$app->user->identity->id])->orderby(['id' => SORT_DESC])->limit(6)->all();
        return $this->renderAjax('_notification_list', ['notification_list' => $notification_list]);
    }

    public function actionLoginNew()
    {
        Yii::$app->mailer->compose()
            ->setFrom('no-reply@walkintothewild.in')
            ->setTo('shokeen.triline@gmail.com')
            ->setSubject('Email sent from Yii2-Swiftmailer')
            ->setHtmlBody('here is the text')
            ->send();

        die('mail sent successfull');

        /*
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/park');
        }
        */
        $model = new GmailLoginForm();
        $model->action_url = '/site/login';
        $model->action_validate_url = '/site/signinvalidate';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $post_data = $this->request->post('GmailLoginForm');
                    if (!empty($post_data['email_id']) && empty($post_data['email_code'])) {
                        //send mail with passcode
                    } else if (!empty($post_data['email_id']) && !empty($post_data['email_code'])) {
                        //match password with email code
                        //register user if user is new

                        //login user if user is old
                        if ($model->login()) {
                            return $this->redirect('/park');
                        }
                    }
                }
            }
        } else {
            $model->email_code = '';
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('login_new', [
                'model' => $model,
            ]);
        } else {
            return $this->render('login_new', [
                'model' => $model,
            ]);
        }
    }
}
