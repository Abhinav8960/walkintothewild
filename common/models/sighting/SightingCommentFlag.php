<?php

namespace common\models\sighting;

use common\models\cms\flagreason\Flagreason;
use common\models\User;
use Yii;

/**
 * This is the model class for table "sighting_comment_flag".
 *
 * @property int $id
 * @property int|null $sighting_id
 * @property int|null $sighting_comment_id
 * @property int|null $flag_reason_id
 * @property string|null $flag_detail
 * @property int|null $user_id
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class SightingCommentFlag extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sighting_comment_flag';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sighting_id', 'sighting_comment_id', 'flag_reason_id', 'flag_detail', 'user_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['sighting_id', 'sighting_comment_id', 'flag_reason_id', 'user_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['flag_detail'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sighting_id' => 'Sighting ID',
            'sighting_comment_id' => 'Sighting Comment ID',
            'flag_reason_id' => 'Flag Reason ID',
            'flag_detail' => 'Flag Detail',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getFlagreason()
    {
        return $this->hasOne(Flagreason::className(), ['id' => 'flag_reason_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSighting()
    {
        return $this->hasOne(Sighting::className(), ['id' => 'sighting_id']);
    }

    public function getComment()
    {
        return $this->hasOne(SightingComment::className(), ['id' => 'sighting_comment_id']);
    }

}