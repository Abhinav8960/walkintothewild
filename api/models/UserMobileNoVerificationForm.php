<?php

namespace api\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class UserMobileNoVerificationForm extends Model
{
    public $mobile_no;
    public $otp;
    public $expiry_datetime;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile_no'], 'required'],
            [['otp'], 'required', 'on' => 'validateOtp'],
            [['mobile_no'], 'string', 'max' => 15],
            [['mobile_no'], 'trim'],
            [['mobile_no'], 'match', 'pattern' => '/^[1234567890]\d{9}$/', 'message' => 'Invalid Phone number.'],
        ];
    }

    public function proceedforverification($auth_token, $userinfo)
    {
        $this->otp = rand(100000, 999999);
        $this->expiry_datetime = time() + 300; // 5 min 

        $UserSession = \common\models\UserSession::find()->where(['token' => $auth_token])->one();
        $UserSession->verification_mobile_no = $this->mobile_no;
        $UserSession->verification_mobile_no_otp = $this->otp;
        $UserSession->verification_mobile_no_otp_expiry_datetime = date('Y-m-d H:i:s', $this->expiry_datetime);
        new \common\events\user\MobileNoVerification($userinfo->id, $this->mobile_no, $this->otp, $userinfo->name);

        return $UserSession->save(false);
    }

    public function validateOtp($auth_token)
    {
        $UserSession = \common\models\UserSession::find()->where(['token' => $auth_token])->one();
        if ($UserSession->verification_mobile_no == $this->mobile_no && $UserSession->verification_mobile_no_otp == $this->otp && $UserSession->verification_mobile_no_otp_expiry_datetime >= date('Y-m-d H:i:s')) {
            $this->updateUserMobileNo($auth_token);
            $this->clearOtp($auth_token);
            return true;
        }
        return false;
    }

    private function clearOtp($auth_token)
    {
        $UserSession = \common\models\UserSession::find()->where(['token' => $auth_token])->one();
        $UserSession->verification_mobile_no = null;
        $UserSession->verification_mobile_no_otp = null;
        $UserSession->verification_mobile_no_otp_expiry_datetime = null;
        return $UserSession->save(false);
    }

    private function updateUserMobileNo($auth_token)
    {
        $UserSession = \common\models\UserSession::find()->where(['token' => $auth_token])->one();
        $user = \common\models\User::find()->where(['id' => $UserSession->user_id])->one();
        $user->mobile_no = $this->mobile_no;
        $user->is_mobile_no_verified = true;
        $user->mobile_no_verified_at = time();
        return $user->save(false);
    }
}
