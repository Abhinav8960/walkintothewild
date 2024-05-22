<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Register New User or Update Existing User
 */
class UserRegistrationForm extends Model
{
    public $user_model;
    public $email;
    public $username;
    public $name;
    public $password;
    public $role_id;

    public function __construct(User $user_model = null)
    {
        $this->user_model = Yii::createObject([
            'class' => User::className()
        ]);
    }


    /** @inheritdoc */
    public function rules()
    {
        return [
            ['role_id', 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9]\w+$/'],
            ['username', 'required'],
            //name rules
            ['name', 'required'],
            ['name', 'string', 'min' => 3, 'max' => 150],
            ['name', 'trim'],
            [
                'username', 'unique', 'targetClass' => 'common\models\User',
                'message' => 'This username has already been taken'
            ],
            ['username', 'string', 'min' => 3, 'max' => 20],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'unique', 'targetClass' => 'common\models\User',
                'message' => 'This email address has already been taken'
            ],
            ['password', 'required'],
            ['password', 'string', 'min' => 4],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'username' => 'Login ID',
            'password' => 'Password',
            'role_id' => 'Select User Role'
        ];
    }

    /**
     * initialize Form Data
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->user_model->username = $this->username;
        $this->user_model->name = $this->name;
        $this->user_model->email = $this->email;
        // if (in_array($this->role_id, array_keys(GeneralModel::roles()))) {
        //     $this->user_model->role_id = $this->role_id;
        // }
        $this->role_id;
        // print_r($role_id);
        // /die();
        $this->user_model->auth_key = \Yii::$app->security->generateRandomString();
        $this->user_model->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->user_model->save();
    }
}
