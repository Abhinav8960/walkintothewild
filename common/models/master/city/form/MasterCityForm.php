<?php

namespace common\models\master\city\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\city\MasterCity;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Holiday
 */
class MasterCityForm extends model
{
    public $state_id;
    public $city_name;
    public $status;
    public $status_option = [];
    public $city_model;


    public function __construct(MasterCity $city_model = null)
    {

        $this->city_model = Yii::createObject([
            'class' => MasterCity::className()
        ]);



        if ($city_model  != '') {
            $this->city_model = $city_model;
            $this->state_id = $this->city_model->state_id;
            $this->city_name = $this->city_model->city_name;
            $this->status = $this->city_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_name', 'state_id'], 'required'],
            [['status'], 'integer'],
            [['city_name', 'state_id'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city_name' => 'City',
            'state_id' => 'State',
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
        $this->city_model->state_id = $this->state_id;
        $this->city_model->city_name = $this->city_name;
        $this->city_model->status = $this->status;
    }
}
