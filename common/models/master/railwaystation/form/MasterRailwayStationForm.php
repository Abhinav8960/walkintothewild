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
    public $station_code;
    public $country_id;
    public $state_id;
    public $city_id;
    public $title;
    public $status;
    public $status_option = [];
    public $railway_station_model;
    public $uploadfile;


    public function __construct(MasterRailwayStation $railway_station_model = null)
    {

        $this->railway_station_model = Yii::createObject([
            'class' => MasterRailwayStation::className()
        ]);



        if ($railway_station_model  != '') {
            $this->railway_station_model = $railway_station_model;
            $this->station_code = $this->railway_station_model->station_code;
            $this->country_id = $this->railway_station_model->country_id;
            $this->state_id = $this->railway_station_model->state_id;
            $this->city_id = $this->railway_station_model->city_id;
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
            [['state_id', 'country_id', 'title', 'status'], 'required'],
            [['status'], 'integer'],
            [['state_id', 'country_id', 'title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['station_code'], 'string', 'max' => 20],
            ['uploadfile', 'required', 'on' => 'uploadfile'],
            [
                ['title'], 'unique', 'targetClass' => MasterRailwayStation::className(), 'message' => 'This title has already been taken.',
                'filter' => function ($query) {
                    if (!$this->railway_station_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->railway_station_model->id]]);
                    }
                }
            ],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = ['city_id', 'state_id', 'country_id', 'title', 'station_code'];
        $scenarios['update'] = ['city_id', 'state_id', 'country_id', 'title', 'station_code'];
        return $scenarios;
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
            'station_code' => 'Station Code',
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
        $this->railway_station_model->country_id = $this->country_id;
        $this->railway_station_model->state_id = $this->state_id;
        $this->railway_station_model->city_id = $this->city_id;
        $this->railway_station_model->title = $this->title;
        $this->railway_station_model->station_code = $this->station_code;
        $this->railway_station_model->status = $this->status;
    }
}
