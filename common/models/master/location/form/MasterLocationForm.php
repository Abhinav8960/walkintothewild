<?php

namespace common\models\master\location\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\location\MasterLocation;

class MasterLocationForm extends model
{
    public $country_id;
    public $state_id;
    public $city_id;
    public $title;
    public $status;
    public $status_option = [];
    public $location_model;


    public function __construct(MasterLocation $location_model = null)
    {

        $this->location_model = Yii::createObject([
            'class' => MasterLocation::className()
        ]);



        if ($location_model  != '') {
            $this->location_model = $location_model;
            $this->country_id = $this->location_model->country_id;
            $this->state_id = $this->location_model->state_id;
            $this->city_id = $this->location_model->city_id;
            $this->location_model = $location_model;
            $this->title = $this->location_model->title;
            $this->status = $this->location_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'state_id', 'country_id', 'title', 'status'], 'required'],
            [['status'], 'integer'],
            [['state_id', 'country_id', 'title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city_id' => 'City',
            'state_id' => 'State',
            'country_id' => 'Country',
            'title' => 'Title',
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
        $this->location_model->country_id = $this->country_id;
        $this->location_model->state_id = $this->state_id;
        $this->location_model->city_id = $this->city_id;
        $this->location_model->title = $this->title;
        $this->location_model->status = $this->status;
    }
}
