<?php

namespace api\models;

use common\models\Auth;
use common\models\SocialLoginVerification;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class OtpVerificationSocialLoginForm extends Model
{
    public $source_id;
    public $source;
    public $email;
    public $name;
    public $otp;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source', 'source_id', 'email', 'name', 'otp'], 'required'],
            ['email', 'email'],
        ];
    }

    public function can_login()
    {
        $auth = Auth::find()->where(['source' => $this->source, 'source_id' => $this->source_id])->one();
        if (!empty($auth)) {
            return true;
        }
        return false;
    }

    public function validateOtp()
    {
        // we need to setup with otp expiry
        $model = SocialLoginVerification::find()->where(['source' => $this->source, 'source_id' => $this->source_id, 'otp' => $this->otp, 'status' => 0])->orderBy(['id' => SORT_DESC])->one();
        if ($model) {
            $model->status = 1;
            $model->save(false);
            $this->HandleAuth();
            return true;
        }
        return false;
    }

    private function HandleAuth()
    {
        $user = User::find()->where(['email' => $this->email, 'status' => User::STATUS_ACTIVE])->one();
        if (empty($user)) {
            $user = new User();
            $user->setPassword(rand(10000000, 99999999));
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->name = isset($this->name) ? $this->name : null;
            $user->username = $this->email;
            $user->email = $this->email;
            $user->status = User::STATUS_ACTIVE;
            // $user->avatar = $model->avatar;
        }

        $source_id_col = strtolower($this->source . '_source_id');
        $user->$source_id_col  = $this->source_id;
        $user->save();
        $auth = new Auth([
            'user_id' => $user->id,
            'source' => $this->source,
            'source_id' => $this->source_id,
        ]);
        $auth->save();
    }
}
