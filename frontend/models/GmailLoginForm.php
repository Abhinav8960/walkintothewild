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
  public $pass_code;

  public $action_url;
  public $action_validate_url;

  public function rules()
  {
    return [
      ['email_id', 'required'],
      ['email_id', 'email'],
      ['email_id', 'trim'],
      [['email_code', 'pass_code'], 'required'],
      [['email_code', 'pass_code'], 'trim'],
      ['email_code', 'compare', 'compareAttribute' => 'pass_code', 'operator' => '==', 'message' => 'Incorrect code'],
    ];
  }

  public function scenarios()
  {
    $scenarios = parent::scenarios();
    $scenarios['sendmail'] = [
      'email_id',
    ];
    $scenarios['matchcode'] = [
      'email_id',
      'email_code',
      'pass_code'
    ];
    return $scenarios;
  }

  public function attributeLabels()
  {
    return [
      'email_id' => 'Email ID',
      'email_code' => 'Code',
      'pass_code' => 'Code'
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
