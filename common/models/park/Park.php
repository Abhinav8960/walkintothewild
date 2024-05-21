<?php

namespace common\models\park;

use common\traits\CommanRelationship;
use Yii;

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
class Park extends \yii\db\ActiveRecord implements \common\interfaces\StatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'park';
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
            [['master_location_id', 'country_id', 'state_id', 'city_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'slug', 'official_website', 'country_name', 'state_name', 'city_name', 'avg_safari_price', 'nearest_railway_station', 'nearest_airport', 'nearest_bus_station', 'meta_title'], 'string', 'max' => 255],
            [['latitude', 'longitude'], 'string', 'max' => 50],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    // public function getParkvehicle()
    // {
    //     return $this->hasMany(ParkVehicle::className(), ['park_id' => 'id']);
    // }
}
