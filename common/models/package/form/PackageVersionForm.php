<?php

namespace common\models\package\form;

use common\models\package\Package;
use Yii;
use common\models\package\PackageVersion;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\partnergallery\PartnerGallery;

class PackageVersionForm extends \yii\base\Model
{
    public $safari_operator_id;
    public $user_id;
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
    public $created_at;
    public $max_booking_date;
    public $cost_per_two_person;
    public $partner_gallery_id;
    public $gallery_json;
    public $gallery_version;
    public $retail_price;

    public $tag_type; // 1=>master tag, 2=>custom tag
    public $master_package_tag_id;
    public $custom_package_tag;
    public $custom_package_tag_color;
    public $custom_activity_message;
    public $custom_price_message;
    public $cost_per_person_strike_off;

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
            $this->safari_operator_id = $this->package_version_model->safari_operator_id;
            $this->user_id = $this->package_version_model->user_id;
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
            $this->cost_per_two_person = $this->package_version_model->cost_per_two_person;
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

            // $this->type = $this->package_version_model->type;
            // $this->gst_percentage = $this->package_version_model->gst_percentage;
            $this->popular_package = $this->package_version_model->popular_package;



            $this->status = $this->package_version_model->status;
            $this->created_at = $this->package_version_model->created_at;
            $this->max_booking_date = $this->package_version_model->max_booking_date;
            $this->partner_gallery_id = $this->package_version_model->partner_gallery_id;

            $this->package_feature = PackageFeature::find()->select('feature_id')->where(['package_id' => $this->package_version_model->package_id, 'version' => $this->package_version_model->version, 'status' => PackageFeature::STATUS_ACTIVE])->column();
            $this->package_included = PackageIncluded::find()->select('include_id', 'selection')->where(['package_id' => $this->package_version_model->package_id, 'version' => $this->package_version_model->version, 'status' => PackageIncluded::STATUS_ACTIVE])->column();
            $this->package_park = PackageSafariPark::find()->select('park_id')->where(['package_id' => $this->package_version_model->package_id, 'version' => $this->package_version_model->version, 'status' => PackageSafariPark::STATUS_ACTIVE])->column();
            $this->retail_price = $this->package_version_model->retail_price;

