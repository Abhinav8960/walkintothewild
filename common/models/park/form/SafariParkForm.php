<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use common\models\park\SafariParkAccomodation;
use common\models\park\SafariParkAnimal;
use common\models\park\SafariParkBonusExperience;
use common\models\park\SafariParkMonth;
use common\models\park\SafariParkRareAnimal;
use common\models\park\SafariParkSession;
use common\models\park\SafariParkVehicle;

/**
 * Update and Create Safari Park
 */
class SafariParkForm extends model
{
    public $title;
    public $logo;
    public $feature_image;
    public $slug;
    public $vehicle_id;
    public $master_animal_id;
    public $master_rare_animal_id;
    public $animal_text;
    public $master_bonus_experience_id;
    public $accomodation;
    public $safari_session;
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
    public $nearest_railway_station_three;
    public $nearest_railway_station_distance_three;
    public $nearest_railway_station_four;
    public $nearest_railway_station_distance_four;
    public $nearest_railway_station_five;
    public $nearest_railway_station_distance_five;

    public $nearest_airport_two;
    public $nearest_airport_distance_two;
    public $nearest_airport_three;
    public $nearest_airport_distance_three;
    public $nearest_airport_four;
    public $nearest_airport_distance_four;
    public $nearest_airport_five;
    public $nearest_airport_distance_five;

    public $is_published;
    public $florafauna;


    public $nearest_bus_station;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $latitude;
    public $longitude;
    public $month_note;
    public $about_title;
    public $about_description;
    public $module_title;
    public $module_description;
    public $status;
    public $status_option = [];
    public $safari_park_model;
    public $uploadfile;



    public function __construct(SafariPark $safari_park_model = null)
    {

        $this->safari_park_model = Yii::createObject([
            'class' => SafariPark::className()
        ]);

        if ($safari_park_model  != '') {
            $this->safari_park_model = $safari_park_model;
            $this->title = $this->safari_park_model->title;
            $this->slug = $this->safari_park_model->slug;
            $this->short_description = $this->safari_park_model->short_description;
            $this->long_description = $this->safari_park_model->long_description;
            $this->official_website = $this->safari_park_model->official_website;
            $this->master_location_id = $this->safari_park_model->master_location_id;
            $this->country_id = $this->safari_park_model->country_id;
            $this->country_name = $this->safari_park_model->country_name;
            $this->state_id = $this->safari_park_model->state_id;
            $this->state_name = $this->safari_park_model->state_name;
            $this->city_id = $this->safari_park_model->city_id;
            $this->city_name = $this->safari_park_model->city_name;
            $this->pincode = $this->safari_park_model->pincode;
            $this->avg_safari_price_min = $this->safari_park_model->avg_safari_price_min;
            $this->avg_safari_price_max = $this->safari_park_model->avg_safari_price_max;
            $this->nearest_railway_station = $this->safari_park_model->nearest_railway_station;
            $this->nearest_railway_station_distance = $this->safari_park_model->nearest_railway_station_distance;
            $this->nearest_airport = $this->safari_park_model->nearest_airport;
            $this->nearest_airport_distance = $this->safari_park_model->nearest_airport_distance;


            $this->nearest_railway_station_two = $this->safari_park_model->nearest_railway_station_two;
            $this->nearest_railway_station_distance_two = $this->safari_park_model->nearest_railway_station_distance_two;
            $this->nearest_railway_station_three = $this->safari_park_model->nearest_railway_station_three;
            $this->nearest_railway_station_distance_three = $this->safari_park_model->nearest_railway_station_distance_three;
            $this->nearest_railway_station_four = $this->safari_park_model->nearest_railway_station_four;
            $this->nearest_railway_station_distance_four = $this->safari_park_model->nearest_railway_station_distance_four;
            $this->nearest_railway_station_five = $this->safari_park_model->nearest_railway_station_five;
            $this->nearest_railway_station_distance_five = $this->safari_park_model->nearest_railway_station_distance_five;

            $this->nearest_airport_two = $this->safari_park_model->nearest_airport_two;
            $this->nearest_airport_distance_two = $this->safari_park_model->nearest_airport_distance_two;
            $this->nearest_airport_three = $this->safari_park_model->nearest_airport_three;
            $this->nearest_airport_distance_three = $this->safari_park_model->nearest_airport_distance_three;
            $this->nearest_airport_four = $this->safari_park_model->nearest_airport_four;
            $this->nearest_airport_distance_four = $this->safari_park_model->nearest_airport_distance_four;
            $this->nearest_airport_five = $this->safari_park_model->nearest_airport_five;
            $this->nearest_airport_distance_five = $this->safari_park_model->nearest_airport_distance_five;

            $this->nearest_bus_station = $this->safari_park_model->nearest_bus_station;
            $this->meta_title = $this->safari_park_model->meta_title;
            $this->meta_description = $this->safari_park_model->meta_description;
            $this->meta_keywords = $this->safari_park_model->meta_keywords;
            $this->latitude = $this->safari_park_model->latitude;
            $this->longitude = $this->safari_park_model->longitude;
            $this->month_note = $this->safari_park_model->month_note;
            $this->about_title = $this->safari_park_model->about_title;
            $this->about_description = $this->safari_park_model->about_description;
            $this->module_title = $this->safari_park_model->module_title;
            $this->module_description = $this->safari_park_model->module_description;
            $this->florafauna = $this->safari_park_model->florafauna;
            $this->animal_text = $this->safari_park_model->animal_text;
            $this->status = $this->safari_park_model->status;
            $this->vehicle_id = SafariParkVehicle::find()->select('vehicle_id')->where(['safari_park_id' => $this->safari_park_model->id, 'status' => 1])->column();
            $this->master_animal_id = SafariParkAnimal::find()->select('master_animal_id', 'master_animal_id')->where(['safari_park_id' => $this->safari_park_model->id, 'status' => 1])->column();
            $this->master_rare_animal_id = SafariParkRareAnimal::find()->select('master_rare_animal_id')->where(['safari_park_id' => $this->safari_park_model->id, 'status' => 1])->column();
            $this->master_bonus_experience_id = SafariParkBonusExperience::find()->select('master_bonus_experience_id')->where(['safari_park_id' => $this->safari_park_model->id, 'status' => 1])->column();
            $this->month = SafariParkMonth::find()->select('month_id')->where(['safari_park_id' => $this->safari_park_model->id, 'status' => 1])->column();
            $this->safari_session = SafariParkSession::find()->select('session_id')->where(['safari_park_id' => $this->safari_park_model->id, 'status' => 1])->column();
            $this->accomodation = SafariParkAccomodation::find()->select('master_accomodation_id')->where(['safari_park_id' => $this->safari_park_model->id, 'status' => 1])->column();
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'state_id', 'city_id', 'master_location_id'], 'required', 'on' => 'create'],
            [['title', 'state_id', 'city_id', 'master_location_id'], 'required', 'on' => 'update'],
            [['module_title'], 'required', 'on' => 'howtoreach'],
            [['florafauna'], 'required', 'on' => 'florafauna'],
            [['meta_title', 'slug'], 'required', 'on' => 'meta'],

