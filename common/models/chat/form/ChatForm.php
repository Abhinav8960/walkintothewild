<?php

namespace common\models\chat\form;

use common\models\chat\ChatMessage;
use Yii;
use yii\base\Model;


class ChatForm extends model
{
    public $message;
    public $chat_form_model;

    public function __construct(?ChatMessage $chat_form_model = null)
    {

        $this->chat_form_model = Yii::createObject([
            'class' => ChatMessage::class
        ]);

        if ($chat_form_model  != '') {
            $this->chat_form_model = $chat_form_model;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'message' => 'Message',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->chat_form_model->message = $this->message;
    }
}
