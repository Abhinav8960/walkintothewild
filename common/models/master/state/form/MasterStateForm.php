<?php

namespace common\models\master\state\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\state\MasterState;


class MasterStateForm extends model
{
    public $state_name;
    public $country_id;
    public $status;
    public $status_option = [];
    public $state_model;
    public $uploadfile;


    public function __construct(MasterState $state_model = null)
    {

        $this->state_model = Yii::createObject([
            'class' => MasterState::className()
        ]);

        if ($state_model  != '') {
            $this->state_model = $state_model;
            $this->country_id = $this->state_model->country_id;
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
            [['state_name', 'country_id'], 'required'],
            [['status'], 'integer'],
            [['state_name'], 'string', 'max' => 125],
            [['status'], 'default', 'value' => 1],
            [['uploadfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],

        ];
    }



    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = ['state_name', 'country_id', 'status'];
        $scenarios['update'] = ['state_name', 'country_id', 'status'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'state_name' => 'State',
            'country_id' => 'Country',
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
        $this->state_model->country_id = $this->country_id;
        $this->state_model->state_name = $this->state_name;
        $this->state_model->status = $this->status;
    }
}
