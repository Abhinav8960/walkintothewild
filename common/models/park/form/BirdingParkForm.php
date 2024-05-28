<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\BirdingPark;
use common\models\park\BirdingParkAnimal;
use common\models\park\BirdingParkBonusExperience;
use common\models\park\BirdingParkVehicle;

/**
 * Update and Create Birding Park
 */
class BirdingParkForm extends model
{
    public $title;
    public $slug;
    public $vehicle_id;
    public $master_animal_id;
    public $master_bonus_experience_id;
    public $short_description;
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
    public $nearest_railway_station_distance;
    public $nearest_airport;
    public $nearest_airport_distance;
    public $nearest_bus_station;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $latitude;
    public $longitude;
    public $status;
    public $status_option = [];
    public $birding_park_model;
    public $uploadfile;



    public function __construct(BirdingPark $birding_park_model = null)
    {

        $this->birding_park_model = Yii::createObject([
            'class' => BirdingPark::className()
        ]);

        if ($birding_park_model  != '') {
            $this->birding_park_model = $birding_park_model;
            $this->title = $this->birding_park_model->title;
            $this->slug = $this->birding_park_model->slug;
            $this->short_description = $this->birding_park_model->short_description;
            $this->long_description = $this->birding_park_model->long_description;
            $this->official_website = $this->birding_park_model->official_website;
            $this->master_location_id = $this->birding_park_model->master_location_id;
            $this->country_id = $this->birding_park_model->country_id;
            $this->country_name = $this->birding_park_model->country_name;
            $this->state_id = $this->birding_park_model->state_id;
            $this->state_name = $this->birding_park_model->state_name;
            $this->city_id = $this->birding_park_model->city_id;
            $this->city_name = $this->birding_park_model->city_name;
            $this->avg_safari_price = $this->birding_park_model->avg_safari_price;
            $this->nearest_railway_station = $this->birding_park_model->nearest_railway_station;
            $this->nearest_railway_station_distance = $this->birding_park_model->nearest_railway_station_distance;
            $this->nearest_airport = $this->birding_park_model->nearest_airport;
            $this->nearest_airport_distance = $this->birding_park_model->nearest_airport_distance;
            $this->nearest_bus_station = $this->birding_park_model->nearest_bus_station;
            $this->meta_title = $this->birding_park_model->meta_title;
            $this->meta_description = $this->birding_park_model->meta_description;
            $this->meta_keywords = $this->birding_park_model->meta_keywords;
            $this->latitude = $this->birding_park_model->latitude;
            $this->longitude = $this->birding_park_model->longitude;
            $this->status = $this->birding_park_model->status;
            $this->vehicle_id = BirdingParkVehicle::find()->select('vehicle_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
            $this->master_animal_id = BirdingParkAnimal::find()->select('master_animal_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
            $this->master_bonus_experience_id = BirdingParkBonusExperience::find()->select('master_bonus_experience_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
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
            [['status', 'avg_safari_price', 'nearest_airport_distance', 'nearest_railway_station_distance'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 251],
            [['long_description', 'meta_title', 'meta_description'], 'string'],
            [['long_description'], 'validateMaxWords', 'params' => ['max' => 200]],
            [['status', 'master_location_id', 'country_id', 'state_id', 'city_id'], 'default', 'value' => 1],
            [['master_bonus_experience_id', 'official_website', 'country_name', 'state_name', 'city_name', 'short_description', 'long_description', 'vehicle_id', 'master_animal_id'], 'safe'],
            [['uploadfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
            ['uploadfile', 'required', 'on' => 'uploadfile'],

        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = [
            'title', 'slug', 'status', 'avg_safari_price', 'nearest_airport_distance', 'nearest_railway_station_distance',
            'long_description', 'meta_title', 'meta_description', 'status', 'master_location_id', 'country_id', 'state_id', 'city_id',
            'master_bonus_experience_id', 'official_website', 'country_name', 'state_name', 'city_name', 'short_description', 'vehicle_id', 'master_animal_id'
        ];
        $scenarios['update'] = [
            'title', 'slug', 'status', 'avg_safari_price', 'nearest_airport_distance', 'nearest_railway_station_distance',
            'long_description', 'meta_title', 'meta_description', 'status', 'master_location_id', 'country_id', 'state_id', 'city_id',
            'master_bonus_experience_id', 'official_website', 'country_name', 'state_name', 'city_name', 'short_description', 'vehicle_id', 'master_animal_id'
        ];
        return $scenarios;
    }

    public function validateMaxWords($attribute, $params)
    {
        $maxWords = $params['max'];
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount > $maxWords) {
            $this->addError($attribute, "The Long Description must not exceed $maxWords words.");
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'slug' => 'Slug',
            'park_type_id' => 'Park Type',
            'vehicle_id' => 'Vehicle',
            'master_animal_id' => 'Animal',
            'short_description' => 'Short Description',
            'long_description' => 'Long Description',
            'official_website' => 'Official Website',
            'master_location_id' => 'Location',
            'country_id' => 'Country',
            'country_name' => 'Country Name',
            'state_id' => 'State',
            'state_name' => 'State Name',
            'city_id' => 'City',
            'city_name' => 'City Name',
            'avg_safari_price' => 'Avg Safari Price',
            'nearest_railway_station' => 'Nearest Railway Station',
            'nearest_railway_station_distance' => 'Nearest Railway Station Distance (in km)',
            'nearest_airport' => 'Nearest Airport',
            'nearest_airport_distance' => 'Nearest Airport Distance  (in km)',
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
        $this->birding_park_model->title = $this->title;
        $this->birding_park_model->slug = $this->slug;
        $this->birding_park_model->short_description = $this->short_description;
        $this->birding_park_model->long_description = $this->long_description;
        $this->birding_park_model->official_website = $this->official_website;
        $this->birding_park_model->master_location_id = $this->master_location_id;
        $this->birding_park_model->country_id = $this->country_id;
        $this->birding_park_model->country_name = $this->country_name;
        $this->birding_park_model->state_id = $this->state_id;
        $this->birding_park_model->state_name = $this->state_name;
        $this->birding_park_model->city_id = $this->city_id;
        $this->birding_park_model->city_name = $this->city_name;
        $this->birding_park_model->avg_safari_price = $this->avg_safari_price;
        $this->birding_park_model->nearest_railway_station = $this->nearest_railway_station;
        $this->birding_park_model->nearest_railway_station_distance = $this->nearest_railway_station_distance;
        $this->birding_park_model->nearest_airport = $this->nearest_airport;
        $this->birding_park_model->nearest_airport_distance = $this->nearest_airport_distance;
        $this->birding_park_model->nearest_bus_station = $this->nearest_bus_station;
        $this->birding_park_model->meta_title = $this->meta_title;
        $this->birding_park_model->meta_description = $this->meta_description;
        $this->birding_park_model->meta_keywords = $this->meta_keywords;
        $this->birding_park_model->latitude = $this->latitude;
        $this->birding_park_model->longitude = $this->longitude;
        $this->birding_park_model->status = $this->status;
    }
}
