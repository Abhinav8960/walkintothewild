<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_audio".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 */
class VideoAudio extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_audio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
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
        ];
    }

    public static function audiostore($fb, $id)
    {
        if (!isset($fb['data']) || !is_array($fb['data'])) {
            return false;
        }


        $model = new self();
        $model->moderation_id = $id;
        if (!$model->save()) {
            return false;
        }

        if (isset($fb['data']['audio']['profanity']) && is_array($fb['data']['audio']['profanity'])) {
            foreach ($fb['data']['audio']['profanity'] as $profanity) {
                $profanity_model = new VideoAudioProfanity();
                $profanity_model->moderation_id = $id;
                $profanity_model->video_audio_id = $model->id;
                $profanity_model->type = $profanity['type'] ?? null;
                $profanity_model->profanity_match = $profanity['match'] ?? null;
                $profanity_model->start_ms = $profanity['start_ms'] ?? 0;
                $profanity_model->end_ms = $profanity['end_ms'] ?? 0;
                if (!$profanity_model->save()) {
                    return false;
                }
            }
        }


        return true;
    }
}
