<?php

namespace api\models;

use Codeception\Scenario;
use common\models\EmailVerification;
use common\models\User;
use common\models\UserSession;
use common\models\UserVerification;
use wdmg\activity\models\Activity;
use yii\base\Model;
use Yii;

/**
 * Login form
 */
class SigninForm extends Model
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

    const SCENARIO_SIGNIN_VIA_MOBILE = 'signin_via_mobile';
    const SCENARIO_SIGNIN_VIA_EMAIL = 'signin_via_email';

    /**
     * {@inheritdoc}
     */

    public function scenarios()
    {
        return [
            self::SCENARIO_SIGNIN_VIA_MOBILE => ['mobile_no'],
            self::SCENARIO_SIGNIN_VIA_EMAIL => ['email'],
        ];
    }

    public function rules()
    {
        return [
            [['device', 'platform', 'platform_version', 'browser', 'user_platform_version', 'application_version', 'browser_version', 'firebase_token', 'avatar', 'otp'], 'safe'],
            [['email'], 'required', 'on' => self::SCENARIO_SIGNIN_VIA_EMAIL],
            [['mobile_no'], 'required', 'on' => self::SCENARIO_SIGNIN_VIA_MOBILE],
            ['email', 'email'],
        ];
    }

    public function apiLogin()
    {
        if ($this->validate()) {
            if ($this->email) {
                $user = $this->getUser();
            }
            if ($this->mobile_no) {
                $user = $this->getUserMobile();
            }
            if ($user) {
                // Log the user in
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
        }
        return false;
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne([
                'email' => $this->email,
                'status' => User::STATUS_ACTIVE,
            ]);
        }

        return $this->_user;
    }

    public function getUserMobile()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne([
                'mobile_no' => $this->mobile_no,
                'status' => User::STATUS_ACTIVE,
            ]);
        }

        return $this->_user;
    }
}
