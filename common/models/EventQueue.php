<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event_queue".
 *
 * @property int $id
 * @property string $event_type
 * @property string $event_data
 * @property string|null $created_at
 * @property string|null $processed_at
 */
class EventQueue extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['processed_at'], 'default', 'value' => null],
            [['event_type', 'event_data'], 'required'],
            [['event_data'], 'string'],
            [['created_at', 'processed_at'], 'safe'],
            [['event_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_type' => 'Event Type',
            'event_data' => 'Event Data',
            'created_at' => 'Created At',
            'processed_at' => 'Processed At',
        ];
    }

}