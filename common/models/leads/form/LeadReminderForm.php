<?php

namespace common\models\leads\form;

use api\models\chat\Chat;
use api\models\chat\ChatMessage;
use common\models\leads\Lead;
use Yii;
use yii\base\Model;
use common\models\leads\LeadPartners;
use common\models\park\SafariPark;
use common\models\User;

/**
 * OperatorQuoteForm is the model behind the contact form.
 */
class LeadReminderForm extends Model
{
    public $reminder_datetime;
    public $reminder_status;
    public $reminder_note;
     

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reminder_datetime','reminder_status','reminder_note'],'required'],
            [['reminder_status'],'integer'],
            [['reminder_note'],'string','max'=>512]        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reminder_note'=>'Reminder Note',
            'reminder_status' =>'Reminder Status',
            'reminder_datetime'=>'Reminder DateTime',
        ];
    }
}
