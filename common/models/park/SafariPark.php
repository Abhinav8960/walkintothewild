<?php

namespace common\models\park;

use Yii;
use common\traits\CommanRelationship;
use common\models\master\city\MasterCity;
use common\models\park\SafariParkAnimal;
use common\models\master\state\MasterState;
use common\models\operator\SafariOperatorPark;
use common\models\master\airport\MasterAirport;
use common\models\master\country\MasterCountry;
use common\models\master\location\MasterLocation;
use common\models\master\railwaystation\MasterRailwayStation;
use common\models\suggestions\SafariSuggestions;
use common\models\UserExperience;

/**
 * This is the model class for table "park".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $short_description
 * @property string|null $long_description
 * @property string $official_website
 * @property int $master_location_id
 * @property int $country_id
 * @property string $country_name
 * @property int $state_id
 * @property string $state_name
 * @property int $city_id
 * @property string $city_name
 * @property string|null $avg_safari_price
 * @property string|null $nearest_railway_station
 * @property string|null $nearest_airport
 * @property string|null $nearest_bus_station
 * @property string $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class SafariPark extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    const OBJECTIVE = "park";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'safari_park';
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
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug', //The attribute to be generated
                'attribute' => 'title', //The attribute from which will be generated
                'maxLength' => 255,
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_description', 'long_description', 'meta_description', 'meta_keywords'], 'string'],
            [['master_location_id', 'country_id', 'state_id', 'city_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'nearest_airport_distance', 'nearest_railway_station_distance'], 'integer'],
            [['title', 'slug', 'official_website', 'country_name', 'state_name', 'city_name', 'avg_safari_price_min', 'avg_safari_price_max', 'nearest_railway_station', 'nearest_airport', 'nearest_bus_station', 'meta_title'], 'string', 'max' => 255],
            [['latitude', 'longitude'], 'string', 'max' => 50],
            [['slug'], 'unique'],
            [['show_in_filter', 'is_published_on_web', 'is_published_on_api'], 'boolean'],
            [['is_published_on_web', 'is_published_on_api'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'show_in_filter' => 'Show in Filter',
            'title' => 'Title',
            'slug' => 'Slug',
            'short_description' => 'Sort Description',
            'long_description' => 'Long Description',
            'official_website' => 'Official Website',
            'master_location_id' => 'Master Location ID',
            'country_id' => 'Country ID',
            'country_name' => 'Country Name',
            'state_id' => 'State ID',
            'state_name' => 'State Name',
            'city_id' => 'City ID',
            'city_name' => 'City Name',
            'avg_safari_price_min' => 'Avg Safari Price',
            'nearest_railway_station' => 'Nearest Railway Station',
            'nearest_railway_station_distance' => 'Nearest Railway Station Distance',
            'nearest_airport' => 'Nearest Airport',
            'nearest_airport_distance' => 'Nearest Airport Distance',
            'nearest_bus_station' => 'Nearest Bus Station',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'is_published_on_web' => 'Is Published On web',
            'is_published_on_api' => 'Is Published On Api',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public function getCity()
    {
        return $this->hasOne(MasterCity::className(), ['id' => 'city_id']);
    }
    public function getState()
    {
        return $this->hasOne(MasterState::className(), ['id' => 'state_id']);
    }
    public function getCountry()
    {
        return $this->hasOne(MasterCountry::className(), ['id' => 'country_id']);
    }

    public function getLocation()
    {
        return $this->hasOne(MasterLocation::className(), ['id' => 'master_location_id']);
    }
    public function getAirport()
    {
        return $this->hasOne(MasterAirport::className(), ['id' => 'nearest_airport']);
    }

    public function getAirportdata($column_key = 'nearest_airport')
    {
        return $this->hasOne(MasterAirport::className(), ['id' => $column_key]);
    }


    public function getAirportlist()
    {
        $text = '';
        $first = $this->airportdata;
        $second = $this->getAirportdata('nearest_airport_two')->one();
        $third = $this->getAirportdata('nearest_airport_three')->one();
        $fourth = $this->getAirportdata('nearest_airport_four')->one();
        $fifth = $this->getAirportdata('nearest_airport_five')->one();

        if ($first) {
            if ($city = $first->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $first->name . $city_name . ', ';
        }

        if ($second) {
            if ($city = $second->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $second->name . $city_name . ', ';
        }

        if ($third) {
            if ($city = $third->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $third->name . $city_name . ', ';
        }

        if ($fourth) {
            if ($city = $fourth->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $fourth->name . $city_name . ', ';
        }

        if ($fifth) {
            if ($city = $fifth->city) {
                $city_name = ' (' . $city->city_name . ')';
            } else {
                $city_name = '';
            }
            $text .= $fifth->name . $city_name . ', ';
        }
        return substr($text, 0, -2);
    }


    public function getRailwaystation()
    {
        return $this->hasOne(MasterRailwayStation::className(), ['id' => 'nearest_railway_station']);
    }

    public function getRailwaystationtwo()
    {
        return $this->hasOne(MasterRailwayStation::className(), ['id' => 'nearest_railway_station_two']);
    }

    public function getRailwaystationdata($column_key = 'nearest_railway_station')
    {
        return $this->hasOne(MasterRailwayStation::className(), ['id' => $column_key]);
    }


    public function getRailwaystationlist()
    {
        $text = '';
        $first = $this->railwaystationdata;
        $second = $this->getRailwaystationdata('nearest_railway_station_two')->one();
        $third = $this->getRailwaystationdata('nearest_railway_station_three')->one();
        $fourth = $this->getRailwaystationdata('nearest_railway_station_four')->one();
        $fifth = $this->getRailwaystationdata('nearest_railway_station_five')->one();

        if ($first) {
            $text .= $first->title . ', ';
        }

        if ($second) {
            $text .= $second->title . ', ';
        }

        if ($third) {
            $text .= $third->title . ', ';
        }

        if ($fourth) {
            $text .= $fourth->title . ', ';
        }

        if ($fifth) {
            $text .= $fifth->title . ', ';
        }
        return substr($text, 0, -2);
    }


    public function getGallery()
    {
        return $this->hasMany(SafariParkGallery::className(), ['safari_park_id' => 'id'])->andWhere(['status' => 1]);
    }


    public function getSafarioperatorlist()
    {
        return $this->hasMany(SafariOperatorPark::className(), ['park_id' => 'id'])->andWhere(['safari_operator_park.status' => 1]);
    }

    public function getGalleryimag()
    {
        return $this->hasOne(SafariParkGallery::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_gallery.status' => 1]);
    }
    public function getAnimals()
    {
        return $this->hasMany(SafariParkAnimal::className(), ['safari_park_id' => 'id'])->andWhere(['safari_parks_animal.status' => 1]);
    }


    public function getRareanimals()
    {
        return $this->hasMany(SafariParkAnimal::className(), ['safari_park_id' => 'id'])->andWhere(['safari_parks_animal.status' => 1]);
    }

    public function getSessions()
    {
        return $this->hasMany(SafariParkSession::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_session.status' => 1]);
    }


    public function getVehicles()
    {
        return $this->hasMany(SafariParkVehicle::className(), ['safari_park_id' => 'id'])->andWhere(['safari_parks_vehicle.status' => 1]);
    }



    public function getBufferzones()
    {
        return $this->hasMany(SafariParkZone::className(), ['safari_park_id' => 'id'])->andWhere(['master_zone_type_id' => 2, 'safari_park_zone.status' => 1]);
    }

    public function getCorezones()
    {
        return $this->hasMany(SafariParkZone::className(), ['safari_park_id' => 'id'])->andWhere(['master_zone_type_id' => 1, 'safari_park_zone.status' => 1]);
    }


    public function getMonths()
    {
        return $this->hasMany(SafariParkMonth::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_month.status' => 1]);
    }


    public function getAccomodations()
    {
        return $this->hasMany(SafariParkAccomodation::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_accomodation.status' => 1]);
    }

    public function getSuggestions()
    {
        return $this->hasMany(SafariSuggestions::className(), ['park_id' => 'id'])->andWhere(['safari_suggestions.status' => 1]);
    }


    public function getBonusexperience()
    {
        return $this->hasMany(SafariParkBonusExperience::className(), ['safari_park_id' => 'id'])->andWhere(['safari_park_bonus_experience.status' => 1]);
    }

    public function getFeatureimagepath()
    {
        if ($this->feature_image != '') {
            return \Yii::$app->params['s3_endpoint'] . '/safaripark/' . $this->id . '/' . $this->feature_image;
        }
    }

    public function getLogoimagepath()
    {
        if ($this->logo != '') {
            return \Yii::$app->params['s3_endpoint'] . '/safaripark/' . $this->id . '/' . $this->logo;
        }
    }
}
