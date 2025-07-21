<?php

namespace api\models;

use common\models\User;
use common\models\UserSession;
use wdmg\activity\models\Activity;
use Yii;
use yii\base\Model;

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
            [['email', 'name','mobile_no'], 'required'],
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

}
