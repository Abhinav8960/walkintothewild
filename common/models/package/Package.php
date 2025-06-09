<?php

namespace common\models\package;

use common\models\feeds\Feeds;
use Yii;
use common\models\User;
use common\models\meta\MetaPackageRange;
use common\models\operator\SafariOperator;
use common\models\master\vehicle\MasterVehicle;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "package".
 *
 * @property int $id
 * @property string $package_name
 * @property int $no_of_day
 * @property int|null $no_of_night
 * @property int|null $no_of_safari
 * @property int|null $start_location
 * @property int|null $end_location
 * @property string|null $package_image
 * @property int|null $stay_category_id
 * @property float|null $cost_per_person
 * @property string|null $package_description
 * @property string|null $package_inclusion
 * @property string|null $package_exclusion
 * @property string|null $package_terms_condtition
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class Package extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{



    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'package';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \common\behaviors\FeedsBehavior::class,
                'objective' => 'package',
                'collection' => Feeds::MODEL_PACKAGE,

            ],         
            // [
            //     'class' => SluggableBehavior::className(),
            //     'attribute' => 'package_slug',
            //     'ensureUnique' => true,
            //     'slugAttribute' => 'package_name',
            //     'immutable' => true,
            // ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
            
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // return [
        //     [['package_name'], 'required'],
        //     [['no_of_day', 'no_of_night', 'no_of_safari', 'stay_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'popular_package','owned_by_id','package_agenda_id','safari_type'], 'integer'],
        //     [['cost_per_person'], 'number'],
        //     [['package_description', 'package_inclusion', 'package_itinerary_overview', 'package_exclusion', 'package_terms_condtition', 'uuid', 'version', 'cancellation_reason'], 'string'],
        //     [['package_name'], 'string', 'max' => 512],
        //     [['start_location', 'end_location'], 'string', 'max' => 255],
        //     [['version'], 'string', 'max' => 10],
        //     [['is_published_on_web', 'is_published_on_api'], 'boolean'],
        //     [['is_published_on_web', 'is_published_on_api', 'version', 'version'], 'safe'],
        //     ['cancellation_reason', 'required', 'on' => 'reject'],



        // ];

        return [
            [['owned_by_id', 'package_agenda_id', 'safari_type', 'start_location', 'end_location', 'start_date', 'end_date', 'package_image', 'package_banner_image', 'stay_category_id', 'type', 'gst_percentage', 'package_description', 'package_itinerary_overview', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy', 'getting_there', 'master_vehicle_id', 'cancellation_reason', 'popular_package', 'delete_reason_id', 'delete_reason', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['total_view'], 'default', 'value' => 0],
            [['total_price'], 'default', 'value' => 0.00],
            [['is_published_on_api'], 'default', 'value' => 1],
            // [['status'], 'default', 'value' => 3],
            [[ 'package_name'], 'required'],
            [['owned_by_id', 'package_agenda_id', 'no_of_day', 'no_of_night', 'safari_type', 'no_of_safari', 'stay_category_id', 'type', 'gst_percentage', 'master_vehicle_id', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included', 'popular_package', 'delete_reason_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_published_on_web', 'is_published_on_api', 'status', 'total_view'], 'integer'],
            [['start_date', 'end_date', 'status','package_slug','max_booking_date'], 'safe'],
            [['live_version', 'pending_for_approval_version', 'editable_version'], 'safe'],
            [['cost_per_person', 'total_price'], 'number'],
            [['package_description', 'package_itinerary_overview', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy', 'getting_there', 'cancellation_reason', 'delete_reason'], 'string'],
            [[ 'start_location', 'end_location', 'package_image', 'package_banner_image'], 'string', 'max' => 255],
            [['package_name'], 'string', 'max' => 512],
            ['cancellation_reason', 'required', 'on' => 'reject'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'package_name' => 'Package Name',
            'no_of_day' => 'No Of Day',
            'no_of_night' => 'No Of Night',
            'no_of_safari' => 'No Of Safari',
            'start_location' => 'Start Location',
            'end_location' => 'End Location',
            'package_image' => 'Package Image',
            'stay_category_id' => 'Stay Category ID',
            'cost_per_person' => 'Cost Per Person',
            'package_description' => 'Package Description',
            'package_itinerary_overview' => 'Overview',
            'package_inclusion' => 'Package Inclusion',
            'package_exclusion' => 'Package Exclusion',
            'package_terms_condtition' => 'Package Terms Condtition',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_published_on_api' => 'Is Published On Api',
            'is_published_on_web' => 'Is Published On Web',
            'status' => 'Status',
        ];
    }


    public function getPackagename()
    {

        $name = $this->package_name;

        if ($singlepark = $this->singlepark) {
            if ($park = $singlepark->park) {
                $title_sub = explode(" ", $park->title);
                if (isset($title_sub[0])) {
                    $name .= " - " . $title_sub[0];
                }
            }
        }

        return $name;
    }

    public function getPackageincluded()
    {
        return $this->hasMany(PackageIncluded::className(), ['package_id' => 'id', 'version'=> 'live_version'])->andWhere([PackageIncluded::tableName() . '.status' => PackageIncluded::STATUS_ACTIVE]);
    }



    public function getPackagefeatures()
    {
        return $this->hasMany(PackageFeature::className(), ['package_id' => 'id', 'version'=> 'live_version'])->andWhere([PackageFeature::tableName() . '.status' => PackageFeature::STATUS_ACTIVE]);
    }


    public function getPackageIncludeds()
    {
        return $this->hasMany(PackageIncluded::class, ['package_id' => 'id', 'version'=> 'live_version']);
    }

    public function getPackagedays()
    {
        return $this->hasMany(PackageDay::class, ['package_id' => 'id', 'version'=> 'live_version']);
    }

    public function getImagepath()
    {
        $image_path = '';
        if (isset($this->package_image)) {
            // $image_path = \Yii::$app->params['endpoint'] . '/package/' . $this->id . '/' . $this->package_image;
            $image_path = \Yii::$app->params['s3_endpoint'] . '/' . $this->package_image;
        } else {

            if (isset($this->singlepark)) {
                if (isset($this->singlepark->park) && isset($this->singlepark->park->logo)) {
                    $image_path = $this->singlepark->park->logoimagepath;
                } else {
                    $image_path = '';
                }
            } else {
                $image_path = '';
            }
        }

        return $image_path;
    }


    public function getImagebannerpath()
    {
        $image_path = '';
        if (isset($this->package_banner_image)) {
            // $image_path = \Yii::$app->params['endpoint'] . '/package/' . $this->id . '/' . $this->package_banner_image;
            $image_path = \Yii::$app->params['s3_endpoint'] . '/' . $this->package_banner_image;
        } else {

            if (isset($this->singlepark)) {
                if (isset($this->singlepark->park) && isset($this->singlepark->park->logo)) {
                    $image_path = $this->singlepark->park->logoimagepath;
                }
            }
        }

        return $image_path;
    }

    public function getComments()
    {
        return $this->hasMany(PackageComment::class, ['package_id' => 'id']);
    }


    public function getUser()
    {
        return $this->safarioperator ? $this->safarioperator->user : null;
        // return $this->hasOne(User::className(), ['id' => 'owned_by_id']);
    }

    public function getSafarioperator()
    {
        return $this->hasOne(SafariOperator::class, ['id' => 'owned_by_id']);
    }

    public function getMastervehicle()
    {
        return $this->hasOne(MasterVehicle::class, ['id' => 'master_vehicle_id']);
    }


    public function getPickdrop()
    {
        $package_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'version' => $this->live_version, 'include_id' => 3, 'selection' => 1, 'status' => PackageIncluded::STATUS_ACTIVE])->limit(1)->one();
        return ($package_includes) ? 'Included' : 'Not Included';
    }


    /**
     * Parks List
     */
    public function getSinglepark()
    {
        return $this->hasOne(PackageSafariPark::className(), ['package_id' => 'id', 'version' => 'live_version']);
    }

    /**
     * Parks List
     */
    public function getPackagepark()
    {
        return $this->hasMany(PackageSafariPark::className(), ['package_id' => 'id', 'version' => 'live_version']);
    }

    public function getPackagerange()
    {
        return $this->hasOne(MetaPackageRange::class, ['id' => 'stay_category_id']);
    }

    public function getPackagegallery()
    {
        return $this->hasMany(PackageGallery::className(), ['package_id' => 'id', 'version' => 'live_version']);
    }

    public function getPackagedaynightlabels()
    {
        $options = [
            1 => '0N/1D',
            2 => '1N/2D',
            3 => '2N/3D',
            4 => '3N/4D',
            5 => '4N/5D',
            6 => '5N/6D',
            7 => '6N/7D',
            8 => '7N/8D',
            9 => '8N/9D',
            10 => '9N/10D',
            11 => '10N/11D',
            12 => '11N/12D',
            13 => '12N/13D',
            14 => '13N/14D',
            15 => '14N/15D',
        ];

        return isset($options[$this->no_of_day]) ? $options[$this->no_of_day] : "";
    }


    public function getPickanddrop()
    {
        $pick_drop_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'version' => $this->live_version, 'include_id' => 3, 'selection' => 1, 'status' => PackageIncluded::STATUS_ACTIVE])->limit(1)->one();

        return ($pick_drop_includes) ? 'Included' : 'Not Included';
    }

    // public function getMeals()
    // {
    //     $package_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 2, 'selection' => 1, 'status' => 1])->limit(1)->one();

    //     $meals_text = '';
    //     if ($package_includes) {
    //         $meals_text = 'Breakfast, ';
    //     }

    //     $package_includes_lunch = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 7, 'selection' => 1, 'status' => 1])->limit(1)->one();
    //     if ($package_includes_lunch) {
    //         $meals_text .= 'Lunch, ';
    //     }

    //     $package_includes_dinner = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 8, 'selection' => 1, 'status' => 1])->limit(1)->one();
    //     if ($package_includes_dinner) {
    //         $meals_text .= 'Dinner, ';
    //     }

    //     return ($meals_text) ? substr($meals_text, 0, -2) : 'Not Included';
    // }


    public function getMeals()
    {

        $meals_text = '';
        if ($this->breakfast_included == 1 || $this->lunch_included == 1 || $this->dinner_included == 1) {
            $meals_text = 'Included';
        }



        return ($meals_text) ? $meals_text : 'Not Included';
    }

    public function getMealslisting()
    {
        if ($this->breakfast_included == 1 || $this->lunch_included == 1 || $this->dinner_included == 1) {
            return 'Included';
        }


        return 'Not Included';
    }

    public function getMealslabel()
    {
        $mealOptions = [];


        if ($this->breakfast_included == 1) {
            $mealOptions[] = 'Breakfast';
        }
        if ($this->lunch_included == 1) {
            $mealOptions[] = 'Lunch';
        }
        if ($this->dinner_included == 1) {
            $mealOptions[] = 'Dinner';
        }
        if ($this->meal_not_included == 1) {
            $mealOptions[] = 'Not Included';
        }

        return $mealOptions ? implode(', ', $mealOptions) : 'Not Included';
    }

    public function getAccomodationIncludes()
    {
        $accomodation_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'version' => $this->live_version,  'include_id' => 1, 'selection' => 1, 'status' => PackageIncluded::STATUS_ACTIVE])->limit(1)->one();

        return ($accomodation_includes) ? 'Included' : 'Not Included';
    }



    public function getVersions()
    {
        return $this->hasMany(PackageVersion::className(), ['package_id' => 'id']);
    }

    public static function generateUnqiueSlug($package_name)
    {
        $slug = \yii\helpers\Inflector::slug($package_name);
        $count = 0;
        while (self::find()->where(['package_slug' => $slug])->exists()) {
            $count++;
            $slug = \yii\helpers\Inflector::slug($package_name) . '-' . $count;
        }
        return $slug;
    }

}
