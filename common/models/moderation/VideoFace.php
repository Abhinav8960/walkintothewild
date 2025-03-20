<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "video_face".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 */
class VideoFace extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_face';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['info_id'], 'string', 'max' => 512],
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
            'info_id' => 'Info ID',
            'info_position' => 'Info Position',
        ];
    }

    public static function facestore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            if (!$model->save()) {
                return false;
            }

            if (isset($frame['faces']) && is_array($frame['faces'])) {
                foreach ($frame['faces'] as $face) {
                    $video_face_info_model = new VideoFaceInfo();
                    $video_face_info_model->moderation_id = $id;
                    $video_face_info_model->video_face_id = $model->id;
                    $video_face_info_model->x1 = $face['x1'] ?? 0;
                    $video_face_info_model->y1 = $face['y1'] ?? 0;
                    $video_face_info_model->x2 = $face['x2'] ?? 0;
                    $video_face_info_model->y2 = $face['y2'] ?? 0;
                    $video_face_info_model->left_eye_x = $face['features']['left_eye']['x'] ?? 0;
                    $video_face_info_model->left_eye_y = $face['features']['left_eye']['y'] ?? 0;
                    $video_face_info_model->right_eye_x = $face['features']['right_eye']['x'] ?? 0;
                    $video_face_info_model->right_eye_y = $face['features']['right_eye']['y'] ?? 0;
                    $video_face_info_model->nose_tip_x = $face['features']['nose_tip']['x'] ?? 0;
                    $video_face_info_model->nose_tip_y = $face['features']['nose_tip']['y'] ?? 0;
                    $video_face_info_model->left_mouth_corner_x = $face['features']['left_mouth_corner']['x'] ?? 0;
                    $video_face_info_model->left_mouth_corner_y = $face['features']['left_mouth_corner']['y'] ?? 0;
                    $video_face_info_model->right_mouth_corner_x = $face['features']['right_mouth_corner']['x'] ?? 0;
                    $video_face_info_model->right_mouth_corner_y = $face['features']['right_mouth_corner']['y'] ?? 0;
                    $video_face_info_model->sunglasses = $face['attributes']['glasses']['sunglasses'] ?? 0;
                    $video_face_info_model->no_sunglasses = $face['attributes']['glasses']['no_sunglasses'] ?? 0;
                    $video_face_info_model->angle_back_side = $face['attributes']['angle']['back']['side'] ?? 0;
                    $video_face_info_model->angle_back_straight = $face['attributes']['angle']['back']['straight'] ?? 0;
                    $video_face_info_model->filter_false =  $face['attributes']['filter']['false'] ?? 0;
                    $video_face_info_model->filter_true =  $face['attributes']['filter']['true'] ?? 0;
                    $video_face_info_model->obstruction_complete = $face['attributes']['obstruction']['complete'] ?? 0;
                    $video_face_info_model->obstruction_extreme = $face['attributes']['obstruction']['extreme'] ?? 0;
                    $video_face_info_model->obstruction_heavy = $face['attributes']['obstruction']['heavy'] ?? 0;
                    $video_face_info_model->obstruction_light = $face['attributes']['obstruction']['light'] ?? 0;
                    $video_face_info_model->obstruction_medium = $face['attributes']['obstruction']['medium'] ?? 0;
                    $video_face_info_model->obstruction_none = $face['attributes']['obstruction']['none'] ?? 0;
                    $video_face_info_model->quality_high = $face['attributes']['quality']['high'] ?? 0;
                    $video_face_info_model->quality_low = $face['attributes']['quality']['low'] ?? 0;
                    $video_face_info_model->quality_medium = $face['attributes']['quality']['medium'] ?? 0;
                    $video_face_info_model->quality_perfect = $face['attributes']['quality']['perfect'] ?? 0;
                    $video_face_info_model->attributes_minor = $face['attributes']['attributes']['minor'] ?? 0;
                    $video_face_info_model->attributes_sunglasses = $face['attributes']['attributes']['sunglasses'] ?? 0;
                    if (!$video_face_info_model->save()) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
