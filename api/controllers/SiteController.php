<?php

namespace api\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\models\cms\contentmanagement\ContentManagement;
use api\models\operator\SafariOperator;
use api\models\CanSocialLoginForm;
use api\models\MasterMetaTableInfoSearch;
use api\models\OtpVerificationSocialLoginForm;
use api\models\SignupForm;
use api\models\SocialLoginForm;
use api\models\UserMobileNoVerificationForm;
use api\models\VerifySocialLoginForm;
use common\models\operator\SafariOperator as OperatorSafariOperator;
use common\models\AccessTokens;
use common\models\Auth;
use common\models\User;
use common\models\UserDeleteRequest;
use common\models\UserDeleteRequestForm;
use common\models\UserSession;
use common\models\WhatsappHelper;
use yii\filters\AccessControl;
use yii\httpclient\debug\SearchModel;
use Yii;

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
                'exclude' => ['social-login', 'verify-social-login', 'can-social-login', 'reset-social-login', 'otp-verification-social-login', 'master-meta-info', 'termofuse', 'privacypolicy', 'refundpolicy', 'cancellation', 'error', 'convergent-survey', 'report-page-reason', 'test','signup'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'profile', 'update-token', 'mobile-no-verification', 'verify-mobile-no', 'deactivate-account', 'request-delete-account'],
                'rules' => [
                    [
                        'actions' => ['logout', 'profile', 'update-token', 'deactivate', 'mobile-no-verification', 'verify-mobile-no', 'deactivate-account', 'request-delete-account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'social-login', 'verify-social-login', 'can-social-login', 'reset-social-login', 'otp-verification-social-login', 'error', 'test','signup'],
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
                    'reset-social-login' => ['POST'],
                    'deactivate' => ['POST'],
                    'mobile-no-verification' => ['POST'],
                    'verify-mobile-no' => ['POST'],
                    'deactivate-account' => ['POST'],
                    'delete-account' => ['POST'],
                    'report-page-reason' => ['GET'],
                    'test' => ['GET'],
                    'refundpolicy' => ['GET'],
                    'cancellation' => ['GET'],
                    'signup' =>['POST'],
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
                'name' => ($exception instanceof \Exception || $exception instanceof \ErrorException) ? $exception->getName() : 'Exception',
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'type' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                // "stack-trace"  => $exception->getTrace(),
            ];
            return Yii::$app->api->sendResponse($data, null, $exception->statusCode ?? 500);
        }
    }

    public function actionMasterMetaInfo()
    {
        $searchModel = new MasterMetaTableInfoSearch();
        return $this->dataProviderSenderWithoutPagination($searchModel, $rootIndexName = 'master_meta_table_info');
    }

    public function actionSocialLogin()
    {
        $model = new SocialLoginForm();
        $model->attributes = $this->request;

        if ($model->validate()) {
            $user_form = new User();
            $source_id_col = strtolower($model->source . '_source_id');

            // Check if the column exists in the User model
            if (!$user_form->hasAttribute($source_id_col)) {
                return Yii::$app->api->sendFailedStringResponse(['The source not exist.'], 400);
            }

            $user = User::find()->where([$source_id_col => $model->source_id])->one();

            if ($user) {
                if ($user->status != User::STATUS_ACTIVE) {
                    return Yii::$app->api->sendFailedStringResponse(['Profile is not active, contact administration!!'], 423);
                }

                $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
                $data = ['access_token' => $accesstoken->token];
                return Yii::$app->api->sendResponse($data);
            } else {
                if ($model->email !== null && User::find()->where(['email' => $model->email])->exists()) {
                    $user = User::find()->where(['email' => $model->email, 'status' => User::STATUS_ACTIVE])->one();

                    if (!empty($user->$source_id_col)) {
                        return Yii::$app->api->sendFailedStringResponse(['Source ID is already available in records and not matching with given']);
                    }

                    $user->$source_id_col = $model->source_id;
                    $user->status = User::STATUS_ACTIVE;
                    $user->save(false);

                    $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
                    $data = ['access_token' => $accesstoken->token];
                    return Yii::$app->api->sendResponse($data);
                } else {
                    $user = new User();
                    $user->setPassword(rand(10000000, 99999999));
                    $user->generateAuthKey();
                    $user->generateEmailVerificationToken();

                    $user->name = $model->name ?? null;
                    $user->username = $model->email;
                    $user->email = $model->email;
                    // $user->avatar = $model->avatar;
                    $user->$source_id_col = $model->source_id;
                    $user->status = User::STATUS_ACTIVE;
                    $user->save();

                    $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
                    $data = ['access_token' => $accesstoken->token];
                    return Yii::$app->api->sendResponse($data);
                }
            }
        } else {
            return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }
    }

    // public function actionSocialLogin()
    // {
    //     //   return  \common\broadcast\services\BroadcastService::BroadcastEvent(new \common\events\user\NewUserRegistration(1, 'user@example.com', 'John Doe', '1234567890'), true);
    //     // return  new \common\events\user\NewUserRegistration(748, 'anurag@triline.co.in', 'Anurag Kumar Yadav');
    //     // return  new \common\events\user\MobileNoVerification(748, '9650901148', '123456', 'Anurag Kumar Yadav');

    //     $model = new SocialLoginForm();

    //     $model->attributes = $this->request;

    //     if ($model->validate()) {
    //         /* @var Auth $auth */
    //         $user_form = new User();
    //         if ($user_form->hasAttribute($model->source . '_source_id')) {

    //             if (!in_array($model->source, ['google', 'apple'])) {
    //                 return Yii::$app->api->sendFailedStringResponse(['You are not register with us, check source']);
    //             }

    //             $auth = Auth::find()->where([
    //                 'source' => $model->source,
    //                 'source_id' => $model->source_id,
    //             ])->one();

    //             if ($auth && $model->apiLogin()) { // login
    //                 /* @var User $user */
    //                 if ($auth->user->status != User::STATUS_ACTIVE) {
    //                     return Yii::$app->api->sendFailedStringResponse(['Profile is not active, contact administration!!'], 423);
    //                 }
    //                 $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($auth->user->username), $model);
    //                 // $model->UserSession($accesstoken);
    //                 $data = [];
    //                 // $data['authorization_code'] = $auth_code;
    //                 $data['access_token'] = $accesstoken->token;
    //                 // $data['expires_at'] = $accesstoken->expires_at;
    //                 return \Yii::$app->api->sendResponse($data);
    //                 // $this->updateUserInfo($user);
    //             } else {

    //                 if ($model->email !== null && User::find()->where(['email' => $model->email])->exists()) {

    //                     $user = User::find()->where(['email' => $model->email, $model->source . '_source_id' => $model->source_id, 'status' => User::STATUS_ACTIVE])->one();
    //                     // $saveuser =  $user->updateAttributes([$model->source . '_source_id' => $model->source_id]);

    //                     if ($user = User::find()->where(['email' => $model->email, $model->source . '_source_id' => $model->source_id, 'status' => User::STATUS_ACTIVE])->one()) {
    //                         if ($user->status != User::STATUS_ACTIVE) {
    //                             return Yii::$app->api->sendFailedStringResponse(['Profile is not active, contact administration!!'], 423);
    //                         }

    //                         $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
    //                         $data = [];
    //                         // $data['authorization_code'] = $auth_code;
    //                         $data['access_token'] = $accesstoken->token;
    //                         // $data['expires_at'] = $accesstoken->expires_at;
    //                         return \Yii::$app->api->sendResponse($data);
    //                     } else {
    //                         $user = User::find()->where(['email' => $model->email, 'status' => User::STATUS_ACTIVE])->one();

    //                         $source_id_col = strtolower($model->source . '_source_id');
    //                         if (!empty($user->$source_id_col)) {
    //                             return Yii::$app->api->sendFailedStringResponse(['Source id is already available in records and not matching with given']);
    //                         }
    //                         $user->$source_id_col  = $model->source_id;
    //                         $user->status = User::STATUS_ACTIVE;
    //                         $user->save(false);
    //                         $auth = new Auth([
    //                             'user_id' => $user->id,
    //                             'source' => $model->source,
    //                             'source_id' => $model->source_id,
    //                         ]);
    //                         $auth->save();
    //                         $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
    //                         $data = [];
    //                         // $data['authorization_code'] = $auth_code;
    //                         $data['access_token'] = $accesstoken->token;
    //                         return \Yii::$app->api->sendResponse($data);
    //                     }
    //                 } else {

    //                     // Yii::$app->api->sendFailedResponse([], "you are not register with us.");

    //                     $user = new User();
    //                     $user->setPassword(rand(10000000, 99999999));
    //                     $user->generateAuthKey();
    //                     $user->generateEmailVerificationToken();

    //                     $user->name = isset($model->name) ? $model->name : NULL;
    //                     $user->username = $model->email;
    //                     $user->email = $model->email;
    //                     $user->avatar = $model->avatar;
    //                     $source_id_col = strtolower($model->source . '_source_id');
    //                     $user->$source_id_col  = $model->source_id;
    //                     $user->status = User::STATUS_ACTIVE;
    //                     $user->save();
    //                     $auth = new Auth([
    //                         'user_id' => $user->id,
    //                         'source' => $model->source,
    //                         'source_id' => $model->source_id,
    //                     ]);
    //                     $auth->save();

    //                     return $this->actionSocialLogin();
    //                 }
    //             }
    //         } else {

    //             return  Yii::$app->api->sendFailedStringResponse(['you are not register with us, check source']);
    //         }
    //     } else {
    //         return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    //     }
    // }

    public function actionResetSocialLogin()
    {
        $model = new CanSocialLoginForm();

        $model->attributes = $this->request;

        if ($model->validate()) {
            if ($model->reset_login()) {
                $data = ['is_reset' => true, 'can_login' => false];
                return Yii::$app->api->sendResponse($data);
            }
            $data = ['is_reset' => false, 'can_login' => true];
        } else {
            return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }
        return Yii::$app->api->sendResponse($data);
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
                    $data = ['can_login' => false, 'is_otp_send' => true, 'otp' => $model->otp];
                    // $data = ['can_login' => false, 'is_otp_send' => true];
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
            if ($model->validateOtp()) {
                $data = ['can_login' => true];
                return Yii::$app->api->sendResponse($data);
            }
            $data = ['can_login' => false, 'message' => 'Otp Not matched'];
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
            return Yii::$app->api->sendResponse($data = [], ['message' => 'Logged Out Successfully']);
        } else {
            return Yii::$app->api->sendResponse([], 'Invalid Request');
        }
    }

    public function actionTermofuse()
    {
        $term_of_use = ContentManagement::findOne(['id' => ContentManagement::CM_TERM_AND_CONDITION]);
        if ($term_of_use) {
            return \Yii::$app->api->sendResponse($data = ['content' => $term_of_use->content], ['message' => 'Success']);
        }
        return Yii::$app->api->sendResponse($data = [], ['message' => 'Not Found']);
    }

    public function actionPrivacypolicy()
    {
        $privacy_policy = ContentManagement::findOne(['id' => ContentManagement::CMS_PRIVACY_POLICY]);
        if ($privacy_policy) {
            return \Yii::$app->api->sendResponse($data = ['content' => $privacy_policy->content], ['message' => 'Success']);
        }
        return Yii::$app->api->sendResponse($data = [], ['message' => 'Not Found']);
    }

    public function actionRefundpolicy()
    {
        $refund_policy = ContentManagement::findOne(['id' => ContentManagement::CMS_REFUND_POLICY]);
        if ($refund_policy) {
            return \Yii::$app->api->sendResponse($data = ['content' => $refund_policy->content], ['message' => 'Success']);
        }
        return Yii::$app->api->sendResponse($data = [], ['message' => 'Not Found']);
    }

    public function actionCancellation()
    {
        $cancellation = ContentManagement::findOne(['id' => ContentManagement::CMS_CANCELLATION]);
        if ($cancellation) {
            return \Yii::$app->api->sendResponse($data = ['content' => $cancellation->content], ['message' => 'Success']);
        }
        return Yii::$app->api->sendResponse($data = [], ['message' => 'Not Found']);
    }

    public function actionUpdateToken($firebase_token, $old_firebase_token)
    {
        if ($this->access_token) {
            $model = UserSession::find()->where(['token' => $this->access_token, 'firebase_token' => $old_firebase_token])->limit(1)->one();
            if ($model) {
                $model->firebase_token = $firebase_token;
                $model->is_firebase_token_active = true;
                $model->save(false);
                return Yii::$app->api->sendResponse($data = [], ['message' => 'Update Successfully']);
            }
            return Yii::$app->api->sendResponse([], 'Not Found');
        }
        return Yii::$app->api->sendResponse([], 'Invalid Request');
    }

    public function actionConvergentSurvey($phone, $case_id)
    {
        $response = WhatsappHelper::SendDataUsingWithTemplateSurvey($phone, $case_id);

        if ($response->isOk) {
            return Yii::$app->api->sendResponse(['status' => 1, 'response' => $response->getData()], ['message' => 'Message accepted Successfully, if contact number has whatsaapp account, it will deliver soon']);
        }

        return Yii::$app->api->sendResponse(['status' => 0, 'response' => $response->getData()], ['message' => 'Message Sending Failed']);
    }

    public function actionDeactivate()
    {
        $user_model = $this->userinfo;
        if ($user_model) {
            $user_model->status = User::STATUS_DELETED;
            if ($user_model->save(false)) {
                $safari_operator = SafariOperator::find()->where(['user_id' => $user_model->id])->limit(1)->one();
                if ($safari_operator) {
                    $safari_operator->status = SafariOperator::STATUS_DELETE;
                    $safari_operator->save(false);
                }
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Deactivated Successfully']);
            }
        }
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Not Deactivated Successfully']);
    }

    public function actionMobileNoVerification()
    {
        $user_model = $this->userinfo;

        $model = new UserMobileNoVerificationForm();
        $model->attributes = $this->request;

        if ($user_model->is_mobile_no_verified == true && $user_model->mobile_no == $model->mobile_no) {
            $headers = Yii::$app->response->headers;
            if (!$headers->has('X-Rate-Limit-Remaining')) {
                $headers->add('X-Rate-Limit-Remaining', 0);
            }
            if (!$headers->has('X-Rate-Limit-Reset')) {
                $headers->add('X-Rate-Limit-Reset', time() + 3600);  // Reset after 1 hour
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Mobile No already Verified']);
        }

        $cache = Yii::$app->cache;
        $rateLimitKey = 'mobile_verification_' . $user_model->id;
        $rateLimitDuration = 3600;  // 1 hour in seconds
        $rateLimitMaxRequests = 6;  // Maximum allowed requests in the time window
        $blockDuration = 10800;  // 3 hours in seconds

        // Check rate limit
        $requestCount = $cache->get($rateLimitKey);
        $headers = Yii::$app->response->headers;

        if ($requestCount === false) {
            $cache->set($rateLimitKey, 1, $rateLimitDuration);
            if (!$headers->has('X-Rate-Limit-Remaining')) {
                $headers->add('X-Rate-Limit-Remaining', $rateLimitMaxRequests - 1);
            }
            if (!$headers->has('X-Rate-Limit-Reset')) {
                $headers->add('X-Rate-Limit-Reset', time() + $rateLimitDuration);
            }
        } elseif ($requestCount >= $rateLimitMaxRequests) {
            $blockKey = 'mobile_verification_block_' . $user_model->id;
            $blockStatus = $cache->get($blockKey);

            if ($blockStatus === false) {
                $cache->set($blockKey, true, $blockDuration);
            }
            if (!$headers->has('Retry-After')) {
                $headers->add('Retry-After', $blockDuration);
            }
            if (!$headers->has('X-Rate-Limit-Remaining')) {
                $headers->add('X-Rate-Limit-Remaining', 0);
            }
            if (!$headers->has('X-Rate-Limit-Reset')) {
                $headers->add('X-Rate-Limit-Reset', time() + $blockDuration);
            }
            // return Yii::$app->api->sendFailedStringResponse(['Rate limit exceeded. Please try again later.'], 429);
            return Yii::$app->api->sendResponse($data = [], ['message' => 'Rate limit exceeded. Please try again later.'], 429);
        } else {
            $remainingRequests = $rateLimitMaxRequests - $requestCount - 1;
            $cache->set($rateLimitKey, $requestCount + 1, $rateLimitDuration);
            if (!$headers->has('X-Rate-Limit-Remaining')) {
                $headers->add('X-Rate-Limit-Remaining', max($remainingRequests, 0));  // Ensure it doesn't go below 0
            }
            if (!$headers->has('X-Rate-Limit-Reset')) {
                $headers->add('X-Rate-Limit-Reset', time() + $rateLimitDuration);
            }
        }

        if ($model->validate()) {
            $remainingRequests = $rateLimitMaxRequests - $requestCount - 1;
            if (!$headers->has('X-Rate-Limit-Remaining')) {
                $headers->add('X-Rate-Limit-Remaining', max($remainingRequests, 0));  // Ensure it doesn't go below 0
            }
            if (!$headers->has('X-Rate-Limit-Reset')) {
                $headers->add('X-Rate-Limit-Reset', time() + $rateLimitDuration);
            }
            $model->proceedforverification($this->auth_token, $user_model);

            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Otp Sent on your mobile no, please check your mobile.']);
        }

        if ($model->hasErrors()) {
            return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }
    }

    // public function actionMobileNoVerification()
    // {
    //     $user_model = $this->userinfo;
    //     // if ($user_model->is_mobile_no_verified == true) {
    //     //     return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Mobile No aleady Verified"]);
    //     // }
    //     $model = new UserMobileNoVerificationForm();
    //     $model->attributes = $this->request;
    //     if ($user_model->is_mobile_no_verified == true && $user_model->mobile_no == $model->mobile_no) {
    //         return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Mobile No aleady Verified"]);
    //     }
    //     if ($model->validate()) {
    //         $model->proceedforverification($this->auth_token, $user_model);

    //         return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Otp Sent on your mobile no, please check your mobile."]);
    //     }
    //     if ($model->hasErrors()) {
    //         return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    //     }
    // }

    public function actionVerifyMobileNo()
    {
        $user_model = $this->userinfo;
        // if ($user_model->is_mobile_no_verified == true) {
        //     return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Mobile No aleady Verified"]);
        // }
        $model = new UserMobileNoVerificationForm();
        $model->scenario = 'validateOtp';
        $model->attributes = $this->request;
        if ($user_model->is_mobile_no_verified == true && $user_model->mobile_no == $model->mobile_no) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Mobile No aleady Verified']);
        }
        if ($model->validate()) {
            if ($model->validateOtp($this->auth_token)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Mobile No Verified Successfully']);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Mobile No  not verified, check mobile no and otp.']);
        }
        if ($model->hasErrors()) {
            return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
        }
    }

    public function actionReportPageReason()
    {
        return [
            '1' => 'Scam,Fraud, or False Information',
            'spam' => [
                '21' => 'Me',
                '22' => 'A business',
                '23' => 'Else',
            ],
            '3' => 'Fake Page',
            '4' => 'Other Form'
        ];
    }

    public function actionDeactivateAccount()
    {
        $user_model = $this->userinfo;
        if ($user_model) {
            $user_model->status = User::STATUS_INACTIVE;
            if ($user_model->save(false)) {
                UserSession::deleteAll(['user_id' => $user_model->id]);
                $op = OperatorSafariOperator::find()->where(['user_id' => $user_model->id])->limit(1)->one();
                if ($op) {
                    $op->status = OperatorSafariOperator::STATUS_SUSPEND;
                    $op->save(false);
                }
                OperatorSafariOperator::updateAll(['status' => OperatorSafariOperator::STATUS_SUSPEND], ['user_id' => $user_model->id]);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Deactivated Successfully, we will miss you.']);
            }
        }
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Not Deactivated Successfully']);
    }

    public function actionRequestDeleteAccount()
    {
        $user_model = $this->userinfo;
        $model = new UserDeleteRequest();
        $model->email = $user_model->email;
        $model->user_id = $user_model->id;
        if ($model->validate()) {
            if ($model->save()) {
                $user_model->status = User::STATUS_INACTIVE;
                $user_model->save(false);
                $op = OperatorSafariOperator::find()->where(['user_id' => $user_model->id])->limit(1)->one();
                if ($op) {
                    $op->status = OperatorSafariOperator::STATUS_SUSPEND;
                    $op->save(false);
                }
                UserSession::deleteAll(['user_id' => $user_model->id]);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => 'Your Information Will be deleted in upcoming 90 Days!!!, we will miss you.']);
            }
        }
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => 'Facing some issue, please try again after a while.']);
    }

    public function actionTest()
    {
        $encrypted = \common\models\GeneralModel::encrypt('53');
        return $encrypted;
        return [];
        return new \common\events\user\MobileNoVerification(748, '9650901148', '123456', 'Anurag Kumar Yadav');
    }

    // public function avatarImageGeneration(User $user)
    // {
    //     if (!empty($user->avatar)) {
    //         $fileName = $user->id . '_google_avatar' . '.jpg';

    //         $url = $user->avatar;
    //         $content = @file_get_contents($url);

    //         if ($content === false) {
    //             return false;
    //         }

    //         $tempPath = tempnam(sys_get_temp_dir(), $user->id . '_google_avatar') . '.jpg';
    //         file_put_contents($tempPath, $content);

    //         $uploadedFile = new \yii\web\UploadedFile([
    //             'name' => $fileName,
    //             'tempName' => $tempPath,
    //             'type' => 'image/jpg',
    //             'size' => filesize($tempPath),
    //             'error' => UPLOAD_ERR_OK,
    //         ]);

    //         $filePath = 'user/profile/' . $fileName;

    //         $avatar_image = \common\Helper\FsHelper::saveUploadedFile($uploadedFile, $filePath, $fileName);

    //         $user->google_avatar_image = $fileName;
    //         $user->save(false);

    //         @unlink($tempPath);
    //     }
    // }

    public function actionSignup()
    {
        print_r('diee');
        die();
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->validate()) {
                return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
            }

            $existingUser = User::find()->where(['email' => $model->email, 'status' => User::STATUS_ACTIVE])->one();
            if ($existingUser !== null) {
                return Yii::$app->api->sendFailedStringResponse(['Email is already registered and active.']);
            }

            if ($user = $model->signup()) {
                $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
                $data = ['access_token' => $accesstoken->token];
                return Yii::$app->api->sendResponse($data);
            } else {
                return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
            }
        } else {
            return Yii::$app->api->sendFailedStringResponse(['Invalid request.'], 400);
        }
    }
}
