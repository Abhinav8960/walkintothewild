<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class GmailLoginForm extends Model
{
  public $email_id;
  public $email_code;

  public $action_url;
  public $action_validate_url;

  public function rules()
  {
    return [
      [['email_id', 'email_id'], 'required'],
      [['email_code'], 'safe'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'email_id' => 'Email ID',
      'email_code' => 'Code',
    ];
  }

  public function validatePassword($attribute, $params)
  {
    if (!$this->hasErrors()) {
      $user = $this->getUser();
      if (!$user || !$user->validatePassword($this->password)) {
        $this->addError($attribute, 'Incorrect username or password.');
      }
    }
  }

  public function login()
  {
    if ($this->validate()) {
      return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    return false;
  }

  protected function getUser()
  {
    if ($this->_user === null) {
      $this->_user = User::findByUsernameFrontend($this->username);
    }

    return $this->_user;
  }
}
