<?php

namespace common\models\master\notification\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\notification\MasterNotificationTemplate;


class MasterNotificationTemplateForm extends model
{

    public $title;
    public $message;
    public $status;
    public $status_option = [];
    public $notification_template_model;


    public function __construct(MasterNotificationTemplate $notification_template_model = null)
    {

        $this->notification_template_model = Yii::createObject([
            'class' => MasterNotificationTemplate::className()
        ]);



        if ($notification_template_model  != '') {
            $this->notification_template_model = $notification_template_model;
            $this->title = $this->notification_template_model->title;
            $this->message = $this->notification_template_model->message;
            $this->status = $this->notification_template_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message','title'], 'required'],
            [['status'], 'integer'],
            [['message'], 'string'],
        ];
    }

  /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'message' => 'Message',
            'status' => 'Status',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->notification_template_model->title = $this->title;
        $this->notification_template_model->message = $this->message;
    }

}
