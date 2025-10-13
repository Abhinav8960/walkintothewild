<?php

namespace api\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\models\cms\contentmanagement\ContentManagement;
use api\models\operator\SafariOperator;
use api\models\CanSocialLoginForm;
use api\models\compliancedocuments\ComplianceDocuments;
use api\models\LoginForm;
use api\models\MasterMetaTableInfoSearch;
use api\models\OtpVerificationSocialLoginForm;
use api\models\SigninForm;
use api\models\SignupForm;
use api\models\SocialLoginForm;
use api\models\UserMobileNoVerificationForm;
use api\models\VerifySocialLoginForm;
use common\calling\services\CallingService;
use common\models\operator\SafariOperator as OperatorSafariOperator;
use common\models\AccessTokens;
use common\models\Auth;
use common\models\EmailVerification;
use common\models\MobileVerification;
use common\models\SourceVerification;
use common\models\TemporaryUser;
use common\models\User;
use common\models\UserDeleteRequest;
use common\models\UserDeleteRequestForm;
use common\models\UserSession;
use common\models\WhatsappHelper;
use Kreait\Firebase\Auth\SignIn;
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
                'exclude' => ['social-login', 'verify-social-login', 'can-social-login', 'reset-social-login', 'otp-verification-social-login', 'master-meta-info', 'termofuse', 'privacypolicy', 'refundpolicy', 'cancellation', 'error', 'convergent-survey', 'report-page-reason', 'test', 'test-call', 'sign-in-mobile', 'sign-in-email', 'signin-otp-verification', 'regenerate-otp', 'signup', 'signup-otp-verification','refundpolicyantara'],
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
                        'actions' => ['login', 'social-login', 'verify-social-login', 'can-social-login', 'reset-social-login', 'otp-verification-social-login', 'error', 'test', 'test-call', 'sign-in-mobile', 'sign-in-email', 'signin-otp-verification', 'regenerate-otp', 'signup', 'signup-otp-verification'],
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
                    'test-call' => ['POST'],
                    'clear-cache' => ['POST'],


                    'sign-in-mobile' => ['POST'],
                    'sign-in-email' => ['POST'],
                    'signin-otp-verification' => ['POST'],
                    'regenerate-otp' => ['POST'],

                    'signup' => ['POST'],
                    'signup-otp-verification' => ["POST"],
                    'refundpolicyantara' => ['GET'],
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
                $message = Yii::$app->api->messageManager->getMessage('authrization.social_login.source_not_exist');
                return Yii::$app->api->sendFailedStringResponse([$message], 400);
            }

            $user = User::find()->where([$source_id_col => $model->source_id])->one();

            if ($user) {
                if ($user->status != User::STATUS_ACTIVE) {
                    $message = Yii::$app->api->messageManager->getMessage('authrization.social_login.inactive_profile');
                    return Yii::$app->api->sendFailedStringResponse([$message], 423);
                }

                $accesstoken = Yii::$app->api->createAccesstoken(User::findByUsernameFrontend($user->username), $model);
                $data = ['access_token' => $accesstoken->token];
                return Yii::$app->api->sendResponse($data);
            } else {
                if ($model->email !== null && User::find()->where(['email' => $model->email])->exists()) {
                    $user = User::find()->where(['email' => $model->email, 'status' => User::STATUS_ACTIVE])->one();

                    if (!empty($user->$source_id_col)) {
                        $message = Yii::$app->api->messageManager->getMessage('authrization.social_login.source_id_mismatch');
                        return Yii::$app->api->sendFailedStringResponse([$message]);
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
            $message = Yii::$app->api->messageManager->getMessage('common.not_matched_otp');
            $data = ['can_login' => false, "message" => $message];
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
        $data['user'] = $this->userinfo->toArray();
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
            $message = Yii::$app->api->messageManager->getMessage('common.logout_success');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
        } else {
            $message = Yii::$app->api->messageManager->getMessage('common.invalid_request');
            return Yii::$app->api->sendResponse([], $message);
        }
    }

    public function actionTermofuse()
    {
        $term_of_use = ComplianceDocuments::findOne(['id' => ComplianceDocuments::TERM_OF_USE]);
        if ($term_of_use) {
            $message = Yii::$app->api->messageManager->getMessage('common.success');
            return \Yii::$app->api->sendResponse($data = ['content' => $term_of_use->content], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_found');
        return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
    }

    public function actionPrivacypolicy()
    {
        $privacy_policy = ComplianceDocuments::findOne(['id' => ComplianceDocuments::PRIVACY_POLICY]);
        if ($privacy_policy) {
            $message = Yii::$app->api->messageManager->getMessage('common.success');
            return \Yii::$app->api->sendResponse($data = ['content' => $privacy_policy->content], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_found');
        return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
    }

    public function actionRefundpolicy()
    {
        $refund_policy = ComplianceDocuments::findOne(['id' => ComplianceDocuments::REFUND_POLICY]);
        if ($refund_policy) {
            $message = Yii::$app->api->messageManager->getMessage('common.success');
            return \Yii::$app->api->sendResponse($data = ['content' => $refund_policy->content], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_found');
        return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
    }

    public function actionCancellation()
    {
        $cancellation = ContentManagement::findOne(['id' => ContentManagement::CMS_CANCELLATION]);
        if ($cancellation) {
            $message = Yii::$app->api->messageManager->getMessage('common.success');
            return \Yii::$app->api->sendResponse($data = ['content' => $cancellation->content], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_found');
        return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
    }

    public function actionUpdateToken($firebase_token, $old_firebase_token)
    {
        if ($this->access_token) {
            $model = UserSession::find()->where(['token' => $this->access_token, 'firebase_token' => $old_firebase_token])->limit(1)->one();
            if ($model) {
                $model->firebase_token = $firebase_token;
                $model->is_firebase_token_active = true;
                $model->save(false);
                $message = Yii::$app->api->messageManager->getMessage('common.updated');
                return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.not_found');
            return Yii::$app->api->sendResponse([], $message);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.invalid_request');
        return Yii::$app->api->sendResponse([], $message);
    }

    public function actionConvergentSurvey($phone, $case_id)
    {
        $response = WhatsappHelper::SendDataUsingWithTemplateSurvey($phone, $case_id);

        if ($response->isOk) {
            $message = Yii::$app->api->messageManager->getMessage('authrization.convergent_survey.message_send_success');
            return Yii::$app->api->sendResponse(['status' => 1, 'response' => $response->getData()], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('authrization.convergent_survey.message_send_failed');
        return Yii::$app->api->sendResponse(['status' => 0, 'response' => $response->getData()], ['message' => $message]);
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
                $message =  Yii::$app->api->messageManager->getMessage('authrization.deactivate_account.deactivation_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        $message =  Yii::$app->api->messageManager->getMessage('authrization.deactivate_account.deactivation_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
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
            $message = Yii::$app->api->messageManager->getMessage('common.already_verified_mobile');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
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
            \Yii::$app->api->messageManager->clearCache();
            // return Yii::$app->api->sendFailedStringResponse(['Rate limit exceeded. Please try again later.'], 429);
            $message = Yii::$app->api->messageManager->getMessage('common.rate_limit_exceeded');
            return Yii::$app->api->sendResponse($data = [], ['message' => $message], 429);
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

            $message = Yii::$app->api->messageManager->getMessage('common.otp_sent');
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
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
        \Yii::$app->api->messageManager->clearCache();

        $user_model = $this->userinfo;
        // if ($user_model->is_mobile_no_verified == true) {
        //     return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Mobile No aleady Verified"]);
        // }
        $model = new UserMobileNoVerificationForm();
        $model->scenario = 'validateOtp';
        $model->attributes = $this->request;
        if ($user_model->is_mobile_no_verified == true && $user_model->mobile_no == $model->mobile_no) {
            $message =  Yii::$app->api->messageManager->getMessage('common.already_verified_mobile');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }
        if ($model->validate()) {
            if ($model->validateOtp($this->auth_token)) {
                $message =  Yii::$app->api->messageManager->getMessage('common.mobile_verification_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message =  Yii::$app->api->messageManager->getMessage('common.not_verified_mobile');
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
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
                $message =  Yii::$app->api->messageManager->getMessage('authrization.deactivate_account.deactivation_success');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        $message =  Yii::$app->api->messageManager->getMessage('authrization.deactivate_account.deactivation_failed');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
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
                $message =  Yii::$app->api->messageManager->getMessage('authrization.request_delete_account.delete_in_90_days');
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
        }
        $message =  Yii::$app->api->messageManager->getMessage('common.issue_occurred');
        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
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

    public function actionClearCache()
    {
        \Yii::$app->api->messageManager->clearCache();
        $message =  Yii::$app->api->messageManager->getMessage('common.cache_cleared');
        return Yii::$app->api->sendResponse(['message' => $message]);
    }


    private function RateLimit($rateLimitKey, $requestCount, $rateLimitDuration, $rateLimitMaxRequests, $model, $blockDuration)
    {
        $cache = Yii::$app->cache;
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
            $blockKey = 'mobile_verification_block_' . $model->mobile_no;
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

            return \yii\helpers\Json::encode([
                'error' => true,
                'message' => 'Rate limit exceeded. Please try again later.'
            ]);
        } else {
            $remainingRequests = $rateLimitMaxRequests - $requestCount - 1;
            $cache->set($rateLimitKey, $requestCount + 1, $rateLimitDuration);
            if (!$headers->has('X-Rate-Limit-Remaining')) {
                $headers->add('X-Rate-Limit-Remaining', max($remainingRequests, 0)); // Ensure it doesn't go below 0
            }
            if (!$headers->has('X-Rate-Limit-Reset')) {
                $headers->add('X-Rate-Limit-Reset', time() + $rateLimitDuration);
            }
        }
        $remainingRequests = $rateLimitMaxRequests - $requestCount - 1;
        if (!$headers->has('X-Rate-Limit-Remaining')) {
            $headers->add('X-Rate-Limit-Remaining', max($remainingRequests, 0)); // Ensure it doesn't go below 0
        }
        if (!$headers->has('X-Rate-Limit-Reset')) {
            $headers->add('X-Rate-Limit-Reset', time() + $rateLimitDuration);
        }
        return true;
    }


    public function actionSignInEmail()
    {
        $model = new SigninForm();
        $model->setScenario(SigninForm::SCENARIO_SIGNIN_VIA_EMAIL);
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->validate()) {
                return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
            }
            $this->sendmailOtp($model->email);
            return Yii::$app->api->sendResponse(['message' => 'OTP sent to your email!']);
        }
        return Yii::$app->api->sendFailedStringResponse(['Invalid request'], 400);
    }

    public function sendmailOtp($email, $name = null)
    {
        $model = new SourceVerification();
        $model->source_type = SourceVerification::SOURCE_TYPE_EMAIL;
        $model->source = $email;
        $model->otp = rand(100000, 999999);
        $model->exp_datetime = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        if ($model->save(false)) {
            new \common\events\user\EmailVerification(
                0,
                $email,
                $name,
                $model->otp,
                $model->exp_datetime
            );
            return true;
        }
        return false;
    }

    public function actionSignInMobile()
    {
        $model = new SigninForm();
        $model->setScenario(SigninForm::SCENARIO_SIGNIN_VIA_MOBILE);
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->validate()) {
                return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
            }

            $cache = Yii::$app->cache;
            $rateLimitDuration = 30; // 5 minutes in seconds
            $rateLimitMaxRequests = 6; // Maximum allowed requests in the time window
            $blockDuration = 10800; // 3 hours in seconds
            $rateLimitKeys = [];

            $rateLimitKeys[] = 'sms_' . $model->mobile_no;

            foreach ($rateLimitKeys as $key) {
                $requestCount = $cache->get($key);
                $rateCheck = $this->RateLimit($key, $requestCount, $rateLimitDuration, $rateLimitMaxRequests, $model, $blockDuration);
                if ($rateCheck !== true) {
                    return $rateCheck;
                }
            }

            $this->sendmobileOtp($model->mobile_no);
            return Yii::$app->api->sendResponse(['message' => 'OTP sent to your mobile!']);
        }
        return Yii::$app->api->sendFailedStringResponse(['Invalid request'], 400);
    }

    public function sendmobileOtp($mobile_no)
    {
        $model = new SourceVerification();
        $model->source_type = SourceVerification::SOURCE_TYPE_SMS;
        $model->source = $mobile_no;
        $model->otp = rand(100000, 999999);
        $model->exp_datetime = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        if ($model->save(false)) {
            new \common\events\user\MobileNoVerification(0, $model->source, $model->otp, '');
            return true;
        }
        return false;
    }

    public function actionSigninOtpVerification()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $email = strtolower(trim(Yii::$app->request->post('email')));
        $otp = Yii::$app->request->post('otp');
        $mobile_no = Yii::$app->request->post('mobile_no');

        if (!$email && !$mobile_no) {
            return ['success' => false, 'message' => 'Email or Mobile Number is required'];
        }

        $user = User::find()
            ->where(['status' => User::STATUS_ACTIVE])
            ->andWhere(['or', ['email' => $email], ['mobile_no' => $mobile_no]])->one();

        if (!$user) {
            return ['success' => false, 'message' => 'User with this Email or Mobile is not found!'];
        }

        $source_record = SourceVerification::find()
            ->where(['is_expired' => 0])
            ->andWhere(['or', ['source' => $email], ['source' => $mobile_no]])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (!$source_record) {
            return ['success' => false, 'message' => 'OTP record not found! Try Again'];
        }

        if ($source_record->otp != $otp) {
            $source_record->is_expired = 1;
            $source_record->save(false);
            return ['success' => false, 'message' => 'Incorrect OTP! Try Again'];
        }

        if (strtotime($source_record->exp_datetime) < time()) {
            $source_record->is_expired = 1;
            $source_record->save(false);
            return ['success' => false, 'message' => 'OTP has expired'];
        }

        $source_record->is_expired = 1;
        $source_record->save(false);

        $loginmodel = new SigninForm();

        if ($email) {
            $loginmodel->setScenario(SigninForm::SCENARIO_SIGNIN_VIA_EMAIL);
            $loginmodel->email = $email;
        } else {
            $loginmodel->setScenario(SigninForm::SCENARIO_SIGNIN_VIA_MOBILE);
            $loginmodel->mobile_no = $mobile_no;
        }

        if ($loginmodel->apiLogin()) {
            $accessToken = Yii::$app->api->createAccesstoken($user, $loginmodel);
            return Yii::$app->api->sendResponse(['access_token' => $accessToken->token]);
        }
        return ['success' => false, 'message' => 'Login failed. Please try again'];
    }


    public function actionRegenerateOtp()
    {
        $mobile_no = Yii::$app->request->post('mobile_no');
        $email = Yii::$app->request->post('email');

        if ((!empty($mobile_no) && !empty($email)) || (empty($mobile_no) && empty($email))) {
            return [
                'status' => false,
                'message' => 'Please provide either email OR mobile number'
            ];
        }

        if ($mobile_no) {
            $sourceType = SourceVerification::SOURCE_TYPE_SMS;
            $sourceValue = $mobile_no;
        } else {
            $sourceType = SourceVerification::SOURCE_TYPE_EMAIL;
            $sourceValue = $email;
        }

        $model = SourceVerification::find()
            ->where(['source_type' => $sourceType, 'source' => $sourceValue])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (!$model) {
            $model = new SourceVerification();
            $model->source_type = $sourceType;
            $model->source = $sourceValue;
        }

        $model->otp = rand(100000, 999999);
        $model->exp_datetime = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        if ($model->save(false)) {
            if ($sourceType === SourceVerification::SOURCE_TYPE_SMS) {
                new \common\events\user\MobileNoVerification(0, $model->source, $model->otp, '');
            } else {
                new \common\events\user\EmailVerification(0, $email, null, $model->otp, $model->exp_datetime);
            }

            return ['success' => true, 'message' => 'OTP regenerated successfully'];
        }

        return ['success' => false, 'message' => 'Failed to regenerate OTP'];
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->validate()) {
                return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
            }
            $existingUser = User::find()
                ->where(['status' => User::STATUS_ACTIVE])
                ->andWhere(['or', ['email' => $model->email,], ['mobile_no' => $model->mobile_no]])
                ->one();
            if ($existingUser !== null) {
                return Yii::$app->api->sendFailedStringResponse(['Email or  Mobile number is already registered and active.']);
            }

            $cache = Yii::$app->cache;
            $rateLimitDuration = 30; // 5 minutes in seconds
            $rateLimitMaxRequests = 6; // Maximum allowed requests in the time window
            $blockDuration = 10800; // 3 hours in seconds
            $rateLimitKeys = [];

            $rateLimitKeys[] = 'sms_' . $model->mobile_no;

            foreach ($rateLimitKeys as $key) {
                $requestCount = $cache->get($key);
                $rateCheck = $this->RateLimit($key, $requestCount, $rateLimitDuration, $rateLimitMaxRequests, $model, $blockDuration);
                if ($rateCheck !== true) {
                    return $rateCheck;
                }
            }
            $this->sendOtp($model->email, $model->mobile_no, $model->name);
            return Yii::$app->api->sendResponse(['message' => 'OTP sent to your email and mobile!']);
        }
        return Yii::$app->api->sendFailedStringResponse(['Invalid request'], 400);
    }

    public function sendOtp($email, $mobile_no, $name)
    {
        $model = new TemporaryUser();
        $model->username = $email;
        $model->email = $email;
        $model->email_otp = rand(100000, 999999);
        $model->mobile_no = $mobile_no;
        $model->mobile_otp = rand(100000, 999999);
        $model->exp_datetime = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        if ($model->save(false)) {
            new \common\events\user\EmailVerification(0, $email, $name, $model->email_otp, $model->exp_datetime);
            new \common\events\user\MobileNoVerification(0, $model->mobile_no, $model->mobile_otp, '');
            return true;
        }
        return false;
    }

    public function actionSignupOtpVerification()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $email      = strtolower(trim(Yii::$app->request->post('email')));
        $email_otp  = Yii::$app->request->post('email_otp');
        $mobile_no  = Yii::$app->request->post('mobile_no');
        $mobile_otp = Yii::$app->request->post('mobile_otp');

        if (!$email && !$mobile_no) {
            return ['success' => false, 'message' => 'Email or Mobile Number is required'];
        }

        $temp_user = TemporaryUser::find()
            ->andWhere(['or', ['email' => $email], ['mobile_no' => $mobile_no]])
            ->andWhere(['status' => TemporaryUser::STATUS_ACTIVE])
            ->one();

        if (!$temp_user) {
            return ['success' => false, 'message' => 'No signup request found for given details'];
        }

        $otp_record = TemporaryUser::find()
            ->where(['is_expired' => 0])
            ->andWhere(['or', ['email' => $email], ['mobile_no' => $mobile_no]])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (!$otp_record) {
            return ['success' => false, 'message' => 'OTP record not found! Try Again'];
        }

        if ($email && $email_otp) {
            if ($otp_record->email_otp != $email_otp) {
                return ['success' => false, 'message' => 'Incorrect Email OTP'];
            }
            $temp_user->is_email_verified = 1;
        }

        if ($mobile_no && $mobile_otp) {
            if ($otp_record->mobile_otp != $mobile_otp) {
                return ['success' => false, 'message' => 'Incorrect Mobile OTP'];
            }
            $temp_user->is_mobile_verified = 1;
        }

        if (strtotime($otp_record->exp_datetime) < time()) {
            $otp_record->is_expired = 1;
            $otp_record->save(false);
            return ['success' => false, 'message' => 'OTP has expired'];
        }

        $otp_record->is_expired = 1;
        $otp_record->save(false);

        $temp_user->save(false);

        if ($temp_user->is_email_verified && $temp_user->is_mobile_verified) {
            $user = User::createFromTemporary($temp_user);
            if (!$user) {
                return ['success' => false, 'message' => 'Failed to create user account'];
            }

            $loginmodel = new SigninForm();
            if ($email) {
                $loginmodel->setScenario(SigninForm::SCENARIO_SIGNIN_VIA_EMAIL);
                $loginmodel->email = $email;
            } else {
                $loginmodel->setScenario(SigninForm::SCENARIO_SIGNIN_VIA_MOBILE);
                $loginmodel->mobile_no = $mobile_no;
            }

            if ($loginmodel->apiLogin()) {
                $accessToken = Yii::$app->api->createAccesstoken($user, $loginmodel);
                return Yii::$app->api->sendResponse(['access_token' => $accessToken->token]);
            }

            return ['success' => false, 'message' => 'Login failed after verification'];
        }

        return [
            'success' => true,
            'message' => 'OTP verified, waiting for other verification to complete'
        ];
    }

    public function actionRefundpolicyantara()
    {
        $refund_policy = ContentManagement::findOne(['id' => ContentManagement::CMS_REFUND_POLICY_ANTARA]);
        if ($refund_policy) {
            $message = Yii::$app->api->messageManager->getMessage('common.success');
            return \Yii::$app->api->sendResponse($data = ['content' => $refund_policy->content], ['message' => $message]);
        }
        $message = Yii::$app->api->messageManager->getMessage('common.not_found');
        return Yii::$app->api->sendResponse($data = [], ['message' => $message]);
    }
}
