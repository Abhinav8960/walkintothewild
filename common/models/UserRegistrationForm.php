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
    public $is_adminstrator;
    public $is_admin;
    public $is_safari_operator;
    public $is_birding_operator;
    public $is_cms_manager;
    public $is_resort_manager;
    public $is_report_manager;
    public $is_community_manager;

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
            ['role_id', 'safe'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'email'],
            ['username', 'required'],
            //name rules
            ['name', 'required'],
            ['name', 'string', 'min' => 3, 'max' => 150],
            ['name', 'trim'],
            [
                'username',
                'unique',
                'targetClass' => 'common\models\User',
                'message' => 'This username has already been taken'
            ],
            ['username', 'string', 'min' => 3, 'max' => 50],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            [['is_adminstrator', 'is_admin', 'is_safari_operator', 'is_birding_operator', 'is_cms_manager', 'is_resort_manager', 'is_report_manager', 'is_community_manager'], 'safe'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => 'common\models\User',
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
        $this->user_model->is_adminstrator = 0;
        $this->user_model->is_admin = 0;
        $this->user_model->is_safari_operator = 0;
        $this->user_model->is_birding_operator = 0;
        $this->user_model->is_cms_manager = 0;
        $this->user_model->is_resort_manager = 0;
        $this->user_model->is_report_manager = 0;
        $this->user_model->is_community_manager = 0;
        if (in_array(1, $this->role_id)) {
            $this->user_model->is_adminstrator = 1;
        }
        if (in_array(2, $this->role_id)) {
            $this->user_model->is_admin = 1;
        }
        if (in_array(3, $this->role_id)) {
            $this->user_model->is_safari_operator = 1;
        }
        if (in_array(4, $this->role_id)) {
            $this->user_model->is_birding_operator = 1;
        }
        if (in_array(5, $this->role_id)) {
            $this->user_model->is_cms_manager = 1;
        }
        if (in_array(6, $this->role_id)) {
            $this->user_model->is_resort_manager = 1;
        }
        if (in_array(7, $this->role_id)) {
            $this->user_model->is_report_manager = 1;
        }
        if (in_array(8, $this->role_id)) {
            $this->user_model->is_community_manager = 1;
        }
        $this->user_model->auth_key = \Yii::$app->security->generateRandomString();
        $this->user_model->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->user_model->save();
    }
}
