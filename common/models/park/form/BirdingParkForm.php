<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\BirdingPark;
use common\models\park\BirdingParkAccomodation;
use common\models\park\BirdingParkAnimal;
use common\models\park\BirdingParkBonusExperience;
use common\models\park\BirdingParkMonth;
use common\models\park\BirdingParkSession;
use common\models\park\BirdingParkVehicle;

/**
 * Update and Create Safari Park
 */
class BirdingParkForm extends model
{
    public $title;
    public $logo;
    public $feature_image;
    public $slug;
    public $vehicle_id;
    public $master_animal_id;
    public $master_bonus_experience_id;
    public $accomodation;
    public $birding_session;
    public $month;
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
    public $pincode;
    public $avg_safari_price_min;
    public $avg_safari_price_max;
    public $nearest_railway_station;
    public $nearest_railway_station_distance;
    public $nearest_airport;
    public $nearest_airport_distance;

    public $nearest_railway_station_two;
    public $nearest_railway_station_distance_two;
    public $nearest_airport_two;
    public $nearest_airport_distance_two;


    public $nearest_bus_station;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $latitude;
    public $longitude;
    public $about_title;
    public $about_description;
    public $module_title;
    public $module_description;
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
            $this->pincode = $this->birding_park_model->pincode;
            $this->avg_safari_price_min = $this->birding_park_model->avg_safari_price_min;
            $this->avg_safari_price_max = $this->birding_park_model->avg_safari_price_max;
            $this->nearest_railway_station = $this->birding_park_model->nearest_railway_station;
            $this->nearest_railway_station_distance = $this->birding_park_model->nearest_railway_station_distance;
            $this->nearest_airport = $this->birding_park_model->nearest_airport;
            $this->nearest_airport_distance = $this->birding_park_model->nearest_airport_distance;


            $this->nearest_railway_station_two = $this->birding_park_model->nearest_railway_station_two;
            $this->nearest_railway_station_distance_two = $this->birding_park_model->nearest_railway_station_distance_two;
            $this->nearest_airport_two = $this->birding_park_model->nearest_airport_two;
            $this->nearest_airport_distance_two = $this->birding_park_model->nearest_airport_distance_two;


