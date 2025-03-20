<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_audio_meta_data".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $codec_name
 * @property string|null $codec_long_name
 * @property string|null $profile
 * @property string|null $codec_type
 * @property string|null $codec_tag_string
 * @property string|null $codec_tag
 * @property string|null $sample_fmt
 * @property int|null $sample_rate
 * @property int|null $channels
 * @property float|null $channel_layout
 * @property string|null $bits_per_sample
 * @property string|null $r_frame_rate
 * @property string|null $avg_frame_rate
 * @property string|null $time_base
 * @property int|null $start_pts
 * @property float|null $start_time
 * @property int|null $duration_ts
 * @property float|null $duration
 * @property int|null $bit_rate
 * @property int|null $nb_frames
 * @property string|null $disposition
 * @property string|null $tags
 */
class VideoAudioMetaData extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_audio_meta_data';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codec_name', 'codec_long_name', 'profile', 'codec_type', 'codec_tag_string', 'codec_tag', 'sample_fmt', 'sample_rate', 'channels', 'channel_layout', 'bits_per_sample', 'r_frame_rate', 'avg_frame_rate', 'time_base', 'start_pts', 'start_time', 'duration_ts', 'duration', 'bit_rate', 'nb_frames', 'disposition', 'tags'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'sample_rate', 'channels', 'start_pts', 'duration_ts', 'bit_rate', 'nb_frames'], 'integer'],
            [['channel_layout', 'start_time', 'duration'], 'number'],
            [['disposition', 'tags'], 'safe'],
            [['codec_name', 'codec_long_name', 'profile', 'codec_type', 'codec_tag_string', 'codec_tag', 'sample_fmt', 'bits_per_sample', 'r_frame_rate', 'avg_frame_rate', 'time_base'], 'string', 'max' => 255],
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
            'codec_name' => 'Codec Name',
            'codec_long_name' => 'Codec Long Name',
            'profile' => 'Profile',
            'codec_type' => 'Codec Type',
            'codec_tag_string' => 'Codec Tag String',
            'codec_tag' => 'Codec Tag',
            'sample_fmt' => 'Sample Fmt',
            'sample_rate' => 'Sample Rate',
            'channels' => 'Channels',
            'channel_layout' => 'Channel Layout',
            'bits_per_sample' => 'Bits Per Sample',
            'r_frame_rate' => 'R Frame Rate',
            'avg_frame_rate' => 'Avg Frame Rate',
            'time_base' => 'Time Base',
            'start_pts' => 'Start Pts',
            'start_time' => 'Start Time',
            'duration_ts' => 'Duration Ts',
            'duration' => 'Duration',
            'bit_rate' => 'Bit Rate',
            'nb_frames' => 'Nb Frames',
            'disposition' => 'Disposition',
            'tags' => 'Tags',
        ];
    }

}