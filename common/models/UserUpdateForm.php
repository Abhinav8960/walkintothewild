<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Update Existing User Details
 */
class UserUpdateForm extends Model
{
    public $user_model;
    public $email;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $role_id;

    public function __construct(User $user_model = null)
    {
        $this->user_model = Yii::createObject([
            'class' => User::className()
        ]);

        if ($user_model != null) {
            $this->user_model = $user_model;
            $this->username = $this->user_model->username;
            $this->email = $this->user_model->email;
            $this->first_name = $this->user_model->first_name;
            $this->last_name = $this->user_model->last_name;
            $this->role_id = $this->user_model->role_id;
        }
    }


    /** @inheritdoc */
    public function rules()
    {
        return [
            [['role_id'], 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9]\w+$/'],
            ['username', 'required'],
            //first_name rules
            ['first_name', 'required'],
            ['first_name', 'string', 'min' => 3, 'max' => 150],
            ['first_name', 'trim'],
            //last_name rules
            ['last_name', 'required'],
            ['last_name', 'string', 'min' => 3, 'max' => 150],
            ['last_name', 'trim'],
            [
                'username', 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                },  'targetClass' => \common\models\User::className(),
                'message' => 'This username has already been taken'
            ],
            ['username', 'string', 'min' => 3, 'max' => 20],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'unique',
                'when' => function ($model, $attribute) {
                    return $this->user_model->$attribute != $model->$attribute;
                },  'targetClass' => \common\models\User::className(),
                'message' => 'This email address has already been taken'
            ],
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

        if (isset($this->password) && $this->password != null && $this->password != '') {
            $this->user_model->auth_key = \Yii::$app->security->generateRandomString();
            $this->user_model->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $this->user_model->password_update_at = time();
        }
        $this->user_model->username = $this->username;
        $this->user_model->email = $this->email;
        if (in_array($this->role_id, array_keys(GeneralModel::roles()))) {
            $this->user_model->role_id = $this->role_id;
        }
        $this->user_model->first_name = $this->first_name;
        $this->user_model->last_name = $this->last_name;
        $this->user_model->save();
    }
}