            $this->tag_type = $this->package_version_model->tag_type;
            $this->master_package_tag_id = $this->package_version_model->master_package_tag_id;
            $this->custom_package_tag = $this->package_version_model->custom_package_tag;
            $this->custom_package_tag_color = $this->package_version_model->custom_package_tag_color;
            $this->custom_activity_message = $this->package_version_model->custom_activity_message;
            $this->custom_price_message = $this->package_version_model->custom_price_message;
            $this->cost_per_person_strike_off = $this->package_version_model->cost_per_person_strike_off;
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
                // 'maxWidth' => 350,
                // 'maxHeight' => 350,
            ],
            [['package_name', 'no_of_day', 'master_vehicle_id', 'cost_per_person', 'safari_type', 'package_agenda_id', 'no_of_safari', 'stay_category_id'], 'required', 'on' => ['create', 'update']],
            [['package_park'], 'required', 'on' => ['create']],
            // [['package_inclusion'], 'required', 'on' => 'inclusion'],
            [['package_exclusion'], 'required', 'on' => 'exclusion'],
            [['no_of_day', 'no_of_night', 'stay_category_id', 'status', 'type', 'gst_percentage', 'master_vehicle_id'], 'integer'],
            [['total_price'], 'number'],
            [['package_itinerary_overview', 'package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry'], 'string'],
            [['package_feature', 'package_included', 'package_park', 'package_image', 'package_banner_image', 'package_agenda_id'], 'safe'],
            // [['package_slug'], 'string', 'max' => 720],
            [['start_location', 'end_location'], 'match', 'pattern' => '/^[a-zA-Z\s-]+$/', 'message' => 'Only letters, spaces, and hyphens are allowed.'],
            [['start_location', 'end_location'], 'string', 'max' => 215],
            [['start_date', 'end_date', 'date_change_policy', 'refund_policy', 'safari_operator_id', 'package_id', 'version', 'safari_type', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'], 'safe'],
            [['breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'], 'default', 'value' => 0],
            [['package_id', 'day', 'meal_lunch', 'meal_breakfast', 'meal_dinner', 'status', 'popular_package'], 'integer'],
            [['day_activity', 'day_accommodation', 'day_note'], 'string'],
            [['hotel_name', 'day_image'], 'string', 'max' => 255],
            [['package_id', 'day'], 'unique', 'targetAttribute' => ['package_id', 'day']],
            ['created_at', 'safe'],
            [['max_booking_date'], 'date', 'format' => 'php:Y-m-d'],
            [['package_name'], 'string', 'max' => 215],
            [['package_inclusion', 'package_exclusion'], 'string', 'max' => 512],
            [['no_of_safari'], 'integer', 'min' => 1, 'max' => 99],
            [['cost_per_person'], 'number', 'min' => 1000, 'max' => 9999999],
            [['cost_per_two_person'], 'number', 'min' => 1000, 'max' => 9999999],
            [['package_description'], 'string', 'max' => 2000],
            [['day_title'], 'string', 'max' => 512],
            [['day_description'], 'string', 'max' => 2000],
            [['getting_there'], 'string', 'max' => 2000],
            [['partner_gallery_id', 'gallery_version', 'user_id'], 'integer'],
            [['gallery_json'], 'safe'],
            [['retail_price'], 'number', 'min' => 1000, 'max' => 9999999],

            [['master_package_tag_id', 'tag_type'], 'integer'],
            [['custom_package_tag_color'], 'string', 'max' => 7],
            [['custom_package_tag'], 'string', 'max' => 255],
            [['tag_type'], 'integer'],
            [['master_package_tag_id'], 'required', 'when' => function ($model) {
                return $model->tag_type == 1;
            }, 'whenClient' => "function (attribute, value) {
                     return $('#packageversionform-tag_type').val() == '1';
            }"],

            [['custom_package_tag', 'custom_package_tag_color'], 'required', 'when' => function ($model) {
                return $model->tag_type == 2;
            }, 'whenClient' => "function (attribute, value) {
            return $('#packageversionform-tag_type').val() == '2';
            }"],

            [
                ['custom_package_tag_color'],
                'match',
                'pattern' => '/^#[0-9A-Fa-f]{6}$/',
                'message' => 'Please enter a valid hex color code (e.g., #FF5733)'
            ],
            [['custom_activity_message', 'custom_price_message'], 'string', 'max' => 255],
            [['cost_per_person_strike_off'], 'number', 'min' => 1000, 'max' => 9999999],

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
            'cost_per_two_person',
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
            'safari_operator_id',
            'type',
            'gst_percentage',
            'total_price',
            'master_vehicle_id',
            'popular_package',
            'breakfast_included',
            'lunch_included',
            'dinner_included',
            'meal_not_included',
            'max_booking_date',
            'partner_gallery_id',
            'gallery_json',
            'gallery_version',
            'retail_price',
            'master_package_tag_id',
            'custom_package_tag',
            'custom_package_tag_color',
            'tag_type',
            'custom_activity_message',
            'custom_price_message',
            'cost_per_person_strike_off',
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
            'cost_per_two_person',
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
            'meal_not_included',
            'max_booking_date',
            'partner_gallery_id',
            'gallery_json',
            'gallery_version',
            'retail_price',
            'master_package_tag_id',
            'custom_package_tag',
            'custom_package_tag_color',
            'tag_type',
            'custom_activity_message',
            'custom_price_message',
            'cost_per_person_strike_off',

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
            'stay_category_id' => 'Stay Category',
            'cost_per_person' => 'Cost Per Person',
            'cost_per_two_person' => 'Cost Per Two Person',
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
            'max_booking_date' => 'Max Booking Date',
            'partner_gallery_id' => 'Gallery Id',
            'gallery_json' => 'Gallery Json',
            'gallery_version' => 'Gallery Version',
            'status' => 'Status',
            'retail_price' => 'Retail Price',

            'tag_type' => 'Tag Type',
            'master_package_tag_id' => 'Master Package Tag ID',
            'custom_package_tag' => 'Custom Package Tag',
            'custom_package_tag_color' => 'Custom Package Tag Color',
            'custom_activity_message' => 'Custom Activity Message',
            'custom_price_message' => 'Custom Price Message',
            'cost_per_person_strike_off' => 'Cost Per Person Strike Off',
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
        $m->safari_operator_id = $this->safari_operator_id;
        $m->user_id = $this->user_id;
        $m->package_slug = Package::generateUnqiueSlug($this->package_name);
        $m->package_agenda_id = $this->package_agenda_id;
        $m->no_of_day = $this->no_of_day;
        if ($this->no_of_day) {
            $m->no_of_night = $this->no_of_day - 1;
        }
        $m->safari_type = $this->safari_type;
        $m->no_of_safari = $this->no_of_safari;
        $m->start_location = $this->start_location;
        $m->end_location = $this->end_location;
        $m->start_date = $this->start_date;
        $m->end_date = $this->end_date;
        $m->stay_category_id = $this->stay_category_id;
        $m->cost_per_person = $this->cost_per_person;
        $m->cost_per_two_person = $this->cost_per_two_person;
        // $m->total_price = (float)$this->retail_price;
        $m->total_price = (float)$this->cost_per_person;
        $m->type = $this->type;
        $m->package_description = $this->package_description;
        $m->package_itinerary_overview = $this->package_itinerary_overview;
        $m->package_inclusion = $this->package_inclusion;
        $m->package_exclusion = $this->package_exclusion;
        $m->package_terms_condtition = $this->package_terms_condtition;
        $m->privacy_policy = $this->privacy_policy;
        $m->change_policy = $this->change_policy;
        $m->what_you_must_carry = $this->what_you_must_carry;
        $m->date_change_policy = $this->date_change_policy;
        $m->refund_policy = $this->refund_policy;
        $m->getting_there = $this->getting_there;
        $m->master_vehicle_id = $this->master_vehicle_id;
        $m->breakfast_included = $this->breakfast_included;
        $m->lunch_included = $this->lunch_included;
        $m->dinner_included = $this->dinner_included;
        $m->meal_not_included = $this->meal_not_included;
        $m->max_booking_date = $this->max_booking_date;
        $m->partner_gallery_id = $this->partner_gallery_id;
        if ($this->partner_gallery_id) {
            $live = PartnerGallery::find()->where(['id' => $this->partner_gallery_id])->limit(1)->one();
            if (!empty($live)) {
                $m->gallery_json = $live->live_images;
                if (!empty($live->version)) {
                    $m->gallery_version = $live->version;
                }
            }
        }
        $m->edit_status = 1;
        $m->pending_status = 0;
        $m->status = 10; //create status
        $m->retail_price = $this->retail_price;
        $m->tag_type = $this->tag_type;
        $m->master_package_tag_id = $this->master_package_tag_id;
        $m->custom_package_tag = $this->custom_package_tag;
        $m->custom_package_tag_color = $this->custom_package_tag_color;
        $m->custom_activity_message = $this->custom_activity_message;
        $m->custom_price_message = $this->custom_price_message;
        $m->cost_per_person_strike_off = $this->cost_per_person_strike_off;
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
        $this->package_version_model->safari_operator_id = $this->safari_operator_id;
        $this->package_version_model->user_id = $this->user_id;
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
        $this->package_version_model->cost_per_two_person = $this->cost_per_two_person;
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
        // $this->package_version_model->total_price = (float)$this->retail_price;
        $this->package_version_model->total_price = (float)$this->cost_per_person;
        $this->package_version_model->status = $this->status;
        $this->package_version_model->master_vehicle_id = $this->master_vehicle_id;
        $this->package_version_model->popular_package = $this->popular_package;
        $this->package_version_model->max_booking_date = $this->max_booking_date ? $this->max_booking_date : date('Y-m-d', strtotime('+1 year'));
        $this->package_version_model->partner_gallery_id = $this->partner_gallery_id;
        if ($this->partner_gallery_id) {
            $live = PartnerGallery::find()->where(['id' => $this->partner_gallery_id])->limit(1)->one();
            if (!empty($live)) {
                $this->package_version_model->gallery_json = $live->live_images;
                if (!empty($live->version)) {
                    $this->package_version_model->gallery_version = $live->version;
                }
            }
        }
        $this->package_version_model->retail_price = $this->retail_price;
        $this->package_version_model->tag_type = $this->tag_type;
        $this->package_version_model->master_package_tag_id = $this->master_package_tag_id;
        $this->package_version_model->custom_package_tag = $this->custom_package_tag;
        $this->package_version_model->custom_package_tag_color = $this->custom_package_tag_color;
        $this->package_version_model->custom_activity_message = $this->custom_activity_message;
        $this->package_version_model->custom_price_message = $this->custom_price_message;
        $this->package_version_model->cost_per_person_strike_off = $this->cost_per_person_strike_off;
        // $this->package_version_model->type = $this->type;
        // if ($this->type == 1) { // With GST
        //     $this->package_version_model->gst_percentage = $this->gst_percentage;
        //     $gst_amount = (float)(0.01 * $this->gst_percentage) * (float)$this->cost_per_person;
        //     $this->package_version_model->total_price = (float)$this->cost_per_person + (float)$gst_amount;
        // } else { // Without GST
        //     $this->package_version_model->total_price = (float)$this->cost_per_person;
        // }

        // if ($this->package_version_model->package_slug == '') {
        //     $without_space_string = str_replace(' ', '-', strtolower($this->package_version_model->safarioperator->business_name));
        //     $package_name = str_replace(' ', '-', strtolower($this->package_version_model->package_name));
        //     $string = preg_replace('/[^A-Za-z0-9\-]/', '', ($without_space_string . '-' . $package_name));
        //     $slug =  $string . '-' . substr(sha1(mt_rand()), 17, 6) . '-' . $this->package_version_model->safari_operator_id . time() . '-safari-package';
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

            $storagePath = 'package' . '/' . date('ym', $this->created_at);
            // $storagePath = $storagePath . '/' . $this->package_id . '/' . $this->version;

            $fileName = $this->version . '_package_image' . '_' . time() . '.' . $this->package_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($fileName) {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->package_image, $filePath, $fileName, true)) {
                    $this->package_version_model->package_image = $filePath;
                    $this->package_version_model->original_image_filename = $this->package_image->name;
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

            $storagePath = 'package' . '/' . date('ym', $this->created_at);
            // $storagePath = $storagePath . '/' . $this->package_id . '/' . $this->version;

            $fileName =  $this->version . '_package_banner_image' . '_' . time() . '.' . $this->package_banner_image->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                // try {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->package_banner_image, $filePath, $fileName, true)) {
                    $this->package_version_model->package_banner_image = $filePath;
                    $this->package_version_model->original_banner_filename = $this->package_banner_image->name;
                    $this->package_version_model->save(false);
                }
            }
        }
    }
}
