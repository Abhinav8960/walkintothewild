<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class CustomLoginForm extends Model
{
    public $username;
    public $google_source_id;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'google_source_id'], 'required'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = User::findOne([
                'username' => $this->username,
                'google_source_id' => $this->google_source_id,
            ]);

            if ($user) {
                return Yii::$app->user->login($user);
            }

            $this->addError('username', 'Incorrect username.');
            $this->addError('google_source_id', 'Incorrect Google Source ID.');
        }

        return false;
    }
}
