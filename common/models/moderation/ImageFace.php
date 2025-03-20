<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_face".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
 */
class ImageFace extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_face';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_moderation');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media_id'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['media_id'], 'string', 'max' => 512],
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
            'media_id' => 'Media ID',
        ];
    }

    public static function facestore($feedback, $moderationId)
    {
        if (!isset($feedback['faces']) || !is_array($feedback['faces'])) {
            return false;
        }

        foreach ($feedback['faces'] as $face) {
            $model = new self();
            $model->moderation_id = $moderationId;
            $model->media_id = $feedback['media']['id'] ?? null; 

            if (!$model->save(false)) {
                return false;
            }

            $video_face_info_model = new ImageFaceInfo();
            $video_face_info_model->moderation_id = $moderationId;
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
            $video_face_info_model->minor = $face['attributes']['minor'] ?? 0;
            $video_face_info_model->sunglasses = $face['attributes']['sunglasses'] ?? 0;

            if (!$video_face_info_model->save(false)) {
                return false;
            }
        }

        return true;
    }
}
