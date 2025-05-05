<?php

namespace api\models;

use common\models\Auth;
use common\models\SocialLoginVerification;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class VerifySocialLoginForm extends Model
{
    public $source_id;
    public $source;
    public $email;
    public $name;
    protected $otp;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source', 'source_id', 'email', 'name'], 'required'],
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

    public function verify_login()
    {
        $model = new SocialLoginVerification();
        $model->source = $this->source;
        $model->source_id = $this->source_id;
        $model->otp = $this->otp = rand(100000, 999999);
        $model->email = $this->email;
        $model->name = $this->name;
        $model->expiry_datetime = strtotime('+5 minutes', time());
        $model->status = 0;
        if($model->save(false)){

            new \common\events\user\SocialLoginEmailVerification($this->email, $this->name, $this->otp);
            return true;
        }
        return false;
    }
}
