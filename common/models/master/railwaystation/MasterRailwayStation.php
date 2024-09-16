<?php

namespace common\models\master\railwaystation;

use common\models\master\city\MasterCity;
use common\models\master\country\MasterCountry;
use common\models\master\state\MasterState;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "master_railway_station".
 *
 * @property int $id
 * @property string|null $title
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class MasterRailwayStation extends  \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_railway_station';
    }



    /**
     * {@inheritdoc}
     */
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
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_id','country_id','status'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City',
            'state_id' => 'State',
            'country_id' => 'Country',
            'title' => 'Title',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
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
}
