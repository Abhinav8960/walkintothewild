<?php

namespace api\models\static\form;

use yii\base\Model;

class ContactForm extends \frontend\models\ContactForm
{
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
            ['message', 'string', 'max' => 255],
            ['phone', 'required', 'message' => 'This  Mobile number cannot be blank.'],
            ['phone', 'match', 'pattern' => "/^[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}$/", 'message' => ' Mobile number should have 10 digits.'],
        ];
    }
}
