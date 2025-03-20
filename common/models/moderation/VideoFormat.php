<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_format".
 *
 * @property int $id
 * @property int $moderation_id
 * @property int|null $nb_streams
 * @property int|null $nb_programs
 * @property string|null $format_name
 * @property string|null $format_long_name
 * @property float|null $start_time
 * @property float|null $duration
 * @property int|null $size
 * @property int|null $bit_rate
 * @property int|null $probe_score
 * @property string|null $tags
 */
class VideoFormat extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_format';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nb_streams', 'nb_programs', 'format_name', 'format_long_name', 'start_time', 'duration', 'size', 'bit_rate', 'probe_score', 'tags'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'nb_streams', 'nb_programs', 'size', 'bit_rate', 'probe_score'], 'integer'],
            [['start_time', 'duration'], 'number'],
            [['tags'], 'safe'],
            [['format_name', 'format_long_name'], 'string', 'max' => 255],
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
            'nb_streams' => 'Nb Streams',
            'nb_programs' => 'Nb Programs',
            'format_name' => 'Format Name',
            'format_long_name' => 'Format Long Name',
            'start_time' => 'Start Time',
            'duration' => 'Duration',
            'size' => 'Size',
            'bit_rate' => 'Bit Rate',
            'probe_score' => 'Probe Score',
            'tags' => 'Tags',
        ];
    }

}