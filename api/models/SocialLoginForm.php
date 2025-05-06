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
class SocialLoginForm extends Model
{
    public $source;
    public $source_id;
    public $email;
    public $name;
    public $avatar;
    public $rememberMe = true;

    private $_user;

    public $device;
    public $platform;
    public $platform_version;
    public $browser;
    public $browser_version;
    public $firebase_token;
    public $otp;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['device', 'platform', 'platform_version', 'browser', 'browser_version', 'firebase_token', 'avatar', 'otp'], 'safe'],
            [['source', 'source_id', 'email', 'name'], 'required'],
            ['email', 'email'],
            // ['source_id', 'sourceIdvalidators'],
            // [
            //     'email', 'exist',
            //     'targetClass' => '\common\models\User',
            //     'filter' => ['status' => User::STATUS_ACTIVE],
            //     'message' => 'There is no user with this email address.'
            // ],

            // rememberMe must be a boolean value
            // password is validated by validatePassword()
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


    // public function UserSession($token)
    // {

    //     $ud = UserSession::find()->where(['token' => $token])->one();
    //     if (!empty($ud)) {
    //         $ud = new UserSession();
    //         $ud->user_id            = $token;
    //         $ud->token              = $token;
    //         $ud->firebase_token     = isset($this->firebase_token) ? $this->firebase_token : NULL;
    //         $ud->ip_address         = \Yii::$app->getRequest()->getUserIP();
    //         $ud->user_device             = isset($this->device) ? $this->device : NULL;
    //         $ud->user_platform           = isset($this->platform) ? $this->platform : NULL;
    //         // $ud->platform_version   = isset($this->platform_version) ? $this->platform_version : NULL;
    //         $ud->user_browser            = isset($this->browser) ? $this->browser : NULL;
    //         // $ud->browser_version    = isset($this->browser_version) ? $this->browser_version : NULL;

    //         $ud->api                = Yii::$app->params['app_name'];
    //         return $ud->save(false);
    //     }
    // }
}
