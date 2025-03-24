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
 * @property string|null $codec_name
 * @property string|null $codec_long_name
 * @property string|null $profile
 * @property string|null $codec_type
 * @property string|null $codec_tag_string
 * @property string|null $codec_tag
 * @property int|null $width
 * @property int|null $height
 * @property int|null $coded_width
 * @property int|null $coded_height
 * @property int|null $closed_captions
 * @property int|null $has_b_frames
 * @property string|null $pix_fmt
 * @property int|null $level
 * @property string|null $chroma_location
 * @property int|null $refs
 * @property int|null $is_avc
 * @property int|null $nal_length_size
 * @property string|null $time_base
 * @property float|null $start_pts
 * @property float|null $start_time
 * @property float|null $duration_ts
 * @property int|null $bit_rate
 * @property int|null $bits_per_raw_sample
 * @property int|null $nb_frames
 * @property string $disposition
 * @property string $tags
 */
class VideoMetadata extends ActiveRecord
{

    public function getMetaAttributes()
    {
       return [
            'Duration' => $this->duration,
            'R Frame Rate' => $this->r_frame_rate,
            'Average Frame Rate' => $this->average_frame_rate,
            'Codec Name' => $this->codec_name,
            'Codec Long Name' => $this->codec_long_name,
            'Profile' => $this->profile,
            'Codec Type' => $this->codec_type,
            'Codec Tag String' => $this->codec_tag_string,
            'Codec Tag' => $this->codec_tag,
            'Width' => $this->width,
            'Height' => $this->height,
            'Coded Width' => $this->coded_width,
            'Coded Height' => $this->coded_height,
            'Closed Captions' => $this->closed_captions,
            'Has B Frames' => $this->has_b_frames,
            'Pix Fmt' => $this->pix_fmt,
            'Level' => $this->level,
            'Chroma Location' => $this->chroma_location,
            'Refs' => $this->refs,
            'Is Avc' => $this->is_avc,
            'Nal Length Size' => $this->nal_length_size,
            'Time Base' => $this->time_base,
            'Start Pts' => $this->start_pts,
            'Start Time' => $this->start_time,
            'Duration Ts' => $this->duration_ts,
            'Bit Rate' => $this->bit_rate,
            'Bits Per Raw Sample' => $this->bits_per_raw_sample,
            'Nb Frames' => $this->nb_frames,
        ];
    } 

    /**
     * {@inheritdoc}
     */
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
            [['duration', 'r_frame_rate', 'average_frame_rate', 'codec_name', 'codec_long_name', 'profile', 'codec_type', 'codec_tag_string', 'codec_tag', 'width', 'height', 'coded_width', 'coded_height', 'closed_captions', 'has_b_frames', 'pix_fmt', 'level', 'chroma_location', 'refs', 'is_avc', 'nal_length_size', 'time_base', 'start_pts', 'start_time', 'duration_ts', 'bit_rate', 'bits_per_raw_sample', 'nb_frames'], 'default', 'value' => null],
            [['moderation_id', 'disposition', 'tags'], 'required'],
            [['moderation_id', 'r_frame_rate', 'average_frame_rate', 'width', 'height', 'coded_width', 'coded_height', 'closed_captions', 'has_b_frames', 'level', 'refs', 'is_avc', 'nal_length_size', 'bit_rate', 'bits_per_raw_sample', 'nb_frames'], 'integer'],
            [['duration', 'start_pts', 'start_time', 'duration_ts'], 'number'],
            [['codec_long_name'], 'string'],
            [['disposition', 'tags'], 'safe'],
            [['codec_name', 'profile', 'codec_type', 'codec_tag_string', 'codec_tag', 'pix_fmt', 'chroma_location', 'time_base'], 'string', 'max' => 512],
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
            'duration' => 'Duration',
            'r_frame_rate' => 'R Frame Rate',
            'average_frame_rate' => 'Average Frame Rate',
            'codec_name' => 'Codec Name',
            'codec_long_name' => 'Codec Long Name',
            'profile' => 'Profile',
            'codec_type' => 'Codec Type',
            'codec_tag_string' => 'Codec Tag String',
            'codec_tag' => 'Codec Tag',
            'width' => 'Width',
            'height' => 'Height',
            'coded_width' => 'Coded Width',
            'coded_height' => 'Coded Height',
            'closed_captions' => 'Closed Captions',
            'has_b_frames' => 'Has B Frames',
            'pix_fmt' => 'Pix Fmt',
            'level' => 'Level',
            'chroma_location' => 'Chroma Location',
            'refs' => 'Refs',
            'is_avc' => 'Is Avc',
            'nal_length_size' => 'Nal Length Size',
            'time_base' => 'Time Base',
            'start_pts' => 'Start Pts',
            'start_time' => 'Start Time',
            'duration_ts' => 'Duration Ts',
            'bit_rate' => 'Bit Rate',
            'bits_per_raw_sample' => 'Bits Per Raw Sample',
            'nb_frames' => 'Nb Frames',
            'disposition' => 'Disposition',
            'tags' => 'Tags',
        ];
    }

}