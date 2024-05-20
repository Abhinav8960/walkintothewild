<?php

namespace common\models\master\state\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\state\MasterState;


class MasterStateForm extends model
{
    public $state_name;
    public $status;
    public $status_option = [];
    public $state_model;


    public function __construct(MasterState $state_model = null)
    {

        $this->state_model = Yii::createObject([
            'class' => MasterState::className()
        ]);

        if ($state_model  != '') {
            $this->state_model = $state_model;
            $this->state_name = $this->state_model->state_name;
            $this->status = $this->state_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_name'], 'required'],
            [['status'], 'integer'],
            [['state_name'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'state_name' => 'State',
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
        $this->state_model->state_name = $this->state_name;
        $this->state_model->status = $this->status;
    }
}
