<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_metadata".
 *
 * @property int $id
 * @property int $moderation_id
 * @property float|null $duration
 * @property int|null $r_frame_rate
 * @property int|null $average_frame_rate
 */
class VideoMetadata extends ActiveRecord
{


    public static function tableName()
    {
        return 'video_metadata';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['size', 'duration', 'r_frame_rate', 'average_frame_rate'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'size', 'r_frame_rate', 'average_frame_rate'], 'integer'],
            [['duration'], 'number'],
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
            'size' => 'Size',
            'duration' => 'Duration',
            'r_frame_rate' => 'R Frame Rate',
            'average_frame_rate' => 'Average Frame Rate',
        ];
    }

}