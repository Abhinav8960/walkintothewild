<?php

namespace common\models\package;

use Yii;
use common\models\User;
use common\models\meta\MetaPackageRange;
use common\models\operator\SafariOperator;
use common\models\master\vehicle\MasterVehicle;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "package".
 *
 * @property int $id
 * @property string $package_name
 * @property string $package_slug
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
class Package extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
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
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'package_name',
                'slugAttribute' => 'package_slug',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_name', 'package_slug'], 'required'],
            [['no_of_day', 'no_of_night', 'no_of_safari', 'stay_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'popular_package'], 'integer'],
            [['cost_per_person'], 'number'],
            [['package_description', 'package_inclusion', 'package_itinerary_overview', 'package_exclusion', 'package_terms_condtition'], 'string'],
            [['package_name'], 'string', 'max' => 512],
            [['package_slug'], 'string', 'max' => 720],
            [['start_location', 'end_location'], 'string', 'max' => 255],
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
            'package_slug' => 'Package Slug',
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
        return $this->hasMany(PackageIncluded::className(), ['package_id' => 'id'])->andWhere(['package_included.status' => 1]);
    }


    public function getPackagefeatures()
    {
        return $this->hasMany(PackageFeature::className(), ['package_id' => 'id'])->andWhere(['package_feature.status' => 1]);
    }


    public function getPackageIncludeds()
    {
        return $this->hasMany(PackageIncluded::class, ['package_id' => 'id']);
    }

    public function getPackagedays()
    {
        return $this->hasMany(PackageDay::class, ['package_id' => 'id']);
    }

    public function getImagepath()
    {
        $image_path = '';
        if (isset($this->package_image)) {
            $image_path = '/storage/package/' . $this->id . '/' . $this->package_image;
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
            $image_path = '/storage/package/' . $this->id . '/' . $this->package_banner_image;
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

    public function getComments()
    {
        return $this->hasMany(PackageComment::class, ['package_id' => 'id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'owned_by_id']);
    }

    public function getSafarioperator()
    {
        return $this->hasOne(SafariOperator::class, ['id' => 'owned_by_id']);
    }

    public function getMastervehicle()
    {
        return $this->hasOne(MasterVehicle::class, ['id' => 'master_vehicle_id']);
    }



    /**
     * Parks List
     */
    public function getSinglepark()
    {
        return $this->hasOne(PackageSafariPark::className(), ['package_id' => 'id']);
    }

    /**
     * Parks List
     */
    public function getPackagepark()
    {
        return $this->hasMany(PackageSafariPark::className(), ['package_id' => 'id']);
    }

    public function getPackagerange()
    {
        return $this->hasOne(MetaPackageRange::class, ['id' => 'stay_category_id']);
    }

    public function getPackagegallery()
    {
        return $this->hasMany(PackageGallery::className(), ['package_id' => 'id']);
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
        $pick_drop_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 3, 'selection' => 1, 'status' => 1])->limit(1)->one();

        return ($pick_drop_includes) ? 'Pick & Drop' : 'N/A';
    }

    public function getMeals()
    {
        $package_includes = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 2, 'selection' => 1, 'status' => 1])->limit(1)->one();

        $meals_text = '';
        if ($package_includes) {
            $meals_text = 'Breakfast,';
        }

        $package_includes_lunch = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 7, 'selection' => 1, 'status' => 1])->limit(1)->one();
        if ($package_includes_lunch) {
            $meals_text .= 'Lunch,';
        }

        $package_includes_dinner = PackageIncluded::find()->where(['package_id' => $this->id, 'include_id' => 8, 'selection' => 1, 'status' => 1])->limit(1)->one();
        if ($package_includes_dinner) {
            $meals_text .= 'Dinner,';
        }

        return ($meals_text) ? substr($meals_text, 0, -1) : 'N/A';
    }
}
