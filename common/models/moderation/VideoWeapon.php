<?php

namespace common\models\moderation;

use Yii;

/**
 * This is the model class for table "weapon".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $info_id
 * @property int|null $info_position
 * @property float|null $firearm
 * @property float|null $firearm_gesture
 * @property float|null $firearm_toy
 * @property float|null $knife
 * @property float|null $animated
 * @property float|null $aiming_threat
 * @property float|null $aiming_camera
 * @property float|null $aiming_safe
 * @property float|null $in_hand_not_aiming
 * @property float|null $worn_not_in_hand
 * @property float|null $not_worn
 */
class VideoWeapon extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_weapon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info_id', 'info_position', 'firearm', 'firearm_gesture', 'firearm_toy', 'knife', 'animated', 'aiming_threat', 'aiming_camera', 'aiming_safe', 'in_hand_not_aiming', 'worn_not_in_hand', 'not_worn'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id', 'info_position'], 'integer'],
            [['firearm', 'firearm_gesture', 'firearm_toy', 'knife', 'animated', 'aiming_threat', 'aiming_camera', 'aiming_safe', 'in_hand_not_aiming', 'worn_not_in_hand', 'not_worn'], 'number'],
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
            'firearm' => 'Firearm',
            'firearm_gesture' => 'Firearm Gesture',
            'firearm_toy' => 'Firearm Toy',
            'knife' => 'Knife',
            'animated' => 'Animated',
            'aiming_threat' => 'Aiming Threat',
            'aiming_camera' => 'Aiming Camera',
            'aiming_safe' => 'Aiming Safe',
            'in_hand_not_aiming' => 'In Hand Not Aiming',
            'worn_not_in_hand' => 'Worn Not In Hand',
            'not_worn' => 'Not Worn',
        ];
    }

    public static function weaponstore($fb, $id)
    {
        if (!isset($fb['data']['frames']) || !is_array($fb['data']['frames'])) {
            return false;
        }

        foreach ($fb['data']['frames'] as $frame) {
            $model = new self();
            $model->moderation_id = $id;
            $model->info_id = $frame['info']['id'] ?? null;
            $model->info_position = $frame['info']['position'] ?? null;
            $model->firearm = $frame['weapon']['classes']['firearm'] ?? 0;
            $model->firearm_gesture = $frame['weapon']['classes']['firearm_gesture'] ?? 0;
            $model->firearm_toy = $frame['weapon']['classes']['firearm_toy'] ?? 0;
            $model->knife = $frame['weapon']['classes']['knife'] ?? 0;
            $model->animated = $frame['weapon']['firearm_type']['animated'] ?? 0;
            $model->aiming_threat = $frame['weapon']['firearm_action']['aiming_threat'] ?? 0;
            $model->aiming_camera = $frame['weapon']['firearm_action']['aiming_camera'] ?? 0;
            $model->aiming_safe = $frame['weapon']['firearm_action']['aiming_safe'] ?? 0;
            $model->in_hand_not_aiming = $frame['weapon']['firearm_action']['in_hand_not_aiming'] ?? 0;
            $model->worn_not_in_hand = $frame['weapon']['firearm_action']['worn_not_in_hand'] ?? 0;
            $model->not_worn = $frame['weapon']['firearm_action']['not_worn'] ?? 0;
        
            if (!$model->save()) {
                return false;
            }
        }

        return true;
    }
}
