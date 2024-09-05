<?php

namespace common\models\package\form;

use Yii;
use common\models\package\Package;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;

class PackageForm extends \yii\base\Model
{
    public $owned_by_id;
    public $package_name;
    public $package_slug;
    public $no_of_day;
    public $no_of_night;
    public $safari_type;
    public $no_of_safari;
    public $start_location;
    public $end_location;
    public $start_date;
    public $end_date;
    public $package_image;
    public $package_banner_image;
    public $stay_category_id;
    public $cost_per_person;
    public $package_description;
    public $package_itinerary_overview;
    public $package_inclusion;
    public $package_exclusion;
    public $package_terms_condtition;
    public $privacy_policy;
    public $change_policy;
    public $what_you_must_carry;
    public $date_change_policy;
    public $refund_policy;
    public $getting_there;
    public $status;
    public $package_feature;
    public $package_included;
    public $package_park;

    public $day;
    public $day_title;
    public $day_description;
    public $day_start_location;
    public $day_end_location;
    public $hotel_name;
    public $day_image;
    public $meal_lunch;
    public $meal_breakfast;
    public $meal_dinner;
    public $day_activity;
    public $day_accommodation;
    public $day_note;
    public $day_status;


    public $type;
    public $gst_percentage;
    public $total_price;
    public $master_vehicle_id;
    public $popular_package;

    public $package_model;
    public $action_url;
    public $action_validate_url;


    /**
     * @param [type] $package_model
     */
    public function __construct(Package $package_model = null)
    {
        $this->package_model = Yii::createObject([
            'class' => Package::className()
        ]);
        if ($package_model != null) {
            $this->package_model = $package_model;
            $this->owned_by_id = $this->package_model->owned_by_id;
            $this->package_name = $this->package_model->package_name;
            $this->package_image = $this->package_model->package_image;
            $this->package_banner_image = $this->package_model->package_banner_image;
            // $this->package_slug = $this->package_model->package_slug;
            $this->no_of_day = $this->package_model->no_of_day;
            $this->no_of_night = $this->package_model->no_of_night;
            $this->no_of_safari = $this->package_model->no_of_safari;
            $this->safari_type = $this->package_model->safari_type;
            $this->start_location = $this->package_model->start_location;
            $this->end_location = $this->package_model->end_location;
            $this->start_date = $this->package_model->start_date;
            $this->end_date = $this->package_model->end_date;
            $this->stay_category_id = $this->package_model->stay_category_id;
            $this->cost_per_person = $this->package_model->cost_per_person;
            $this->package_description = $this->package_model->package_description;
            $this->package_itinerary_overview = $this->package_model->package_itinerary_overview;
            $this->package_inclusion = $this->package_model->package_inclusion;
            $this->package_exclusion = $this->package_model->package_exclusion;
            $this->package_terms_condtition = $this->package_model->package_terms_condtition;
            $this->privacy_policy = $this->package_model->privacy_policy;
            $this->change_policy = $this->package_model->change_policy;
            $this->what_you_must_carry = $this->package_model->what_you_must_carry;
            $this->date_change_policy = $this->package_model->date_change_policy;
            $this->refund_policy = $this->package_model->refund_policy;
            $this->getting_there = $this->package_model->getting_there;
            $this->master_vehicle_id = $this->package_model->master_vehicle_id;

            $this->type = $this->package_model->type;
            $this->gst_percentage = $this->package_model->gst_percentage;
            $this->popular_package = $this->package_model->popular_package;



            $this->status = $this->package_model->status;

            $this->package_feature = PackageFeature::find()->select('feature_id')->where(['package_id' => $this->package_model->id, 'status' => 1])->column();
            $this->package_included = PackageIncluded::find()->select('include_id', 'selection')->where(['package_id' => $this->package_model->id, 'status' => 1])->column();
            $this->package_park = PackageSafariPark::find()->select('park_id')->where(['package_id' => $this->package_model->id, 'status' => 1])->column();
        }
    }

