<?php

namespace api\controllers;

use Yii;
use yii\filters\AccessControl;

use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use api\models\SocialLoginForm;
use common\models\AccessTokens;
use common\models\Auth;
use common\models\User;
use common\models\UserSession;

/**
 * Site controller
 */
class SiteController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['social-login'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'profile'],
                'rules' => [
                    [
                        'actions' => ['logout', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'social-login'],
                        'allow' => true,
                        'roles' => ['*'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'logout' => ['POST', 'GET'],
                    'profile' => ['GET'],
                    'social-login' => ['POST'],

                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            // 'error' => [
            //     'class' => 'yii\web\ErrorAction',
            // ],
            'file' => [
                'class' => \diecoding\flysystem\actions\FileAction::class,
                // 'component' => 'fs',
            ],
        ];
    }


    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }


    public function actionSocialLogin()
    {

        $model = new SocialLoginForm();

        $model->attributes = $this->request;

        if ($model->validate()) {
            /* @var Auth $auth */
            $user_form = new User();
            if ($user_form->hasAttribute($model->source . '_source_id')) {


                $auth = Auth::find()->where([
                    'source' => $model->source,
                    'source_id' => $model->source_id,
                ])->one();

                if ($auth && $model->apiLogin()) { // login
                    /* @var User $user */
                   
                    $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($auth->user->username), $model);
                    // $model->UserSession($accesstoken);
                    $data = [];
                    // $data['authorization_code'] = $auth_code;
                    $data['access_token'] = $accesstoken->token;

                    // $data['expires_at'] = $accesstoken->expires_at;

                    \Yii::$app->api->sendResponse($data);
                    // $this->updateUserInfo($user);
                } else {

                    if ($model->email !== null && User::find()->where(['email' => $model->email])->exists()) {


                        $user = User::find()->where(['email1' => $model->email])->one();
                        // $saveuser =  $user->updateAttributes([$model->source . '_source_id' => $model->source_id]);

                       
                        if ($user) {

                            $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
                            $data = [];
                            // $data['authorization_code'] = $auth_code;
                            $data['access_token'] = $accesstoken->token;
                            // $data['expires_at'] = $accesstoken->expires_at;



                            \Yii::$app->api->sendResponse($data);
                        } else {

                            Yii::$app->api->sendFailedResponse([], "Source id is already available in records and not matching with given");
                        }
                    } else {

                        // Yii::$app->api->sendFailedResponse([], "you are not register with us.");

                        $user = new User();
                        $user->setPassword(rand(10000000, 99999999));
                        $user->generateAuthKey();
                        $user->generateEmailVerificationToken();

                        $user->name = isset($model->name) ? $model->name : NULL;
                        $user->username = $model->email;
                        $user->email = $model->email;
                        $user->avatar = $model->avatar;
                        $user->google_source_id = $model->source_id;
                        $user->status = User::STATUS_ACTIVE;
                        $user->save(false);
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $model->source,
                            'source_id' => $model->source_id,
                        ]);
                        $auth->save();




                        return $this->actionSocialLogin();
                    }
                }
            } else {



                Yii::$app->api->sendFailedResponse([], "you are not register with us, check source");
            }
        } else {
            Yii::$app->api->sendFailedResponse($model->errors);
        }
    }


    public function actionProfile()
    {



        $data = [];
        $data['user'] = $this->userinfo;
        unset($data['user']['auth_key']);
        unset($data['user']['password_hash']);
        // unset($data['user']['password_reset_token']);
        // unset($data['user']['password_reset_token_issue_at']);
        unset($data['user']['verification_token']);
        unset($data['user']['created_at']);
        unset($data['user']['updated_at']);

        // unset($data['user']['can_access_main_operation']);
        // unset($data['user']['can_access_cms']);
        // unset($data['user']['can_access_content']);
        // unset($data['user']['can_access_portal_settings']);
        // unset($data['user']['can_access_user']);
        // unset($data['user']['status']);



        \Yii::$app->api->sendResponse($data);
    }

    public function actionLogout()
    {
        $headers = Yii::$app->getRequest()->getHeaders();
        $access_token = $headers->get('x-access-token');

        if (!$access_token) {
            $access_token = Yii::$app->getRequest()->getQueryParam('access-token');
        }

        $model = UserSession::findOne(['token' => $access_token]);

        if ($model->delete()) {

            Yii::$app->api->sendResponse($data = [], ['message' => "Logged Out Successfully"]);
        } else {
            Yii::$app->api->sendResponse([], "Invalid Request");
        }
    }
}
