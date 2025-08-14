<?php

namespace api\models;

use Codeception\Scenario;
use common\models\EmailVerification;
use common\models\TemporaryUser;
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

    public $password;
    public $confirm_password;

    // const SCENARIO_SIGNUP_VIA_EMAIL = 'signup_via_email';
    // const SCENARIO_SIGNUP_VIA_MOBILE = 'signup_via_mobile';

    /**
     * {@inheritdoc}
     */

    // public function scenarios()
    // {
    //     return [
    //         self::SCENARIO_SIGNUP_VIA_EMAIL => ['email'],
    //         self::SCENARIO_SIGNUP_VIA_MOBILE => ['mobile_no'],
    //     ];
    // }

    public function rules()
    {
        return [
            [['device', 'platform', 'platform_version', 'browser', 'user_platform_version', 'application_version', 'browser_version', 'firebase_token', 'avatar', 'otp'], 'safe'],
            // [['email'], 'required', 'on' => self::SCENARIO_SIGNUP_VIA_EMAIL],
            // [['mobile_no'], 'required', 'on' => self::SCENARIO_SIGNUP_VIA_MOBILE],
            [['email','mobile_no'],'required'],
            ['email', 'email'],
            // ['password', 'string', 'min' => 6],
            // ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
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

        $tempUser = TemporaryUser::find()
            ->where(['email' => $this->email])
            ->orWhere(['mobile_no' => $this->mobile_no])
            ->one();

        if (!$tempUser) {
            $tempUser = new TemporaryUser();
        }

        $tempUser->name = $this->name ?? $tempUser->name;
        $tempUser->email = $this->email ?? $tempUser->email;
        $tempUser->username = $this->email ?? $tempUser->username;
        $tempUser->mobile_no = $this->mobile_no ?? $tempUser->mobile_no;
        $tempUser->status = TemporaryUser::STATUS_ACTIVE;

        if (!$tempUser->save(false)) {
            $this->addErrors($tempUser->getErrors());
            return null;
        }
        return $tempUser;
    }
}