            $this->nearest_bus_station = $this->birding_park_model->nearest_bus_station;
            $this->meta_title = $this->birding_park_model->meta_title;
            $this->meta_description = $this->birding_park_model->meta_description;
            $this->meta_keywords = $this->birding_park_model->meta_keywords;
            $this->latitude = $this->birding_park_model->latitude;
            $this->longitude = $this->birding_park_model->longitude;
            $this->about_title = $this->birding_park_model->about_title;
            $this->about_description = $this->birding_park_model->about_description;
            $this->module_title = $this->birding_park_model->module_title;
            $this->module_description = $this->birding_park_model->module_description;
            $this->status = $this->birding_park_model->status;
            $this->vehicle_id = BirdingParkVehicle::find()->select('vehicle_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
            $this->master_animal_id = BirdingParkAnimal::find()->select('master_animal_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
            $this->master_bonus_experience_id = BirdingParkBonusExperience::find()->select('master_bonus_experience_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
            $this->month = BirdingParkMonth::find()->select('month_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
            $this->birding_session = BirdingParkSession::find()->select('session_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
            $this->accomodation = BirdingParkAccomodation::find()->select('master_accomodation_id')->where(['birding_park_id' => $this->birding_park_model->id, 'status' => 1])->column();
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'feature_image', 'state_id', 'city_id', 'master_location_id', 'about_title'], 'required', 'on' => 'create'],
            [['title', 'state_id', 'city_id', 'master_location_id', 'about_title'], 'required', 'on' => 'update'],
            [['nearest_airport', 'nearest_railway_station', 'nearest_airport_two', 'nearest_railway_station_two', 'module_title'], 'required', 'on' => 'howtoreach'],

            [['status', 'avg_safari_price_min', 'avg_safari_price_max', 'nearest_airport_distance', 'nearest_railway_station_distance', 'nearest_airport_distance_two', 'nearest_railway_station_distance_two'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 251],
            [['long_description', 'meta_title', 'meta_description'], 'string'],
            [['long_description'], 'validateMaxWords', 'params' => ['max' => 200]],
            [['status', 'master_location_id', 'country_id', 'state_id', 'city_id'], 'default', 'value' => 1],
            [[
                'master_bonus_experience_id', 'official_website', 'country_name', 'state_name', 'city_name', 'short_description', 'long_description',
                'vehicle_id', 'master_animal_id', 'birding_session', 'month', 'accomodation', 'logo', 'feature_image', 'pincode', 'latitude', 'longitude', 'nearest_railway_station', 'nearest_airport', 'nearest_railway_station_two', 'nearest_airport_two',
                'about_title', 'about_description', 'meta_keywords', 'module_title', 'module_description'
            ], 'safe'],
            [['uploadfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
            ['uploadfile', 'required', 'on' => 'uploadfile'],
            ['nearest_airport', function () {
                if ($this->nearest_airport === $this->nearest_airport_two) {
                    $this->addError('nearest_airport_two', 'Both Airport Should not match');
                }
            }],
            ['nearest_railway_station', function () {
                if ($this->nearest_railway_station === $this->nearest_railway_station_two) {
                    $this->addError('nearest_railway_station_two', 'Both Railway Station Should not match');
                }
            }],
            [
                ['logo', 'feature_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                // 'minWidth' => 500,
                // 'maxWidth' => 500,
                // 'maxHeight' => 123,
                // 'minHeight' => 123,
                'maxSize' => 250 * 1024
            ],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = [
            'title', 'slug', 'status', 'avg_safari_price_min', 'avg_safari_price_max', 'nearest_airport_distance', 'nearest_airport', 'nearest_railway_station_distance', 'nearest_railway_station',
            'long_description', 'meta_title', 'meta_description', 'status', 'master_location_id', 'country_id', 'state_id', 'city_id',
            'master_bonus_experience_id', 'official_website', 'country_name', 'state_name', 'city_name', 'short_description',
            'vehicle_id', 'master_animal_id', 'birding_session', 'month', 'accomodation', 'logo', 'feature_image', 'pincode', 'latitude', 'longitude'
        ];
        $scenarios['update'] = [
            'title', 'slug', 'status', 'avg_safari_price_min', 'avg_safari_price_max', 'nearest_airport_distance', 'nearest_airport', 'nearest_railway_station_distance', 'nearest_railway_station',
            'long_description', 'meta_title', 'meta_description', 'status', 'master_location_id', 'country_id', 'state_id', 'city_id',
            'master_bonus_experience_id', 'official_website', 'country_name', 'state_name', 'city_name', 'short_description',
            'vehicle_id', 'master_animal_id', 'birding_session', 'month', 'accomodation', 'logo', 'feature_image', 'pincode', 'latitude', 'longitude', 'about_title', 'about_description', 'meta_keywords'
        ];
        $scenarios['howtoreach'] = [
            'status', 'nearest_airport_distance', 'nearest_airport', 'nearest_railway_station_distance', 'nearest_railway_station', 'nearest_airport_distance_two', 'nearest_airport_two', 'nearest_railway_station_distance_two', 'nearest_railway_station_two',
            'module_title', 'module_description'
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
            'state_id' => 'State *',
            'state_name' => 'State Name',
            'city_id' => 'City *',
            'city_name' => 'City Name',
            'about_title' => 'About Title *',
            'module_title' => 'Module Title *',
            'feature_image' => 'Feature Image (JPEG /JPG or PNG / 250 KB) *',
            'logo' => 'Logo (JPEG /JPG or PNG / 250 KB) *',
            'avg_safari_price_min' => 'Avg Safari Price',
            'nearest_railway_station' => 'Nearest Railway',
            'nearest_railway_station_distance' => 'Nearest Railway Station Distance (in km)',
            'nearest_airport' => 'Airport',
            'nearest_airport_distance' => 'Nearest Airport Distance  (in km)',
            'nearest_railway_station_two' => 'Nearest Railway',
            'nearest_railway_station_distance_two' => 'Nearest Railway Station Distance (in km)',
            'nearest_airport_two' => 'Airport',
            'nearest_airport_distance_two' => 'Nearest Airport Distance  (in km)',
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
        $this->birding_park_model->pincode = $this->pincode;
        $this->birding_park_model->avg_safari_price_min = $this->avg_safari_price_min;
        $this->birding_park_model->avg_safari_price_max = $this->avg_safari_price_max;
        $this->birding_park_model->nearest_railway_station = $this->nearest_railway_station;
        $this->birding_park_model->nearest_railway_station_distance = $this->nearest_railway_station_distance;
        $this->birding_park_model->nearest_airport = $this->nearest_airport;
        $this->birding_park_model->nearest_airport_distance = $this->nearest_airport_distance;


        $this->birding_park_model->nearest_railway_station_two = $this->nearest_railway_station_two;
        $this->birding_park_model->nearest_railway_station_distance_two = $this->nearest_railway_station_distance_two;
        $this->birding_park_model->nearest_airport_two = $this->nearest_airport_two;
        $this->birding_park_model->nearest_airport_distance_two = $this->nearest_airport_distance_two;

        $this->birding_park_model->nearest_bus_station = $this->nearest_bus_station;
        $this->birding_park_model->meta_title = $this->meta_title;
        $this->birding_park_model->meta_description = $this->meta_description;
        $this->birding_park_model->meta_keywords = $this->meta_keywords;
        $this->birding_park_model->latitude = $this->latitude;
        $this->birding_park_model->longitude = $this->longitude;
        $this->birding_park_model->about_title = $this->about_title;
        $this->birding_park_model->about_description = $this->about_description;
        $this->birding_park_model->module_title = $this->module_title;
        $this->birding_park_model->module_description = $this->module_description;
        $this->birding_park_model->status = $this->status;
    }



    public function uploadFile()
    {

        if ($this->logo) {
            $storagePath = Yii::$app->params['datapath'] . '/birdingpark';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->birding_park_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'logo' . time() . '.' . $this->logo->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->logo->saveAs($filePath)) {
                $this->birding_park_model->logo = $fileName;
                $this->birding_park_model->save(false);
            }
        }
        if ($this->feature_image) {
            $storagePath = Yii::$app->params['datapath'] . '/birdingpark';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->birding_park_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'park_feature_image' . time() . '.' . $this->feature_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->feature_image->saveAs($filePath)) {
                $this->birding_park_model->feature_image = $fileName;
                $this->birding_park_model->save(false);
            }
        }
    }
}
