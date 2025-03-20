<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "video_face_info".
 *
 * @property int $id
 * @property int $moderation_id
 * @property int $video_face_id
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
 * @property float|null $sunglasses
 * @property float|null $no_sunglasses
 * @property float|null $angle_back_side
 * @property float|null $angle_back_straight
 * @property float|null $filter_false
 * @property float|null $filter_true
 * @property float|null $obstruction_complete
 * @property float|null $obstruction_extreme
 * @property float|null $obstruction_heavy
 * @property float|null $obstruction_light
 * @property float|null $obstruction_medium
 * @property float|null $obstruction_none
 * @property float|null $quality_high
 * @property float|null $quality_low
 * @property float|null $quality_medium
 * @property float|null $quality_perfect
 * @property float|null $attributes_minor
 * @property float|null $attributes_sunglasses
 */
class VideoFaceInfo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_face_info';
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
            [['x1', 'y1', 'x2', 'y2', 'left_eye_x', 'left_eye_y', 'right_eye_x', 'right_eye_y', 'nose_tip_x', 'nose_tip_y', 'left_mouth_corner_x', 'left_mouth_corner_y', 'right_mouth_corner_x', 'right_mouth_corner_y', 'sunglasses', 'no_sunglasses', 'angle_back_side', 'angle_back_straight', 'filter_false', 'filter_true', 'obstruction_complete', 'obstruction_extreme', 'obstruction_heavy', 'obstruction_light', 'obstruction_medium', 'obstruction_none', 'quality_high', 'quality_low', 'quality_medium', 'quality_perfect', 'attributes_minor', 'attributes_sunglasses'], 'default', 'value' => null],
            [['moderation_id', 'video_face_id'], 'required'],
            [['moderation_id', 'video_face_id'], 'integer'],
            [['x1', 'y1', 'x2', 'y2', 'left_eye_x', 'left_eye_y', 'right_eye_x', 'right_eye_y', 'nose_tip_x', 'nose_tip_y', 'left_mouth_corner_x', 'left_mouth_corner_y', 'right_mouth_corner_x', 'right_mouth_corner_y', 'sunglasses', 'no_sunglasses', 'angle_back_side', 'angle_back_straight', 'filter_false', 'filter_true', 'obstruction_complete', 'obstruction_extreme', 'obstruction_heavy', 'obstruction_light', 'obstruction_medium', 'obstruction_none', 'quality_high', 'quality_low', 'quality_medium', 'quality_perfect', 'attributes_minor', 'attributes_sunglasses'], 'number'],
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
            'video_face_id' => 'Video Face ID',
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
            'sunglasses' => 'Sunglasses',
            'no_sunglasses' => 'No Sunglasses',
            'angle_back_side' => 'Angle Back Side',
            'angle_back_straight' => 'Angle Back Straight',
            'filter_false' => 'Filter False',
            'filter_true' => 'Filter True',
            'obstruction_complete' => 'Obstruction Complete',
            'obstruction_extreme' => 'Obstruction Extreme',
            'obstruction_heavy' => 'Obstruction Heavy',
            'obstruction_light' => 'Obstruction Light',
            'obstruction_medium' => 'Obstruction Medium',
            'obstruction_none' => 'Obstruction None',
            'quality_high' => 'Quality High',
            'quality_low' => 'Quality Low',
            'quality_medium' => 'Quality Medium',
            'quality_perfect' => 'Quality Perfect',
            'attributes_minor' => 'Attributes Minor',
            'attributes_sunglasses' => 'Attributes Sunglasses',
        ];
    }

}