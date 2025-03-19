<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_audio_profanity".
 *
 * @property int $id
 * @property int $moderation_id
 * @property int $video_audio_id
 * @property string|null $type
 * @property string|null $match
 * @property float|null $start_ms
 * @property float|null $end_ms
 */
class VideoAudioProfanity extends ActiveRecord
{

    public static $accessible_attributes = ['type', 'match', 'start_ms', 'end_ms'];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_audio_profanity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'match', 'start_ms', 'end_ms'], 'default', 'value' => null],
            [['moderation_id', 'video_audio_id'], 'required'],
            [['moderation_id', 'video_audio_id'], 'integer'],
            [['start_ms', 'end_ms'], 'number'],
            [['type', 'match'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moderation_id' => 'Moderation ID',
            'video_audio_id' => 'Video Audio ID',
            'type' => 'Type',
            'match' => 'Match',
            'start_ms' => 'Start Ms',
            'end_ms' => 'End Ms',
        ];
    }

}