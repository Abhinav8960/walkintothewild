<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "image_faces".
 *
 * @property int $id
 * @property int|null $moderation_id
 * @property string|null $media_id
 * @property float|null $x1
 * @property float|null $y1
 * @property float|null $x2
 * @property float|null $y2
 * @property float|null $feature_left_eye_x
 * @property float|null $feature_left_eye_y
 * @property float|null $feature_right_eye_x
 * @property float|null $feature_right_eye_y
 * @property float|null $feature_nose_tip_x
 * @property float|null $feature_nose_tip_y
 * @property float|null $feature_left_mouth_corner_x
 * @property float|null $feature_left_mouth_corner_y
 * @property float|null $feature_right_mouth_corner_x
 * @property float|null $feature_right_mouth_corner_y
 * @property float|null $minor
 * @property float|null $sunglasses
 */
class ImageFaces extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_faces';
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
            [['moderation_id', 'media_id', 'x1', 'y1', 'x2', 'y2', 'feature_left_eye_x', 'feature_left_eye_y', 'feature_right_eye_x', 'feature_right_eye_y', 'feature_nose_tip_x', 'feature_nose_tip_y', 'feature_left_mouth_corner_x', 'feature_left_mouth_corner_y', 'feature_right_mouth_corner_x', 'feature_right_mouth_corner_y', 'minor', 'sunglasses'], 'default', 'value' => null],
            [['id'], 'required'],
            [['id', 'moderation_id'], 'integer'],
            [['x1', 'y1', 'x2', 'y2', 'feature_left_eye_x', 'feature_left_eye_y', 'feature_right_eye_x', 'feature_right_eye_y', 'feature_nose_tip_x', 'feature_nose_tip_y', 'feature_left_mouth_corner_x', 'feature_left_mouth_corner_y', 'feature_right_mouth_corner_x', 'feature_right_mouth_corner_y', 'minor', 'sunglasses'], 'number'],
            [['media_id'], 'string', 'max' => 255],
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
            'x1' => 'X1',
            'y1' => 'Y1',
            'x2' => 'X2',
            'y2' => 'Y2',
            'feature_left_eye_x' => 'Feature Left Eye X',
            'feature_left_eye_y' => 'Feature Left Eye Y',
            'feature_right_eye_x' => 'Feature Right Eye X',
            'feature_right_eye_y' => 'Feature Right Eye Y',
            'feature_nose_tip_x' => 'Feature Nose Tip X',
            'feature_nose_tip_y' => 'Feature Nose Tip Y',
            'feature_left_mouth_corner_x' => 'Feature Left Mouth Corner X',
            'feature_left_mouth_corner_y' => 'Feature Left Mouth Corner Y',
            'feature_right_mouth_corner_x' => 'Feature Right Mouth Corner X',
            'feature_right_mouth_corner_y' => 'Feature Right Mouth Corner Y',
            'minor' => 'Minor',
            'sunglasses' => 'Sunglasses',
        ];
    }

}
