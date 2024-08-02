<?php

namespace frontend\models\profile;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * @property User $user
 */
class ChangePasswordForm extends Model
{

    public $password;
    public $password_hash;
    public $username;


    public $user_model;


    public function __construct(User $user_model = null)
    {
        $this->user_model = Yii::createObject([
            'class' => User::className()
        ]);
        if ($user_model != null) {
            $this->user_model = $user_model;
            $this->username = $this->user_model->username;
        }
    }

    public function rules()
    {
        return [
            [['password'], 'required'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    public function initializeForm()
    {
        $this->user_model->password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    }
}
