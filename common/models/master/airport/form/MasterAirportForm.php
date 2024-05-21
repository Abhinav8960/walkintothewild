<?php

namespace common\models\master\airport\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\airport\MasterAirport;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Holiday
 */
class MasterAirportForm extends model
{
    public $country_id;
    public $state_id;
    public $city_id;
    public $slug;
    public $name;
    public $status;
    public $status_option = [];
    public $airport_model;


    public function __construct(MasterAirport $airport_model = null)
    {

        $this->airport_model = Yii::createObject([
            'class' => MasterAirport::className()
        ]);



        if ($airport_model  != '') {
            $this->airport_model = $airport_model;
            $this->country_id = $this->airport_model->country_id;
            $this->state_id = $this->airport_model->state_id;
            $this->city_id = $this->airport_model->city_id;
            $this->slug = $this->airport_model->slug;
            $this->name = $this->airport_model->name;
            $this->status = $this->airport_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'state_id', 'country_id','name'], 'required'],
            [['status'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
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
            'name' => 'Name',
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
        $this->airport_model->country_id = $this->country_id;
        $this->airport_model->state_id = $this->state_id;
        $this->airport_model->city_id = $this->city_id;
        $this->airport_model->slug = $this->slug;
        $this->airport_model->name = $this->name;
        $this->airport_model->status = $this->status;
    }

}
