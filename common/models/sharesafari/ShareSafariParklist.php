<?php

namespace common\models\sharesafari;

use common\models\park\SafariPark;
use common\models\User;
use Yii;

/**
 * This is the model class for table "share_safari_park".
 *
 * @property int $id
 * @property int|null $share_safari_id
 * @property int|null $park_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class ShareSafariParklist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_park';
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
            [['share_safari_id', 'park_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Share Safari ID',
            'park_id' => 'Park ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSharesafari()
    {
        return $this->hasOne(ShareSafari::className(), ['id' => 'share_safari_id']);
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }
}
