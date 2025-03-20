<?php

namespace common\models\moderation;

use common\models\moderation\ActiveRecord;
use Yii;

/**
 * This is the model class for table "image_weapon".
 *
 * @property int $id
 * @property int $moderation_id
 * @property string|null $media_id
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
class ImageWeapon extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_weapon';
    }

    /**
     * @return Connection the database connection used by this AR class.
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
            [['media_id', 'firearm', 'firearm_gesture', 'firearm_toy', 'knife', 'animated', 'aiming_threat', 'aiming_camera', 'aiming_safe', 'in_hand_not_aiming', 'worn_not_in_hand', 'not_worn'], 'default', 'value' => null],
            [['moderation_id'], 'required'],
            [['moderation_id'], 'integer'],
            [['firearm', 'firearm_gesture', 'firearm_toy', 'knife', 'animated', 'aiming_threat', 'aiming_camera', 'aiming_safe', 'in_hand_not_aiming', 'worn_not_in_hand', 'not_worn'], 'number'],
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

    public static function weaponStore($feedback, $moderationId)
    {
        if (!isset($feedback['weapon']) || !is_array($feedback['weapon'])) {
            return false;
        }

        $model = new self();
        $model->moderation_id = $moderationId;
        $model->media_id = $feedback['media']['id'] ?? null;
        $model->firearm = $feedback['weapon']['classes']['firearm'] ?? 0;
        $model->firearm_gesture = $feedback['weapon']['classes']['firearm_gesture'] ?? 0;
        $model->firearm_toy = $feedback['weapon']['classes']['firearm_toy'] ?? 0;
        $model->knife = $feedback['weapon']['classes']['knife'] ?? 0;
        $model->animated = $feedback['weapon']['firearm_type']['animated'] ?? 0;
        $model->aiming_threat = $feedback['weapon']['firearm_action']['aiming_threat'] ?? 0;
        $model->aiming_camera = $feedback['weapon']['firearm_action']['aiming_camera'] ?? 0;
        $model->aiming_safe = $feedback['weapon']['firearm_action']['aiming_safe'] ?? 0;
        $model->in_hand_not_aiming = $feedback['weapon']['firearm_action']['in_hand_not_aiming'] ?? 0;
        $model->worn_not_in_hand = $feedback['weapon']['firearm_action']['worn_not_in_hand'] ?? 0;
        $model->not_worn = $feedback['weapon']['firearm_action']['not_worn'] ?? 0;

        if (!$model->save(false)) {
            return false;
        }

        return true;
    }
}
