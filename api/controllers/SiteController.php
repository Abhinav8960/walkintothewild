<?php

namespace api\controllers;

use Yii;
use yii\filters\AccessControl;

use api\behaviours\Verbcheck;
use api\behaviours\Apiauth;
use api\models\CanSocialLoginForm;
use api\models\cms\contentmanagement\ContentManagement;
use api\models\MasterMetaTableInfoSearch;
use api\models\OtpVerificationSocialLoginForm;
use api\models\SocialLoginForm;
use api\models\VerifySocialLoginForm;
use common\models\AccessTokens;
use common\models\Auth;
use common\models\User;
use common\models\UserSession;
use common\models\WhatsappHelper;
use yii\httpclient\debug\SearchModel;

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
                'exclude' => ['social-login', 'verify-social-login', 'can-social-login', 'otp-verification-social-login', 'master-meta-info', 'termofuse', 'privacypolicy', 'error', 'convergent-survey'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'profile', 'update-token'],
                'rules' => [
                    [
                        'actions' => ['logout', 'profile', 'update-token'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'social-login', 'verify-social-login', 'can-social-login', 'otp-verification-social-login', 'error'],
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
                    'termofuse' => ['GET'],
                    'privacypolicy' => ['GET'],
                    'update-token' => ['POST'],
                    'convergent-survey' => ['GET'],
                    'can-social-login' => ['POST'],
                    'verify-social-login' => ['POST'],

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
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->statusCode = $exception->statusCode ?? 500;
            $data = [
                // 'status' => $exception->statusCode ?? 500,
                "name"  => ($exception instanceof \Exception || $exception instanceof \ErrorException) ? $exception->getName() : 'Exception',
                'message' => $exception->getMessage(),
                "code"  => $exception->getCode(),
                "type"  => get_class($exception),
                "file"  => $exception->getFile(),
                "line"  => $exception->getLine(),
                // "stack-trace"  => $exception->getTrace(),
            ];
            return Yii::$app->api->sendResponse($data, NULL, $exception->statusCode ?? 500);
        }
    }

    public function actionMasterMetaInfo()
    {
        $searchModel = new MasterMetaTableInfoSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = "master_meta_table_info");
    }


    public function actionSocialLogin()
    {
        //   return  \common\broadcast\services\BroadcastService::BroadcastEvent(new \common\events\user\NewUserRegistration(1, 'user@example.com', 'John Doe', '1234567890'), true);
        // return  new \common\events\user\NewUserRegistration(748, 'anurag@triline.co.in', 'Anurag Kumar Yadav');


        $model = new SocialLoginForm();

        $model->attributes = $this->request;

        if ($model->validate()) {
            /* @var Auth $auth */
            $user_form = new User();
            if ($user_form->hasAttribute($model->source . '_source_id')) {

                if (!in_array($model->source, ['google', 'apple'])) {
                    return Yii::$app->api->sendFailedStringResponse(['You are not register with us, check source']);
                }

                

                $auth = Auth::find()->where([
                    'source' => $model->source,
                    'source_id' => $model->source_id,
                ])->one();



                if ($auth && $model->apiLogin()) { // login
                    /* @var User $user */
                    if ($auth->user->status != User::STATUS_ACTIVE) {
                        return Yii::$app->api->sendFailedStringResponse(['Profile is not active, contact administration!!']);
                    }
                    $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($auth->user->username), $model);
                    // $model->UserSession($accesstoken);
                    $data = [];
                    // $data['authorization_code'] = $auth_code;
                    $data['access_token'] = $accesstoken->token;
                    // $data['expires_at'] = $accesstoken->expires_at;
                    return \Yii::$app->api->sendResponse($data);
                    // $this->updateUserInfo($user);
                } else {

                    if ($model->email !== null && User::find()->where(['email' => $model->email])->exists()) {

                        $user = User::find()->where(['email' => $model->email, $model->source . '_source_id' => $model->source_id, 'status' => User::STATUS_ACTIVE])->one();
                        // $saveuser =  $user->updateAttributes([$model->source . '_source_id' => $model->source_id]);


                        if ($user = User::find()->where(['email' => $model->email, $model->source . '_source_id' => $model->source_id, 'status' => User::STATUS_ACTIVE])->one()) {
                            if ($user->status != User::STATUS_ACTIVE) {
                                return Yii::$app->api->sendFailedStringResponse(['Profile is not active, contact administration!!']);
                            }

                            $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
                            $data = [];
                            // $data['authorization_code'] = $auth_code;
                            $data['access_token'] = $accesstoken->token;
                            // $data['expires_at'] = $accesstoken->expires_at;
                            return \Yii::$app->api->sendResponse($data);
                        } else {
                            $user = User::find()->where(['email' => $model->email, 'status' => User::STATUS_ACTIVE])->one();

                            $source_id_col = strtolower($model->source . '_source_id');
                            if (!empty($user->$source_id_col)) {
                                return Yii::$app->api->sendFailedStringResponse(['Source id is already available in records and not matching with given']);
                            }
                            $user->$source_id_col  = $model->source_id;
                            $user->status = User::STATUS_ACTIVE;
                            $user->save(false);
                            $auth = new Auth([
                                'user_id' => $user->id,
                                'source' => $model->source,
                                'source_id' => $model->source_id,
                            ]);
                            $auth->save();
                            $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
                            $data = [];
                            // $data['authorization_code'] = $auth_code;
                            $data['access_token'] = $accesstoken->token;
                            return \Yii::$app->api->sendResponse($data);
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
                        $source_id_col = strtolower($model->source . '_source_id');
                        $user->$source_id_col  = $model->source_id;
                        $user->status = User::STATUS_ACTIVE;
                        $user->save();
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



                return  Yii::$app->api->sendFailedStringResponse(['you are not register with us, check source']);
            }
        } else {
            return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }
    }

    public function actionCanSocialLogin()
    {
        $model = new CanSocialLoginForm();

        $model->attributes = $this->request;

        if ($model->validate()) {
            if ($model->can_login()) {
                $data = ['can_login' => true];
            }
            $data = ['can_login' => false];
        } else {
            return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }
        return Yii::$app->api->sendResponse($data);
    }

    public function actionVerifySocialLogin()
    {
        $model = new VerifySocialLoginForm();

        $model->attributes = $this->request;

        if ($model->validate()) {

            if (!$model->can_login()) {

                if ($model->verify_login()) {
                    $data = ['can_login' => false, 'is_otp_send' => true, 'otp'=>$model->otp];
                    return Yii::$app->api->sendResponse($data);
                }
                $data = ['can_login' => false, 'is_otp_send' => false];
                return Yii::$app->api->sendResponse($data);
            }
            $data = ['can_login' => true];
            return Yii::$app->api->sendResponse($data);
        } else {
            return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }
        return Yii::$app->api->sendResponse($data);
    }

    public function actionOtpVerificationSocialLogin()
    {
        $model = new OtpVerificationSocialLoginForm();

        $model->attributes = $this->request;

        if ($model->validate()) {
            if($model->validateOtp()){

                $data = ['can_login' => true];
                return Yii::$app->api->sendResponse($data);
            }
            $data = ['can_login' => false, "message"=>"Otp Not matched"];


        } else {
            return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }
        return Yii::$app->api->sendResponse($data);
    }

    // public function actionOtpVerificationSocialLogin()
    // {
    //     $model = new VerifySocialLoginForm();

    //     $model->attributes = $this->request;

    //     if ($model->validate()) {
    //         if ($model->can_login()) {
    //             $data = ['can_login' => true];
    //         }

    //         $data = ['can_login' => false, 'is_otp_send' => true];
    //     } else {
    //         return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    //     }
    //     return Yii::$app->api->sendResponse($data);
    // }


    public function actionProfile()
    {
        $this->layout = \common\interfaces\NewStatusInterface::USER_API_LAYOUT_FULL;

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



        return \Yii::$app->api->sendResponse($data);
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

            return Yii::$app->api->sendResponse($data = [], ['message' => "Logged Out Successfully"]);
        } else {
            return Yii::$app->api->sendResponse([], "Invalid Request");
        }
    }


    public function actionTermofuse()
    {
        $term_of_use = ContentManagement::findOne(['id' => ContentManagement::CM_TERM_AND_CONDITION]);
        if ($term_of_use) {
            return \Yii::$app->api->sendResponse($data = ['content' => $term_of_use->content], ['message' => "Success"]);
        }
        return Yii::$app->api->sendResponse($data = [], ['message' => "Not Found"]);
    }

    public function actionPrivacypolicy()
    {
        $privacy_policy = ContentManagement::findOne(['id' => ContentManagement::CMS_PRIVACY_POLICY]);
        if ($privacy_policy) {
            return \Yii::$app->api->sendResponse($data = ['content' => $privacy_policy->content], ['message' => "Success"]);
        }
        return Yii::$app->api->sendResponse($data = [], ['message' => "Not Found"]);
    }
    public function actionUpdateToken($firebase_token, $old_firebase_token)
    {
        if ($this->access_token) {
            $model = UserSession::find()->where(['token' => $this->access_token, 'old_firebase_token' => $old_firebase_token])->limit(1)->one();
            if ($model) {
                $model->firebase_token = $firebase_token;
                $model->is_firebase_token_active = true;
                $model->save(false);
                return Yii::$app->api->sendResponse($data = [], ['message' => "Update Successfully"]);
            }
            return Yii::$app->api->sendResponse([], "Not Found");
        }
        return Yii::$app->api->sendResponse([], "Invalid Request");
    }


    public function actionConvergentSurvey($phone, $case_id)
    {
        $response = WhatsappHelper::SendDataUsingWithTemplateSurvey($phone, $case_id);

        if ($response->isOk) {
            return Yii::$app->api->sendResponse(['status' => 1, 'response' => $response->getData()], ['message' => 'Message accepted Successfully, if contact number has whatsaapp account, it will deliver soon']);
        }

        return Yii::$app->api->sendResponse(['status' => 0, 'response' => $response->getData()], ['message' => 'Message Sending Failed']);
    }
}