    public function rules()
    {
        return [
            [
                ['package_image', 'package_banner_image'],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'maxSize' => 250 * 1024,
                'skipOnEmpty' => true,
            ],
            [['package_name', 'no_of_day', 'master_vehicle_id', 'cost_per_person'], 'required', 'on' => ['create', 'update']],
            // [['package_inclusion'], 'required', 'on' => 'inclusion'],
            [['package_exclusion'], 'required', 'on' => 'exclusion'],
            [['no_of_day', 'no_of_night', 'no_of_safari', 'stay_category_id', 'status', 'type', 'gst_percentage', 'total_price', 'master_vehicle_id'], 'integer'],
            [['cost_per_person'], 'number'],
            [['package_description', 'package_itinerary_overview', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry'], 'string'],
            [['package_feature', 'package_included', 'package_park', 'package_image', 'package_banner_image', 'getting_there'], 'safe'],
            [['package_name'], 'string', 'max' => 512],
            [['package_slug'], 'string', 'max' => 720],
            [['start_location', 'end_location'], 'string', 'max' => 255],
            [['start_date', 'end_date', 'date_change_policy', 'refund_policy', 'owned_by_id', 'safari_type'], 'safe'],



            [['package_id', 'day', 'meal_lunch', 'meal_breakfast', 'meal_dinner', 'status', 'popular_package'], 'integer'],
            [['day_description', 'day_activity', 'day_accommodation', 'day_note'], 'string'],
            [['day_title'], 'string', 'max' => 512],
            [['start_location', 'end_location', 'hotel_name', 'day_image'], 'string', 'max' => 255],
            [['package_id', 'day'], 'unique', 'targetAttribute' => ['package_id', 'day']],


        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = [
            'package_name',
            'package_image',
            'no_of_day',
            'no_of_night',
            'no_of_safari',
            'safari_type',
            'stay_category_id',
            'status',
            'cost_per_person',
            'package_description',
            'package_itinerary_overview',
            'package_inclusion',
            'package_exclusion',
            'package_terms_condtition',
            'package_feature',
            'package_included',
            'package_park',
            'package_banner_image',
            'start_location',
            'end_location',
            'start_date',
            'end_date',
            'owned_by_id',
            'type',
            'gst_percentage',
            'total_price',
            'master_vehicle_id',
            'popular_package'
        ];
        $scenarios['update'] = [
            'package_name',
            'package_image',
            'no_of_day',
            'no_of_night',
            'no_of_safari',
            'safari_type',
            'stay_category_id',
            'status',
            'cost_per_person',
            'package_description',
            'package_itinerary_overview',
            'package_inclusion',
            'package_exclusion',
            'package_terms_condtition',
            'package_feature',
            'package_included',
            'package_park',
            'package_banner_image',
            'start_location',
            'end_location',
            'start_date',
            'end_date',
            'type',
            'gst_percentage',
            'total_price',
            'master_vehicle_id',
            'popular_package'
        ];
        $scenarios['inclusion'] = ['package_inclusion', 'package_exclusion', 'package_included'];
        $scenarios['policy_info'] = ['package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy'];
        $scenarios['getting_there'] = ['getting_there'];
        $scenarios['day'] = [
            'package_id',
            'day',
            'meal_lunch',
            'meal_breakfast',
            'meal_dinner',
            'day_status',
            'day_description',
            'day_activity',
            'day_accommodation',
            'day_note',
            'day_title',
            'day_start_location',
            'day_end_location',
            'hotel_name',
            'day_image',
        ];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_name' => 'Package Name',
            'package_slug' => 'Package Slug',
            'no_of_day' => 'Number Of Days',
            'no_of_night' => 'Number Of Nights',
            'no_of_safari' => 'Number Of Safaries',
            'start_location' => 'Tour Start',
            'end_location' => 'Tour End',
            'package_image' => 'Package Image',
            'package_banner_image' => 'Package Banner Image',
            'stay_category_id' => 'Stay Category',
            'cost_per_person' => 'Cost Per Person',
            'package_description' => 'Package Description',
            'package_itinerary_overview' => 'Overview',
            'package_inclusion' => 'Package Inclusion',
            'package_exclusion' => 'Package Exclusion',
            'package_terms_condtition' => 'Package Terms Condtition',

            'type' => 'Type',
            'gst_percentage' => 'GST Percentage',
            'total_price' => 'Total Price',
            'master_vehicle_id' => 'Select Vehicle',
            'popular_package' => 'Popular Package',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->package_model->owned_by_id = $this->owned_by_id;
        $this->package_model->package_name = $this->package_name;
        $this->package_model->no_of_day = $this->no_of_day;
        if ($this->no_of_day) {
            $this->package_model->no_of_night = $this->no_of_day - 1;
        }
        $this->package_model->no_of_safari = $this->no_of_safari;
        $this->package_model->safari_type = $this->safari_type;
        $this->package_model->start_location = $this->start_location;
        $this->package_model->end_location = $this->end_location;
        $this->package_model->start_date = $this->start_date;
        $this->package_model->end_date = $this->end_date;
        $this->package_model->stay_category_id = $this->stay_category_id;
        $this->package_model->cost_per_person = $this->cost_per_person;
        $this->package_model->package_description = $this->package_description;
        $this->package_model->package_itinerary_overview = $this->package_itinerary_overview;
        $this->package_model->package_inclusion = $this->package_inclusion;
        $this->package_model->package_exclusion = $this->package_exclusion;
        $this->package_model->package_terms_condtition = $this->package_terms_condtition;
        $this->package_model->privacy_policy = $this->privacy_policy;
        $this->package_model->change_policy = $this->change_policy;
        $this->package_model->what_you_must_carry = $this->what_you_must_carry;
        $this->package_model->date_change_policy = $this->date_change_policy;
        $this->package_model->refund_policy = $this->refund_policy;
        $this->package_model->getting_there = $this->getting_there;

        $this->package_model->type = $this->type;
        if ($this->type == 1) { // With GST
            $this->package_model->gst_percentage = $this->gst_percentage;
            $gst_amount = (0.01 * $this->gst_percentage) * $this->cost_per_person;
            $this->package_model->total_price = $this->cost_per_person + $gst_amount;
        } else { // Without GST
            $this->package_model->total_price = $this->cost_per_person;
        }

        $this->package_model->status = $this->status;

        // $this->package_model->package_slug = $this->package_slug;
        $this->package_model->master_vehicle_id = $this->master_vehicle_id;
        $this->package_model->popular_package = $this->popular_package;

        // if ($this->package_model->package_slug == '') {
        //     $without_space_string = str_replace(' ', '-', strtolower($this->package_model->safarioperator->business_name));
        //     $package_name = str_replace(' ', '-', strtolower($this->package_model->package_name));
        //     $string = preg_replace('/[^A-Za-z0-9\-]/', '', ($without_space_string . '-' . $package_name));
        //     $slug =  $string . '-' . substr(sha1(mt_rand()), 17, 6) . '-' . $this->package_model->owned_by_id . time() . '-safari-package';
        //     $this->package_model->package_slug = $slug;
        // }
    }

    /**
     * Upload Banner image
     *
     * @return void
     */
    public function UploadFile()
    {
        if ($this->package_image) {
            $storagePath = Yii::$app->params['datapath'] . '/package';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->package_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'package_image' . '-' . time() . '.' . $this->package_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->package_image->saveAs($filePath)) {
                $this->package_model->package_image = $fileName;
                $this->package_model->save(false);
            }
        }


        if ($this->package_banner_image) {
            $storagePath = Yii::$app->params['datapath'] . '/package';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->package_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'package_banner_image' . '-' . time() . '.' . $this->package_banner_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->package_banner_image->saveAs($filePath)) {
                $this->package_model->package_banner_image = $fileName;
                $this->package_model->save(false);
            }
        }
    }
}
