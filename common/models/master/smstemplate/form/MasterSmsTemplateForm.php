<?php

namespace common\models\master\smstemplate\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\smstemplate\MasterSmsTemplate;

class MasterSmsTemplateForm extends model
{

    public $name;
    public $message;
    public $description;
    public $template_id;
    public $route;
    public $status;
    public $status_option = [];
    public $sms_template_model;


    public function __construct(MasterSmsTemplate $sms_template_model = null)
    {

        $this->sms_template_model = Yii::createObject([
            'class' => MasterSmsTemplate::className()
        ]);



        if ($sms_template_model  != '') {
            $this->sms_template_model = $sms_template_model;
            $this->name = $this->sms_template_model->name;
            $this->message = $this->sms_template_model->message;
            $this->description = $this->sms_template_model->description;
            $this->template_id = $this->sms_template_model->template_id;
            $this->route = $this->sms_template_model->route;
            $this->status = $this->sms_template_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message','name','description','template_id','route'], 'required'],
            [['status','route'], 'integer'],
            [['message','template_id','description'], 'string'],
        ];
    }

  /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'message' => 'Message',
            'description' => 'Description',
            'template_id' => 'Template Id',
            'route'=>'Route',
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
        $this->sms_template_model->name = $this->name;
        $this->sms_template_model->message = $this->message;
        $this->sms_template_model->description = $this->description;
        $this->sms_template_model->template_id = $this->template_id;
        $this->sms_template_model->route = $this->route;

    }

}
