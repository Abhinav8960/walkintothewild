<?php

namespace common\models\package\form;

use common\models\package\Package;
use Yii;
use common\models\package\PackageVersion;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;

class PackageVersionForm extends \yii\base\Model
{
    public $owned_by_id;
    public $package_id;
    public $version;
    public $package_name;
    // public $package_slug;
    public $package_agenda_id;

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

    public $breakfast_included;
    public $lunch_included;
    public $dinner_included;
    public $meal_not_included;


    public $type;
    public $gst_percentage;
    public $total_price;
    public $master_vehicle_id;
    public $popular_package;

    public $package_version_model;
    public $action_url;
    public $action_validate_url;



    /**
     * @param [type] $package_version_model
     */
    public function __construct($package_version_model = null)
    {
        $this->package_version_model = Yii::createObject([
            'class' => PackageVersion::className()
        ]);

        $this->version = 'v1';
        if ($package_version_model != null) {
            $this->package_version_model = $package_version_model;
            $this->owned_by_id = $this->package_version_model->owned_by_id;
            $this->package_id = $this->package_version_model->package_id;
            $this->version = $this->package_version_model->version;
            $this->package_name = $this->package_version_model->package_name;
            $this->package_image = $this->package_version_model->package_image;
            $this->package_banner_image = $this->package_version_model->package_banner_image;
            $this->package_agenda_id = $this->package_version_model->package_agenda_id;
            // $this->package_slug = $this->package_version_model->package_slug;
            $this->no_of_day = $this->package_version_model->no_of_day;
            $this->no_of_night = $this->package_version_model->no_of_night;
            $this->no_of_safari = $this->package_version_model->no_of_safari;
            $this->safari_type = $this->package_version_model->safari_type;
            $this->start_location = $this->package_version_model->start_location;
            $this->end_location = $this->package_version_model->end_location;
            $this->start_date = $this->package_version_model->start_date;
            $this->end_date = $this->package_version_model->end_date;
            $this->stay_category_id = $this->package_version_model->stay_category_id;
            $this->cost_per_person = $this->package_version_model->cost_per_person;
            $this->package_description = $this->package_version_model->package_description;
            $this->package_itinerary_overview = $this->package_version_model->package_itinerary_overview;
            $this->package_inclusion = $this->package_version_model->package_inclusion;
            $this->package_exclusion = $this->package_version_model->package_exclusion;
            $this->package_terms_condtition = $this->package_version_model->package_terms_condtition;
            $this->privacy_policy = $this->package_version_model->privacy_policy;
            $this->change_policy = $this->package_version_model->change_policy;
            $this->what_you_must_carry = $this->package_version_model->what_you_must_carry;
            $this->date_change_policy = $this->package_version_model->date_change_policy;
            $this->refund_policy = $this->package_version_model->refund_policy;
            $this->getting_there = $this->package_version_model->getting_there;
            $this->master_vehicle_id = $this->package_version_model->master_vehicle_id;

            $this->breakfast_included = $this->package_version_model->breakfast_included;
            $this->lunch_included = $this->package_version_model->lunch_included;
            $this->dinner_included = $this->package_version_model->dinner_included;
            $this->meal_not_included = $this->package_version_model->meal_not_included;

            $this->type = $this->package_version_model->type;
            $this->gst_percentage = $this->package_version_model->gst_percentage;
            $this->popular_package = $this->package_version_model->popular_package;



            $this->status = $this->package_version_model->status;

            $this->package_feature = PackageFeature::find()->select('feature_id')->where(['package_id' => $this->package_version_model->package_id, 'version'=>$this->package_version_model->version, 'status' => PackageFeature::STATUS_ACTIVE])->column();
            $this->package_included = PackageIncluded::find()->select('include_id', 'selection')->where(['package_id' => $this->package_version_model->package_id, 'version'=>$this->package_version_model->version, 'status' => PackageIncluded::STATUS_ACTIVE])->column();
            $this->package_park = PackageSafariPark::find()->select('park_id')->where(['package_id' => $this->package_version_model->package_id, 'version'=>$this->package_version_model->version, 'status' => PackageSafariPark::STATUS_ACTIVE])->column();
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
            [['package_name', 'no_of_day', 'master_vehicle_id', 'cost_per_person', 'safari_type', 'package_agenda_id'], 'required', 'on' => ['create', 'update']],
            // [['package_inclusion'], 'required', 'on' => 'inclusion'],
            [['package_exclusion'], 'required', 'on' => 'exclusion'],
            [['no_of_day', 'no_of_night', 'no_of_safari', 'stay_category_id', 'status', 'type', 'gst_percentage', 'master_vehicle_id'], 'integer'],
            [['cost_per_person', 'total_price'], 'number'],
            [['package_description', 'package_itinerary_overview', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry'], 'string'],
            [['package_feature', 'package_included', 'package_park', 'package_image', 'package_banner_image', 'getting_there', 'package_agenda_id'], 'safe'],
            [['package_name'], 'string', 'max' => 512],
            // [['package_slug'], 'string', 'max' => 720],
            [['start_location', 'end_location'], 'string', 'max' => 255],
            [['start_date', 'end_date', 'date_change_policy', 'refund_policy', 'owned_by_id', 'package_id', 'version', 'safari_type', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'], 'safe'],

            [['breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'], 'default', 'value' => 0],


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
            'package_agenda_id',
            'start_location',
            'end_location',
            'start_date',
            'end_date',
            'owned_by_id',
            'type',
            'gst_percentage',
            'total_price',
            'master_vehicle_id',
            'popular_package',
            'breakfast_included',
            'lunch_included',
            'dinner_included',
            'meal_not_included'
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
            'package_agenda_id',
            'start_location',
            'end_location',
            'start_date',
            'end_date',
            'type',
            'gst_percentage',
            'total_price',
            'master_vehicle_id',
            'popular_package',
            'breakfast_included',
            'lunch_included',
            'dinner_included',
            'meal_not_included'
        ];
        $scenarios['inclusion'] = ['package_inclusion', 'package_exclusion', 'package_included', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'];
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
            // 'package_slug' => 'Package Slug',
            'no_of_day' => 'Number Of Days',
            'no_of_night' => 'Number Of Nights',
            'no_of_safari' => 'Number Of Safaries',
            'start_location' => 'Tour Start',
            'end_location' => 'Tour End',
            'package_image' => 'Package Image',
            'package_banner_image' => 'Package Banner Image',
            'stay_category_id' => 'Accommodation',
            'cost_per_person' => 'Cost Per Person',
            'package_description' => 'Package Description',
            'package_itinerary_overview' => 'Overview',
            'package_inclusion' => 'Package Inclusion',
            'package_exclusion' => 'Package Exclusion',
            'package_terms_condtition' => 'Package Terms Condtition',
            'package_agenda_id' => 'Theme',

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
    private function getPackageId()
    {
        $m = new Package();
        $m->package_name = $this->package_name;
        $m->owned_by_id = $this->owned_by_id;
        $m->status = 0;
        $m->save(false);
        return $m->id;
    }
    public function initializeForm()
    {
        if ($this->package_id == null) {
            $this->package_id = $this->getPackageId();
        }
        $this->package_version_model->package_id = $this->package_id;
        $this->package_version_model->version = $this->version;
        $this->package_version_model->owned_by_id = $this->owned_by_id;
        $this->package_version_model->package_name = $this->package_name;
        $this->package_version_model->package_agenda_id = $this->package_agenda_id;
        $this->package_version_model->no_of_day = $this->no_of_day;
        if ($this->no_of_day) {
            $this->package_version_model->no_of_night = $this->no_of_day - 1;
        }
        $this->package_version_model->no_of_safari = $this->no_of_safari;
        $this->package_version_model->safari_type = $this->safari_type;
        $this->package_version_model->start_location = $this->start_location;
        $this->package_version_model->end_location = $this->end_location;
        $this->package_version_model->start_date = $this->start_date;
        $this->package_version_model->end_date = $this->end_date;
        $this->package_version_model->stay_category_id = $this->stay_category_id;
        $this->package_version_model->cost_per_person = $this->cost_per_person;
        $this->package_version_model->package_description = $this->package_description;
        $this->package_version_model->package_itinerary_overview = $this->package_itinerary_overview;
        $this->package_version_model->package_inclusion = $this->package_inclusion;
        $this->package_version_model->package_exclusion = $this->package_exclusion;
        $this->package_version_model->package_terms_condtition = $this->package_terms_condtition;
        $this->package_version_model->privacy_policy = $this->privacy_policy;
        $this->package_version_model->change_policy = $this->change_policy;
        $this->package_version_model->what_you_must_carry = $this->what_you_must_carry;
        $this->package_version_model->date_change_policy = $this->date_change_policy;
        $this->package_version_model->refund_policy = $this->refund_policy;
        $this->package_version_model->getting_there = $this->getting_there;

        $this->package_version_model->breakfast_included = $this->breakfast_included;
        $this->package_version_model->lunch_included = $this->lunch_included;
        $this->package_version_model->dinner_included = $this->dinner_included;
        $this->package_version_model->meal_not_included = $this->meal_not_included;

        $this->package_version_model->type = $this->type;
        if ($this->type == 1) { // With GST
            $this->package_version_model->gst_percentage = $this->gst_percentage;
            $gst_amount = (float)(0.01 * $this->gst_percentage) * (float)$this->cost_per_person;
            $this->package_version_model->total_price = (float)$this->cost_per_person + (float)$gst_amount;
        } else { // Without GST
            $this->package_version_model->total_price = (float)$this->cost_per_person;
        }

        $this->package_version_model->status = $this->status;

        // $this->package_version_model->package_slug = $this->package_slug;
        $this->package_version_model->master_vehicle_id = $this->master_vehicle_id;
        $this->package_version_model->popular_package = $this->popular_package;

        // if ($this->package_version_model->package_slug == '') {
        //     $without_space_string = str_replace(' ', '-', strtolower($this->package_version_model->safarioperator->business_name));
        //     $package_name = str_replace(' ', '-', strtolower($this->package_version_model->package_name));
        //     $string = preg_replace('/[^A-Za-z0-9\-]/', '', ($without_space_string . '-' . $package_name));
        //     $slug =  $string . '-' . substr(sha1(mt_rand()), 17, 6) . '-' . $this->package_version_model->owned_by_id . time() . '-safari-package';
        //     $this->package_version_model->package_slug = $slug;
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
            // $storagePath = Yii::$app->params['datapath'] . '/package';

            // if (!file_exists($storagePath)) {
            //     mkdir($storagePath);
            //     chmod($storagePath, 0777);
            // }
            // $storagePath = $storagePath . '/' . $this->package_version_model->id;
            // if (!file_exists($storagePath)) {
            //     mkdir($storagePath);
            //     chmod($storagePath, 0777);
            // }

            // $fileName = 'package_image' . '-' . time() . '.' . $this->package_image->extension;
            // $filePath = $storagePath . '/' . $fileName;

            // if ($this->package_image->saveAs($filePath)) {
            //     $this->package_version_model->package_image = $fileName;
            //     $this->package_version_model->save(false);
            // }
            // _______________________Move to S3 From apr 22, 2025_____________________________________

            $storagePath = 'package';
            $storagePath = $storagePath . '/' . $this->package_version_model->id;

            $fileName = 'package_image' . '-' . time() . '.' . $this->package_image->extension;
            $filePath = $storagePath . '/' . $fileName;
            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $caption = NULL, $this->user_id);

            // file_put_contents(Yii::getAlias('@runtime/logs/custom.log'), $fileName);

            if ($fileName) {
                // try {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->package_image, $filePath, $fileName, true)) {
                    // $this->package_version_model->file = $fileName;
                    $this->package_version_model->package_image = $filePath;
                    // $this->package_version_model->etag = $etag;

                    $this->package_version_model->save(false);
                }
            }
        }


        if ($this->package_banner_image) {
            // $storagePath = Yii::$app->params['datapath'] . '/package';

            // if (!file_exists($storagePath)) {
            //     mkdir($storagePath);
            //     chmod($storagePath, 0777);
            // }
            // $storagePath = $storagePath . '/' . $this->package_version_model->id;
            // if (!file_exists($storagePath)) {
            //     mkdir($storagePath);
            //     chmod($storagePath, 0777);
            // }

            // $fileName = 'package_banner_image' . '-' . time() . '.' . $this->package_banner_image->extension;
            // $filePath = $storagePath . '/' . $fileName;

            // if ($this->package_banner_image->saveAs($filePath)) {
            //     $this->package_version_model->package_banner_image = $fileName;
            //     $this->package_version_model->save(false);
            // }

            // _______________________Move to S3 From apr 22, 2025_____________________________________

            $storagePath = 'package';
            $storagePath = $storagePath . '/' . $this->package_version_model->id;
            $fileName = 'package_banner_image' . '-' . time() . '.' . $this->package_banner_image->extension;
            $filePath = $storagePath . '/' . $fileName;
            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $caption = NULL, $this->user_id);
            // file_put_contents(Yii::getAlias('@runtime/logs/custom.log'), $fileName);
            if ($fileName) {
                // try {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->package_banner_image, $filePath, $fileName, true)) {
                    // $this->package_version_model->file = $fileName;
                    $this->package_version_model->package_banner_image = $filePath;
                    // $this->package_version_model->etag = $etag;
                    $this->package_version_model->save(false);
                }
            }
        }
    }
}
