<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\SafariParkZone;

/**
 * Update and Create Holiday
 */
class SafariParkZoneForm extends model
{
    public $safari_park_id;
    public $master_zone_type_id;
    public $master_zone_type_name;
    public $zone_name;
    public $entry_gate_name;
    public $entry_gate_latitude;
    public $entry_gate_longitude;
    public $is_open_in_monsoon;
    public $status;
    public $status_option = [];
    public $safari_park_zone_model;


    public function __construct(SafariParkZone $safari_park_zone_model = null)
    {

        $this->safari_park_zone_model = Yii::createObject([
            'class' => SafariParkZone::className()
        ]);



        if ($safari_park_zone_model  != '') {
            $this->safari_park_zone_model = $safari_park_zone_model;
            $this->safari_park_id = $this->safari_park_zone_model->safari_park_id;
            $this->master_zone_type_id = $this->safari_park_zone_model->master_zone_type_id;
            $this->master_zone_type_name = $this->safari_park_zone_model->master_zone_type_name;
            $this->zone_name = $this->safari_park_zone_model->zone_name;
            $this->entry_gate_name = $this->safari_park_zone_model->entry_gate_name;
            $this->entry_gate_latitude = $this->safari_park_zone_model->entry_gate_latitude;
            $this->entry_gate_longitude = $this->safari_park_zone_model->entry_gate_longitude;
            $this->is_open_in_monsoon = $this->safari_park_zone_model->is_open_in_monsoon;
            $this->status = $this->safari_park_zone_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_zone_type_id', 'zone_name', 'entry_gate_name'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['is_open_in_monsoon'], 'default', 'value' => 0],
            [['safari_park_id', 'master_zone_type_id', 'status'], 'integer'],
            [['zone_name', 'entry_gate_name'], 'string', 'max' => 255],
            [['entry_gate_latitude', 'entry_gate_longitude'], 'string', 'max' => 50],
            [['master_zone_type_name'], 'safe'],
            [
                'zone_name', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->safari_park_zone_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => SafariParkZone::className(), 'targetAttribute' => ['safari_park_id', 'master_zone_type_id', 'zone_name'],
                'message' => 'This Zone Name has already been taken'
            ],
            [
                'entry_gate_name', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->safari_park_zone_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => SafariParkZone::className(), 'targetAttribute' => ['safari_park_id', 'master_zone_type_id', 'entry_gate_name'],
                'message' => 'This Entry Gate Name has already been taken'
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
            'master_zone_type_id' => 'Master Zone Type *',
            'master_zone_type_name' => 'Master Zone Type Name',
            'zone_name' => 'Zone Name *',
            'entry_gate_name' => 'Entry Gate Name *',
            'entry_gate_latitude' => 'Entry Gate Latitude *',
            'entry_gate_longitude' => 'Entry Gate Longitude *',
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
        $this->safari_park_zone_model->safari_park_id = $this->safari_park_id;
        $this->safari_park_zone_model->master_zone_type_id = $this->master_zone_type_id;
        if ($this->master_zone_type_id) {
            $this->safari_park_zone_model->master_zone_type_name =  GeneralModel::zonetypeoption()[$this->master_zone_type_id];
        }
        $this->safari_park_zone_model->zone_name = $this->zone_name;
        $this->safari_park_zone_model->entry_gate_name = $this->entry_gate_name;
        $this->safari_park_zone_model->entry_gate_latitude = $this->entry_gate_latitude;
        $this->safari_park_zone_model->entry_gate_longitude = $this->entry_gate_longitude;
        $this->safari_park_zone_model->is_open_in_monsoon = $this->is_open_in_monsoon;
        $this->safari_park_zone_model->status = $this->status;
    }
}
