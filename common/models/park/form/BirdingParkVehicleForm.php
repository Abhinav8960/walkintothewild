<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\BirdingParkVehicle;

/**
 * Update and Create Holiday
 */
class BirdingParkVehicleForm extends model
{
    public $birding_park_id;
    public $vehicle_id;
    public $status;
    public $status_option = [];
    public $birding_park_vehicle_model;


    public function __construct(BirdingParkVehicle $birding_park_vehicle_model = null)
    {

        $this->birding_park_vehicle_model = Yii::createObject([
            'class' => BirdingParkVehicle::className()
        ]);



        if ($birding_park_vehicle_model  != '') {
            $this->birding_park_vehicle_model = $birding_park_vehicle_model;
            $this->birding_park_id = $this->birding_park_vehicle_model->birding_park_id;
            $this->vehicle_id = $this->birding_park_vehicle_model->vehicle_id;
            $this->status = $this->birding_park_vehicle_model->status;
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
            [['vehicle_id', 'birding_park_id'], 'safe'],
            [
                'vehicle_id', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->birding_park_vehicle_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => BirdingParkVehicle::className(), 'targetAttribute' => ['birding_park_id', 'vehicle_id'],
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
            'birding_park_id' => 'Safari Park',
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
        $this->birding_park_vehicle_model->birding_park_id = $this->birding_park_id;
        $this->birding_park_vehicle_model->vehicle_id = $this->vehicle_id;
        $this->birding_park_vehicle_model->status = $this->status;
    }
}
