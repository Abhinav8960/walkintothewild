<?php

namespace common\models\trackings;

use Yii;

/**
 * This is the model class for table "footprints".
 *
 * @property int $id
 * @property string $objective
 * @property string|null $action
 * @property int $collection
 * @property int $collection_id
 * @property string $date_time
 * @property string|null $device
 * @property string|null $platform
 * @property string|null $platform_version
 * @property string|null $browser
 * @property string|null $browser_version
 * @property string|null $application_version
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Footprints extends \yii\db\ActiveRecord
{

    const MODEL_SHARESFARI = 1;
    const MODEL_PACKAGE = 2;
    const MODEL_POSTS = 3;
    const MODEL_SIGHTING = 4;
    const MODEL_USER_DELETE_REQUEST = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'footprints';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action', 'device', 'platform', 'platform_version', 'browser', 'browser_version', 'application_version', 'created_at', 'updated_at', 'created_by', 'updated_by', 'absolute_url'], 'default', 'value' => null],
            [['objective', 'collection', 'collection_id', 'date_time'], 'required'],
            [['collection', 'collection_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['date_time'], 'safe'],
            [['objective', 'action', 'device', 'platform', 'platform_version', 'browser', 'browser_version', 'application_version'], 'string', 'max' => 255],
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
            'action' => 'Action',
            'collection' => 'Collection',
            'collection_id' => 'Collection ID',
            'date_time' => 'Date Time',
            'device' => 'Device',
            'platform' => 'Platform',
            'platform_version' => 'Platform Version',
            'browser' => 'Browser',
            'browser_version' => 'Browser Version',
            'application_version' => 'Application Version',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
