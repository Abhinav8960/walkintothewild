<?php

namespace common\models\master\message\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\message\MasterMessage;


class MasterMessageForm extends model
{
    public $page_id;
    public $type_id;
    public $message;
    public $module;
    public $code;
    public $status;
    public $status_option = [];
    public $message_model;


    public function __construct(MasterMessage $message_model = null)
    {

        $this->message_model = Yii::createObject([
            'class' => MasterMessage::className()
        ]);

        if ($message_model  != '') {
            $this->message_model = $message_model;
            $this->page_id = $this->message_model->page_id;
            $this->type_id = $this->message_model->type_id;
            $this->message = $this->message_model->message;
            $this->module = $this->message_model->module;
            $this->code = $this->message_model->code;
            $this->status = $this->message_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'type_id', 'status'], 'integer'],
            [['message'], 'string'],
            [['module'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 4],
            [
                'code',
                'unique',
                'targetClass' => 'common\models\master\message\MasterMessage',
                'message' => 'This code has already been taken'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'module' => 'Module',
            'page_id' => 'Page',
            'type_id' => 'Type',
            'code' => 'Code',
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
        $this->message_model->page_id = $this->page_id;
        $this->message_model->type_id = $this->type_id;
        $this->message_model->message = $this->message;
        $this->message_model->module = $this->module;
        $this->message_model->code = $this->code;
        $this->message_model->status = $this->status;
    }
}
