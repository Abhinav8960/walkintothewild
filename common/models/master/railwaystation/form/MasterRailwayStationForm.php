<?php

namespace common\models\master\railwaystation\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\railwaystation\MasterRailwayStation;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Holiday
 */
class MasterRailwayStationForm extends model
{
    public $country_id;
    public $state_id;
    public $city_id;
    public $title;
    public $status;
    public $status_option = [];
    public $railway_station_model;


    public function __construct(MasterRailwayStation $railway_station_model = null)
    {

        $this->railway_station_model = Yii::createObject([
            'class' => MasterRailwayStation::className()
        ]);



        if ($railway_station_model  != '') {
            $this->country_id = $this->city_model->country_id;
            $this->state_id = $this->city_model->state_id;
            $this->city_id = $this->city_model->city_id;
            $this->railway_station_model = $railway_station_model;
            $this->title = $this->railway_station_model->title;
            $this->status = $this->railway_station_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'state_id','country_id','title'], 'required'],
            [['status'], 'integer'],
            [['city_name', 'state_id','country_id','title'], 'string', 'max' => 255],
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
        $this->city_model->country_id = $this->country_id;
        $this->city_model->state_id = $this->state_id;
        $this->city_model->city_id = $this->city_id;
        $this->railway_station_model->title = $this->title;
        $this->railway_station_model->status = $this->status;
    }
}