            ['pincode', 'string', 'length' => [6, 6]],
            [['status', 'avg_safari_price_min', 'avg_safari_price_max', 'nearest_airport_distance', 'nearest_railway_station_distance', 'nearest_airport_distance_two', 'nearest_railway_station_distance_two', 'nearest_railway_station_distance_three', 'nearest_railway_station_distance_four', 'nearest_railway_station_distance_five', 'nearest_airport_distance_three', 'nearest_airport_distance_four', 'nearest_airport_distance_five'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['short_description'], 'validateMaxWords', 'params' => ['max' => 70]],
            [['long_description', 'meta_title', 'meta_description'], 'string'],
            [['long_description'], 'validateMaxWords', 'params' => ['max' => 140]],
            [['status', 'country_id', 'is_published'], 'default', 'value' => 1],
            [[
                'master_bonus_experience_id', 'official_website', 'country_name', 'state_name', 'city_name', 'short_description', 'long_description',
                'vehicle_id', 'master_animal_id', 'master_rare_animal_id', 'safari_session', 'month', 'accomodation', 'logo', 'feature_image', 'pincode', 'latitude', 'longitude', 'nearest_railway_station', 'nearest_airport', 'nearest_railway_station_two', 'nearest_airport_two',
                'about_title', 'about_description', 'meta_keywords', 'module_title', 'module_description', 'month_note', 'animal_text', 'nearest_railway_station_three', 'nearest_railway_station_four', 'nearest_railway_station_five', 'nearest_airport_three', 'nearest_airport_four', 'nearest_airport_five'
            ], 'safe'],
            [['uploadfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
            ['uploadfile', 'required', 'on' => 'uploadfile'],


            ///////////////////////////////////   railway station validation    ///////////////////////////////////

            ['nearest_railway_station', function () {
                if ($this->nearest_railway_station === $this->nearest_railway_station_two) {
                    $this->addError('nearest_railway_station_two', 'Railway Station Should not match');
                }
                if ($this->nearest_railway_station === $this->nearest_railway_station_three) {
                    $this->addError('nearest_railway_station_three', 'Railway Station Should not match');
                }
                if ($this->nearest_railway_station === $this->nearest_railway_station_four) {
                    $this->addError('nearest_railway_station_four', 'Railway Station Should not match');
                }
                if ($this->nearest_railway_station === $this->nearest_railway_station_five) {
                    $this->addError('nearest_railway_station_five', 'Railway Station Should not match');
                }
            }],

            ['nearest_railway_station_two', function () {

                if ($this->nearest_railway_station_two === $this->nearest_railway_station_three) {
                    $this->addError('nearest_railway_station_three', 'Railway Station Should not match');
                }
                if ($this->nearest_railway_station_two === $this->nearest_railway_station_four) {
                    $this->addError('nearest_railway_station_four', 'Railway Station Should not match');
                }
                if ($this->nearest_railway_station_two === $this->nearest_railway_station_five) {
                    $this->addError('nearest_railway_station_five', 'Railway Station Should not match');
                }
            }],

            ['nearest_railway_station_three', function () {

                if ($this->nearest_railway_station_three === $this->nearest_railway_station_four) {
                    $this->addError('nearest_railway_station_four', 'Railway Station Should not match');
                }
                if ($this->nearest_railway_station_three === $this->nearest_railway_station_five) {
                    $this->addError('nearest_railway_station_five', 'Railway Station Should not match');
                }
            }],

            ['nearest_railway_station_four', function () {

                if ($this->nearest_railway_station_four === $this->nearest_railway_station_five) {
                    $this->addError('nearest_railway_station_five', 'Railway Station Should not match');
                }
            }],

            ///////////////////////////////////   railway station distance validation    ///////////////////////////////////


            ['nearest_railway_station_distance', function () {
                if ($this->nearest_railway_station_distance === $this->nearest_railway_station_distance_two) {
                    $this->addError('nearest_railway_station_distance_two', 'Railway Station Distance Should not match');
                }
                if ($this->nearest_railway_station_distance === $this->nearest_railway_station_distance_three) {
                    $this->addError('nearest_railway_station_distance_three', 'Railway Station Distance Should not match');
                }
                if ($this->nearest_railway_station_distance === $this->nearest_railway_station_distance_four) {
                    $this->addError('nearest_railway_station_distance_four', 'Railway Station Distance Should not match');
                }
                if ($this->nearest_railway_station_distance === $this->nearest_railway_station_distance_five) {
                    $this->addError('nearest_railway_station_distance_five', 'Railway Station Distance Should not match');
                }
            }],

            ['nearest_railway_station_distance_two', function () {

                if ($this->nearest_railway_station_distance_two === $this->nearest_railway_station_distance_three) {
                    $this->addError('nearest_railway_station_distance_three', 'Railway Station Distance Should not match');
                }
                if ($this->nearest_railway_station_distance_two === $this->nearest_railway_station_distance_four) {
                    $this->addError('nearest_railway_station_distance_four', 'Railway Station Distance Should not match');
                }
                if ($this->nearest_railway_station_distance_two === $this->nearest_railway_station_distance_five) {
                    $this->addError('nearest_railway_station_distance_five', 'Railway Station Distance Should not match');
                }
            }],

            ['nearest_railway_station_distance_three', function () {

                if ($this->nearest_railway_station_distance_three === $this->nearest_railway_station_distance_four) {
                    $this->addError('nearest_railway_station_distance_four', 'Railway Station Distance Should not match');
                }
                if ($this->nearest_railway_station_distance_three === $this->nearest_railway_station_distance_five) {
                    $this->addError('nearest_railway_station_distance_five', 'Railway Station Distance Should not match');
                }
            }],

            ['nearest_railway_station_distance_four', function () {

                if ($this->nearest_railway_station_distance_four === $this->nearest_railway_station_distance_five) {
                    $this->addError('nearest_railway_station_distance_five', 'Railway Station Distance Should not match');
                }
            }],




            ///////////////////////////////////   airport validation    ///////////////////////////////////


            ['nearest_airport', function () {
                if ($this->nearest_airport === $this->nearest_airport_two) {
                    $this->addError('nearest_airport_two', 'Airport Should not match');
                }
                if ($this->nearest_airport === $this->nearest_airport_three) {
                    $this->addError('nearest_airport_three', 'Airport Should not match');
                }
                if ($this->nearest_airport === $this->nearest_airport_four) {
                    $this->addError('nearest_airport_four', 'Airport Should not match');
                }
                if ($this->nearest_airport === $this->nearest_airport_five) {
                    $this->addError('nearest_airport_five', 'Airport Should not match');
                }
            }],

            ['nearest_airport_two', function () {
                if ($this->nearest_airport_two == $this->nearest_airport_three) {
                    $this->addError('nearest_airport_three', 'Airport Should not match');
                }
                if ($this->nearest_airport_two == $this->nearest_airport_four) {
                    $this->addError('nearest_airport_four', 'Airport Should not match');
                }
                if ($this->nearest_airport_two == $this->nearest_airport_five) {
                    $this->addError('nearest_airport_five', 'Airport Should not match');
                }
            }],

            ['nearest_airport_three', function () {
                if ($this->nearest_airport_three == $this->nearest_airport_four) {
                    $this->addError('nearest_airport_four', 'Airport Should not match');
                }
                if ($this->nearest_airport_three == $this->nearest_airport_five) {
                    $this->addError('nearest_airport_five', 'Airport Should not match');
                }
            }],

            ['nearest_airport_four', function () {
                if ($this->nearest_airport_four == $this->nearest_airport_five) {
                    $this->addError('nearest_airport_five', 'Airport Should not match');
                }
            }],


            ///////////////////////////////////   airport distance validation    ///////////////////////////////////


            ['nearest_airport_distance', function () {
                if ($this->nearest_airport_distance === $this->nearest_airport_distance_two) {
                    $this->addError('nearest_airport_distance_two', 'Airport Distance Should not match');
                }
                if ($this->nearest_airport_distance === $this->nearest_airport_distance_three) {
                    $this->addError('nearest_airport_distance_three', 'Airport Distance Should not match');
                }
                if ($this->nearest_airport_distance === $this->nearest_airport_distance_four) {
                    $this->addError('nearest_airport_distance_four', 'Airport Distance Should not match');
                }
                if ($this->nearest_airport_distance === $this->nearest_airport_distance_five) {
                    $this->addError('nearest_airport_distance_five', 'Airport Distance Should not match');
                }
            }],

            ['nearest_airport_distance_two', function () {
                if ($this->nearest_airport_distance_two == $this->nearest_airport_distance_three) {
                    $this->addError('nearest_airport_distance_three', 'Airport Distance Should not match');
                }
                if ($this->nearest_airport_distance_two == $this->nearest_airport_distance_four) {
                    $this->addError('nearest_airport_distance_four', 'Airport Distance Should not match');
                }
                if ($this->nearest_airport_distance_two == $this->nearest_airport_distance_five) {
                    $this->addError('nearest_airport_distance_five', 'Airport Distance Should not match');
                }
            }],

            ['nearest_airport_distance_three', function () {
                if ($this->nearest_airport_distance_three == $this->nearest_airport_distance_four) {
                    $this->addError('nearest_airport_distance_four', 'Airport Distance Should not match');
                }
                if ($this->nearest_airport_distance_three == $this->nearest_airport_distance_five) {
                    $this->addError('nearest_airport_distance_five', 'Airport Distance Should not match');
                }
            }],

            ['nearest_airport_distance_four', function () {
                if ($this->nearest_airport_distance_four == $this->nearest_airport_distance_five) {
                    $this->addError('nearest_airport_distance_five', 'Airport Distance Should not match');
                }
            }],


            //////////////////////////////////////////////////////////////////////////////////

            [
                ['feature_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 380,
                'maxWidth' => 380,
                'maxHeight' => 600,
                'minHeight' => 600,
                'maxSize' => 250 * 1024
            ],
            [
                ['logo'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 350,
                'maxWidth' => 350,
                'maxHeight' => 350,
                'minHeight' => 350,
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
            'vehicle_id', 'master_animal_id', 'master_rare_animal_id', 'safari_session', 'month', 'accomodation', 'logo', 'feature_image', 'pincode', 'latitude', 'longitude', 'month_note', 'animal_text'
        ];
        $scenarios['update'] = [
            'title', 'slug', 'status', 'avg_safari_price_min', 'avg_safari_price_max', 'nearest_airport_distance', 'nearest_airport', 'nearest_railway_station_distance', 'nearest_railway_station',
            'long_description', 'meta_title', 'meta_description', 'status', 'master_location_id', 'country_id', 'state_id', 'city_id',
            'master_bonus_experience_id', 'official_website', 'country_name', 'state_name', 'city_name', 'short_description',
            'vehicle_id', 'master_animal_id', 'master_rare_animal_id', 'safari_session', 'month', 'accomodation', 'logo', 'feature_image', 'pincode', 'latitude', 'longitude', 'about_title', 'about_description', 'meta_keywords', 'month_note', 'animal_text'
        ];
        $scenarios['howtoreach'] = [
            'status', 'nearest_airport_distance', 'nearest_airport', 'nearest_railway_station_distance', 'nearest_railway_station', 'nearest_airport_distance_two', 'nearest_airport_two', 'nearest_railway_station_distance_two', 'nearest_railway_station_two',
            'module_title', 'module_description', 'nearest_railway_station_distance_three', 'nearest_railway_station_distance_four', 'nearest_railway_station_distance_five', 'nearest_airport_distance_three', 'nearest_airport_distance_four', 'nearest_airport_distance_five',
            'nearest_railway_station_three', 'nearest_railway_station_four', 'nearest_railway_station_five', 'nearest_airport_three', 'nearest_airport_four', 'nearest_airport_five'
        ];
        $scenarios['media'] = ['logo', 'feature_image', 'status'];
        $scenarios['florafauna'] = ['florafauna'];
        $scenarios['map'] = [
            'latitude', 'longitude', 'status'
        ];
        $scenarios['meta'] = ['meta_title', 'meta_keywords', 'meta_description', 'status', 'slug'];
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
            'title' => 'Title *',
            'slug' => 'Slug',
            'park_type_id' => 'Park Type',
            'vehicle_id' => 'Vehicle',
            'master_animal_id' => 'Animal (For Listing filter result)',
            'master_rare_animal_id' => 'Rare Animal ( For Home Page Listing)',
            'animal_text' => 'Animal Text ( For Park View Page)',
            'short_description' => 'Featured Description',
            'long_description' => 'Description',
            'florafauna' => 'Flora Fauna',
            'official_website' => 'Official Website',
            'master_location_id' => 'Location *',
            'country_id' => 'Country',
            'country_name' => 'Country Name',
            'state_id' => 'State *',
            'state_name' => 'State Name',
            'city_id' => 'City *',
            'city_name' => 'City Name',
            'about_title' => 'About Title *',
            'module_title' => 'Module Title *',
            'feature_image' => 'Feature Image (JPEG /JPG or PNG / 380 Pixels x 600 Pixels / 250 KB) *',
            'logo' => 'Dp Image (JPEG /JPG or PNG / 350 Pixels x 350 Pixels/ 250 KB) *',
            'avg_safari_price_min' => 'Avg Safari Price',
            'nearest_railway_station' => 'Nearest Railway',
            'nearest_railway_station_distance' => 'Nearest Railway Station Distance (in km)',
            'nearest_airport' => 'Airport',
            'nearest_airport_distance' => 'Nearest Airport Distance  (in km)',
            'nearest_railway_station_two' => 'Nearest Railway',
            'nearest_railway_station_distance_two' => 'Nearest Railway Station Distance (in km)',
            'nearest_railway_station_three' => 'Nearest Railway three',
            'nearest_railway_station_distance_three' => 'Nearest Railway Station Distance three',
            'nearest_railway_station_four' => 'Nearest Railway four',
            'nearest_railway_station_distance_four' => 'Nearest Railway Station Distance four',
            'nearest_railway_station_five' => 'Nearest Railway five',
            'nearest_railway_station_distance_five' => 'Nearest Railway Station Distance five',
            'nearest_airport_two' => 'Airport',
            'nearest_airport_distance_two' => 'Nearest Airport Distance  (in km)',
            'nearest_airport_three' => 'Airport three',
            'nearest_airport_distance_three' => 'Nearest Airport Distance three',
            'nearest_airport_four' => 'Airport four',
            'nearest_airport_distance_four' => 'Nearest Airport Distance four',
            'nearest_airport_five' => 'Airport five',
            'nearest_airport_distance_five' => 'Nearest Airport Distance five',

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
        $this->safari_park_model->title = $this->title;
        $this->safari_park_model->slug = $this->slug;
        $this->safari_park_model->short_description = $this->short_description;
        $this->safari_park_model->long_description = $this->long_description;
        $this->safari_park_model->official_website = $this->official_website;
        $this->safari_park_model->master_location_id = $this->master_location_id;
        $this->safari_park_model->country_id = $this->country_id;
        $this->safari_park_model->country_name = $this->country_name;
        $this->safari_park_model->state_id = $this->state_id;
        $this->safari_park_model->state_name = $this->state_name;
        $this->safari_park_model->city_id = $this->city_id;
        $this->safari_park_model->city_name = $this->city_name;
        $this->safari_park_model->pincode = $this->pincode;
        $this->safari_park_model->avg_safari_price_min = $this->avg_safari_price_min;
        $this->safari_park_model->avg_safari_price_max = $this->avg_safari_price_max;
        $this->safari_park_model->nearest_railway_station = $this->nearest_railway_station;
        $this->safari_park_model->nearest_railway_station_distance = $this->nearest_railway_station_distance;
        $this->safari_park_model->nearest_airport = $this->nearest_airport;
        $this->safari_park_model->nearest_airport_distance = $this->nearest_airport_distance;


        $this->safari_park_model->nearest_railway_station_two = $this->nearest_railway_station_two;
        $this->safari_park_model->nearest_railway_station_distance_two = $this->nearest_railway_station_distance_two;
        $this->safari_park_model->nearest_railway_station_three = $this->nearest_railway_station_three;
        $this->safari_park_model->nearest_railway_station_distance_three = $this->nearest_railway_station_distance_three;
        $this->safari_park_model->nearest_railway_station_four = $this->nearest_railway_station_four;
        $this->safari_park_model->nearest_railway_station_distance_four = $this->nearest_railway_station_distance_four;
        $this->safari_park_model->nearest_railway_station_five = $this->nearest_railway_station_five;
        $this->safari_park_model->nearest_railway_station_distance_five = $this->nearest_railway_station_distance_five;

        $this->safari_park_model->nearest_airport_two = $this->nearest_airport_two;
        $this->safari_park_model->nearest_airport_distance_two = $this->nearest_airport_distance_two;
        $this->safari_park_model->nearest_airport_three = $this->nearest_airport_three;
        $this->safari_park_model->nearest_airport_distance_three = $this->nearest_airport_distance_three;
        $this->safari_park_model->nearest_airport_four = $this->nearest_airport_four;
        $this->safari_park_model->nearest_airport_distance_four = $this->nearest_airport_distance_four;
        $this->safari_park_model->nearest_airport_five = $this->nearest_airport_five;
        $this->safari_park_model->nearest_airport_distance_five = $this->nearest_airport_distance_five;

        $this->safari_park_model->nearest_bus_station = $this->nearest_bus_station;
        $this->safari_park_model->meta_title = $this->meta_title;
        $this->safari_park_model->meta_description = $this->meta_description;
        $this->safari_park_model->meta_keywords = $this->meta_keywords;
        $this->safari_park_model->latitude = $this->latitude;
        $this->safari_park_model->longitude = $this->longitude;
        $this->safari_park_model->month_note = $this->month_note;
        $this->safari_park_model->about_title = $this->about_title;
        $this->safari_park_model->about_description = $this->about_description;
        $this->safari_park_model->module_title = $this->module_title;
        $this->safari_park_model->module_description = $this->module_description;
        $this->safari_park_model->florafauna = $this->florafauna;
        $this->safari_park_model->animal_text = $this->animal_text;
        $this->safari_park_model->status = $this->status;
    }



    public function uploadFile()
    {

        if ($this->logo) {
            $storagePath = Yii::$app->params['datapath'] . '/safaripark';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->safari_park_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'logo' . time() . '.' . $this->logo->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->logo->saveAs($filePath)) {
                $this->safari_park_model->logo = $fileName;
                $this->safari_park_model->save(false);
            }
        }
        if ($this->feature_image) {
            $storagePath = Yii::$app->params['datapath'] . '/safaripark';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->safari_park_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'park_feature_image' . time() . '.' . $this->feature_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->feature_image->saveAs($filePath)) {
                $this->safari_park_model->feature_image = $fileName;
                $this->safari_park_model->save(false);
            }
        }
    }
}
