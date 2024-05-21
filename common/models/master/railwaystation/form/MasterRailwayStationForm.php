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
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'TItle',
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
        $this->railway_station_model->title = $this->title;
        $this->railway_station_model->status = $this->status;
    }
}
