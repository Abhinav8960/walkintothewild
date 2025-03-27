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
use yii\filters\AccessControl;
use common\models\GeneralModel;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\RenderedContent;
use frontend\models\GmailLoginForm;
use yii\authclient\ClientInterface;
use frontend\components\AuthHandler;
use frontend\models\VerifyEmailForm;
use yii\web\BadRequestHttpException;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use common\models\master\animal\MasterAnimal;
use common\models\trierror\form\ErrorLogForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use common\models\notification\FrontendNotification;
use common\models\park\SafariPark;
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
        $model = new GmailLoginForm();
        $model->scenario = 'sendmail';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $post_data = $this->request->post('GmailLoginForm');
                    $emailid = $post_data['email_id'];

                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $randomString = '';

                    $passcode = rand();
                    $n = 10;
                    for ($i = 0; $i < $n; $i++) {
                        $index = rand(0, strlen($characters) - 1);
                        $randomString .= $characters[$index];
                    }
                    $passcode = $randomString;
                    $code = $emailid . "****" . $passcode;
                    $code = base64_encode($code);

                    //code to send mail
                    /*
                    Yii::$app->mailer->compose()
                        ->setFrom('no-reply@walkintothewild.in')
                        ->setTo($post_data['email_id'])
                        ->setSubject('your code for login is : ' . $passcode)
                        ->setHtmlBody('your code for login is : ' . $passcode)
                        ->send();
                    */


                    Yii::$app->mailer->compose(['html' => 'gmailLoginCode-html', 'text' => 'gmailLoginCode-text'], ['passcode' => $passcode])
                        ->setFrom('no-reply@walkintothewild.in')
                        ->setTo($post_data['email_id'])
                        ->setSubject('Send code for login ' . Yii::$app->name)
                        ->send();

                    return Yii::$app->response->redirect("/site/verify/" . $code);
                }
            }
        }

        return $this->render('new_login_form', [
            'model' => $model,
        ]);
    }

    public function actionLoginNewVerify($passcode)
    {
        if (empty($passcode)) {
            return $this->redirect('/park');
        }

        $temp = base64_decode($passcode);
        $temp_data = explode("****", $temp);
        if (empty($temp_data[1])) {
            return $this->redirect('/');
        }

        $model = new GmailLoginForm();
        $model->email_id = $temp_data[0];
        $model->pass_code = $temp_data[1];
        $model->scenario = 'matchcode';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $post_data = $this->request->post('GmailLoginForm');

                    $user = User::findOne(['email' => $post_data['email_id']]);

                    if (empty($user)) {
                        // create new user
                        $password = Yii::$app->security->generateRandomString(6);

                        $user = new User();
                        $user->name = $post_data['email_id'];
                        $user->username = $post_data['email_id'];
                        $user->email = $post_data['email_id'];
                        $user->password = $password;
                        $user->status = User::STATUS_ACTIVE;

                        $user->generateAuthKey();
                        //$user->generatePasswordResetToken();

                        if ($user->save()) {
                            $this->loginUser($user);
                            return $this->redirect('/');
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save user: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($user->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        //make user login and redirect to home page
                        $this->loginUser($user);
                        return $this->redirect('/');
                    }
                }
            }
        }

        return $this->render('verify_login_form', [
            'model' => $model,
        ]);
    }


    /**
     * Get Animal List
     */
    public function actionGetanimal($text = '')
    {
        $fordorp_item = '';
        $animallist = '';
        if ($text <> '') {
            $animals = MasterAnimal::find()
                ->where(['is_searchable' => 1, 'status' => 1, 'animal_type' => [MasterAnimal::USUAL_ANIMAL_TYPE, MasterAnimal::RARE_ANIMAL_TYPE]])
                ->andFilterWhere(['like', 'name', $text])
                ->all();
            // $fordorp_item .= '<div class="dropdown-item" data-value="">Any / All</div>';
            $animallist .= "<option value=''></option>";
            foreach ($animals as $animal) {
                $fordorp_item .= "<div class='dropdown-item' data-value='$animal->id'>$animal->name </div>";
                $animallist .= "<option value='" . $animal->id . "'>" . $animal->name . "</option>";
            }
        } else {
            $animalfilteroption = GeneralModel::animalfilteroption();
            // $fordorp_item .= '<div class="dropdown-item" data-value="">Any / All</div>';
            $animallist .= "<option value=''></option>";
            foreach ($animalfilteroption as $value => $label) {
                $fordorp_item .= "<div class='dropdown-item' data-value='$value'>$label </div>";
                $animallist .= "<option value='" . $value . "'>" . $label . "</option>";
            }
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['fordorp_item' => $fordorp_item, 'animallist' => $animallist];
    }


    public function actionGetpark($text = '')
    {
        $fordorp_item = '';
        // $parklist = '';
        if ($text <> '') {
            $parks = SafariPark::find()
                ->where(['status' => SafariPark::STATUS_ACTIVE, 'show_in_filter' => 1])
                ->andFilterWhere(['like', 'title', $text])
                ->all();

            // $parklist .= "<option value=''></option>";
            foreach ($parks as $park) {
                $fordorp_item .= "<div class='dropdown-item park_dropdown_item' data-value='$park->slug'>$park->title </div>";
                // $parklist .= "<option value='" . $park->slug . "'>" . $park->title . "</option>";
            }
        } else {
            $parkoptions = GeneralModel::safariparklist('slug');
            // $parklist .= "<option value=''></option>";
            foreach ($parkoptions as $value => $label) {
                $fordorp_item .= "<div class='dropdown-item park_dropdown_item'  data-value='$value'>$label </div>";
                // $parklist .= "<option value='" . $value . "'>" . $label . "</option>";
            }
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['fordorp_item' => $fordorp_item];
    }
}
