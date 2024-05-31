<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\SafariParkVehicle;

/**
 * Update and Create Holiday
 */
class SafariParkVehicleForm extends model
{
    public $safari_park_id;
    public $vehicle_id;
    public $status;
    public $status_option = [];
    public $safari_park_vehicle_model;


    public function __construct(SafariParkVehicle $safari_park_vehicle_model = null)
    {

        $this->safari_park_vehicle_model = Yii::createObject([
            'class' => SafariParkVehicle::className()
        ]);



        if ($safari_park_vehicle_model  != '') {
            $this->safari_park_vehicle_model = $safari_park_vehicle_model;
            $this->safari_park_id = $this->safari_park_vehicle_model->safari_park_id;
            $this->vehicle_id = $this->safari_park_vehicle_model->vehicle_id;
            $this->status = $this->safari_park_vehicle_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_id'], 'required'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => 1],
            [['vehicle_id', 'safari_park_id'], 'safe'],
            [
                'vehicle_id', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->safari_park_vehicle_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => SafariParkVehicle::className(), 'targetAttribute' => ['safari_park_id', 'vehicle_id'],
                'message' => 'This Vehicle has already been taken'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'safari_park_id' => 'Safari Park',
            'vehicle_id' => 'Vehicle',
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
        $this->safari_park_vehicle_model->safari_park_id = $this->safari_park_id;
        $this->safari_park_vehicle_model->vehicle_id = $this->vehicle_id;
        $this->safari_park_vehicle_model->status = $this->status;
    }
}
