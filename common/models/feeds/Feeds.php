<?php

namespace common\models\feeds;

use Yii;

/**
 * This is the model class for table "feeds".
 *
 * @property int $id
 * @property string $objective
 * @property int $collection
 * @property int $collection_id
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 */
class Feeds extends \yii\db\ActiveRecord
{
    const MODEL_SHARESFARI = 1;
    const MODEL_PACKAGE = 2;
    const MODEL_POSTS = 3;
    const MODEL_SIGHTING = 4;

    const STATUS_ACTIVE = 1;
    const STATUS_SUSPEND = 0;
    const STATUS_DELETE = -1;

    const OBJECTIVE = "feeds";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feeds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['objective', 'collection', 'collection_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'required'],
            [['collection', 'collection_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['objective'], 'string', 'max' => 255],
            [['date_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'objective' => 'Objective',
            'collection' => 'Collection',
            'collection_id' => 'Collection ID',
            'date_time' => 'Date Time',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
