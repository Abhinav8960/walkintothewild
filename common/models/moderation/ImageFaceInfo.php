<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_face_info".
 *
 * @property int $id
 * @property int $video_face_id
 * @property int $moderation_id
 * @property float|null $x1
 * @property float|null $y1
 * @property float|null $x2
 * @property float|null $y2
 * @property float|null $left_eye_x
 * @property float|null $left_eye_y
 * @property float|null $right_eye_x
 * @property float|null $right_eye_y
 * @property float|null $nose_tip_x
 * @property float|null $nose_tip_y
 * @property float|null $left_mouth_corner_x
 * @property float|null $left_mouth_corner_y
 * @property float|null $right_mouth_corner_x
 * @property float|null $right_mouth_corner_y
 * @property float|null $minor
 * @property float|null $sunglasses
 */
class ImageFaceInfo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_face_info';
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
            [['x1', 'y1', 'x2', 'y2', 'left_eye_x', 'left_eye_y', 'right_eye_x', 'right_eye_y', 'nose_tip_x', 'nose_tip_y', 'left_mouth_corner_x', 'left_mouth_corner_y', 'right_mouth_corner_x', 'right_mouth_corner_y', 'minor', 'sunglasses'], 'default', 'value' => null],
            [['video_face_id'], 'required'],
            [['video_face_id', 'moderation_id'], 'integer'],
            [['x1', 'y1', 'x2', 'y2', 'left_eye_x', 'left_eye_y', 'right_eye_x', 'right_eye_y', 'nose_tip_x', 'nose_tip_y', 'left_mouth_corner_x', 'left_mouth_corner_y', 'right_mouth_corner_x', 'right_mouth_corner_y', 'minor', 'sunglasses'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_face_id' => 'Video Face ID',
            'moderation_id' => 'Moderation ID',
            'x1' => 'X1',
            'y1' => 'Y1',
            'x2' => 'X2',
            'y2' => 'Y2',
            'left_eye_x' => 'Left Eye X',
            'left_eye_y' => 'Left Eye Y',
            'right_eye_x' => 'Right Eye X',
            'right_eye_y' => 'Right Eye Y',
            'nose_tip_x' => 'Nose Tip X',
            'nose_tip_y' => 'Nose Tip Y',
            'left_mouth_corner_x' => 'Left Mouth Corner X',
            'left_mouth_corner_y' => 'Left Mouth Corner Y',
            'right_mouth_corner_x' => 'Right Mouth Corner X',
            'right_mouth_corner_y' => 'Right Mouth Corner Y',
            'minor' => 'Minor',
            'sunglasses' => 'Sunglasses',
        ];
    }
}
