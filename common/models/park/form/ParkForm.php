<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\Park;

/**
 * Update and Create Holiday
 */
class ParkForm extends model
{
    public $title;
    public $slug;
    public $vehicle_id;
    public $master_animal_id;
    public $sort_description;
    public $long_description;
    public $official_website;
    public $master_location_id;
    public $country_id;
    public $country_name;
    public $state_id;
    public $state_name;
    public $city_id;
    public $city_name;
    public $avg_safari_price;
    public $nearest_railway_station;
    public $nearest_airport;
    public $nearest_bus_station;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $latitude;
    public $longitude;
    public $status;
    public $status_option = [];
    public $park_model;


    public function __construct(Park $park_model = null)
    {

        $this->park_model = Yii::createObject([
            'class' => Park::className()
        ]);



        if ($park_model  != '') {
            $this->park_model = $park_model;
            $this->title = $this->park_model->title;
            $this->slug = $this->park_model->slug;
            $this->vehicle_id = $this->park_model->vehicle_id;
            $this->master_animal_id = $this->park_model->master_animal_id;
            $this->sort_description = $this->park_model->sort_description;
            $this->long_description = $this->park_model->long_description;
            $this->official_website = $this->park_model->official_website;
            $this->master_location_id = $this->park_model->master_location_id;
            $this->country_id = $this->park_model->country_id;
            $this->country_name = $this->park_model->country_name;
            $this->state_id = $this->park_model->state_id;
            $this->state_name = $this->park_model->state_name;
            $this->city_id = $this->park_model->city_id;
            $this->city_name = $this->park_model->city_name;
            $this->avg_safari_price = $this->park_model->avg_safari_price;
            $this->nearest_railway_station = $this->park_model->nearest_railway_station;
            $this->nearest_airport = $this->park_model->nearest_airport;
            $this->nearest_bus_station = $this->park_model->nearest_bus_station;
            $this->meta_title = $this->park_model->meta_title;
            $this->meta_description = $this->park_model->meta_description;
            $this->meta_keywords = $this->park_model->meta_keywords;
            $this->latitude = $this->park_model->latitude;
            $this->longitude = $this->park_model->longitude;
            $this->status = $this->park_model->status;
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
            'title' => 'Title',
            'slug' => 'Slug',
            'vehicle_id' => 'Vehicle Id',
            'master_animal_id' => 'Animal',
            'sort_description' => 'Sort Description',
            'long_description' => 'Long Description',
            'official_website' => 'Official Website',
            'master_location_id' => 'Master Location Id',
            'country_id' => 'country Id',
            'country_name' => 'Country Name',
            'state_id' => 'State Id',
            'state_name' => 'State Name',
            'city_id' => 'City Id',
            'city_name' => 'City Name',
            'avg_safari_price' => 'Avg Safari Price',
            'nearest_railway_station' => 'Nearest Railway Station',
            'nearest_airport' => 'Nearest Airport',
            'nearest_bus_station' => 'Nearest Bus Station',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
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
        $this->park_model->title = $this->title;
        $this->park_model->slug = $this->slug;
        $this->park_model->vehicle_id = $this->vehicle_id;
        $this->park_model->master_animal_id = $this->master_animal_id;
        $this->park_model->sort_description = $this->sort_description;
        $this->park_model->long_description = $this->long_description;
        $this->park_model->official_website = $this->official_website;
        $this->park_model->master_location_id = $this->master_location_id;
        $this->park_model->country_id = $this->country_id;
        $this->park_model->country_name = $this->country_name;
        $this->park_model->state_id = $this->state_id;
        $this->park_model->state_name = $this->state_name;
        $this->park_model->city_id = $this->city_id;
        $this->park_model->city_name = $this->city_name;
        $this->park_model->avg_safari_price = $this->avg_safari_price;
        $this->park_model->nearest_railway_station = $this->nearest_railway_station;
        $this->park_model->nearest_airport = $this->nearest_airport;
        $this->park_model->nearest_bus_station = $this->nearest_bus_station;
        $this->park_model->meta_title = $this->meta_title;
        $this->park_model->meta_description = $this->meta_description;
        $this->park_model->meta_keywords = $this->meta_keywords;
        $this->park_model->latitude = $this->latitude;
        $this->park_model->longitude = $this->longitude;
        $this->park_model->status = $this->status;
    }
}
