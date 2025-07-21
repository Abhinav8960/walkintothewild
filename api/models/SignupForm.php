<?php

namespace api\models;

use common\models\EmailVerification;
use common\models\User;
use common\models\UserSession;
use wdmg\activity\models\Activity;
use yii\base\Model;
use Yii;

/**
 * Login form
 */
class SignupForm extends Model
{
    public $email;
    public $name;
    public $mobile_no;
    public $rememberMe = true;

    private $_user;

    public $device;
    public $platform;
    public $platform_version;
    public $browser;
    public $browser_version;
    public $user_platform_version;
    public $application_version;
    public $firebase_token;
    public $otp;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device', 'platform', 'platform_version', 'browser', 'user_platform_version', 'application_version', 'browser_version', 'firebase_token', 'avatar', 'otp'], 'safe'],
            [['email', 'name', 'mobile_no'], 'required'],
            ['email', 'email'],
        ];
    }

    public function apiLogin()
    {
        if ($this->validate()) {
            return true;
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsernameFrontend($this->email);
        }

        return $this->_user;
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->username = $this->email;
        if ($this->name) {
            $autoPassword = $this->name . '@1234';
            $user->setPassword($autoPassword);  // this sets password_hash using Yii's security
        }
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;  // Or however you set the initial status

        if ($user->save()) {
            return $user;
        }
        $this->addErrors($user->getErrors());
        return null;
    }



    public function SendOtpEmail()
    {
        $model = new EmailVerification();
        $model->user_id = Yii::$app->user->id;
        $model->otp = rand(100000, 999999);
        $model->exp_datetime = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $model->status = 1;

        $partner_model  = $this->findModel();

        if (Yii::$app->request->isPost) {
            $email = Yii::$app->request->post('email');

            if ($email) {
                if ($email != $partner_model->billing_mail) {
                    return \yii\helpers\Json::encode([
                        'error' => true,
                        'message' => 'Email is Invalid or Not Matched !!'
                    ]);
                }
                $model->email = $email;

                if ($model->save(false)) {
                    $to_be_send = EmailVerification::find()->where(['email' => $email, 'otp' => $model->otp, 'status' => 1])->andWhere(['>=', 'exp_datetime', date('Y-m-d H:i:s')])->orderBy(['id' => SORT_DESC])->one();
                    if ($to_be_send != null) {
                        new \common\events\user\EmailVerification($model->user_id, $model->email, $partner_model->legal_entity_name, $to_be_send->otp, $model->exp_datetime);
                    }
                    return \yii\helpers\Json::encode([
                        'success' => true,
                        'message' => 'OTP sent to ' . $email
                    ]);
                }
            }
        }
    }


    public function actionOtpVerificationEmail()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $otpByUser = Yii::$app->request->post('otp_by_user');
        if (!$otpByUser) {
            return [
                'success' => false,
                'message' => 'Missing OTP'
            ];
        }

        $model = EmailVerification::find()->where(['status' => 1, 'user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->one();
        if (!$model) {
            return [
                'success' => false,
                'message' => 'OTP record not found'
            ];
        }
        if ($model->otp != $otpByUser) {
            return [
                'success' => false,
                'message' => 'Incorrect OTP'
            ];
        }

        if (strtotime($model->exp_datetime) < time()) {
            return [
                'success' => false,
                'message' => 'OTP has expired'
            ];
        }

        $partner_model  = $this->findModel();
        if ($partner_model->billing_mail == $model->email) {
            $model->status = 2;
            $model->otp_by_user = $otpByUser;
            $model->source_type = EmailVerification::BILLING_MAIL;
            $model->save(false);
            $partner_model->is_billing_mail_verified = 1;
            if ($model->status == 2) {
                Yii::$app->session->setFlash('success', 'Email verified successfully');
            }
            $partner_model->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
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
            $blockKey = 'mobile_verification_block_' . $model->user_id;
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
}
