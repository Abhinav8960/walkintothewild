<?php

namespace api\models;

use Codeception\Scenario;
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

    public $password;
    public $confirm_password;

    const SCENARIO_SIGNUP_VIA_PASSWORD = 'signup_via_password';
    const SCENARIO_SIGNUP_VIA_OTP = 'signup_via_otp';

    /**
     * {@inheritdoc}
     */

    public function scenarios()
    {
        return [
            self::SCENARIO_SIGNUP_VIA_PASSWORD => ['email','password','confirm_password'],
            self::SCENARIO_SIGNUP_VIA_OTP => ['email','name','mobile_no'],
        ];
    }

    public function rules()
    {
        return [
            [['device', 'platform', 'platform_version', 'browser', 'user_platform_version', 'application_version', 'browser_version', 'firebase_token', 'avatar', 'otp'], 'safe'],
            [['email','password','confirm_password'], 'required','on' => self::SCENARIO_SIGNUP_VIA_PASSWORD],
            [['email', 'name', 'mobile_no'], 'required','on' => self::SCENARIO_SIGNUP_VIA_OTP],
            ['email', 'email'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
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
        $user->signup_via_otp = 1;
        $autoPassword = $this->name . '@1234'; 
        $user->setPassword($autoPassword);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
    
        if ($user->save()) {
            return $user;
        }
        $this->addErrors($user->getErrors());
        return null;
    }


    public function signupwithpassword()
    {

        if (!$this->validate()) {
            return null;
        }
    
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->username = $this->email;
        $user->signup_via_otp = 1;
        $user->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
        // $autoPassword = $this->name . '@1234'; 
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
    
        if ($user->save()) {
            return $user;
        }
        $this->addErrors($user->getErrors());
        return null;

    }
    

}
