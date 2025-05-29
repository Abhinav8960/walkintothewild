<?php

namespace common\models;

use common\models\operator\SafariOperator;
use common\models\partnerregistration\PartnerRegistration;
use Yii;
use common\models\User;

/**
 * This is the model class for table "user_follower".
 *
 * @property int $id
 * @property int $user_id
 * @property int $follow_user_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class UserFollow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_follower';
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
            [['follow_user_id', 'user_id'], 'required'],
            [['follow_user_id', 'user_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['follow_user_id', 'user_id'], 'unique', 'targetAttribute' => ['follow_user_id', 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'follow_user_id' => 'Follower User Id',
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

    public function getFollower()
    {
        return $this->hasOne(User::className(), ['id' => 'follow_user_id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        $partner_request = PartnerRegistration::find()->where(['status' => PartnerRegistration::STATUS_ACTIVE])->one();
        if (!empty($partner_request)) {
            $operator = SafariOperator::find()->where(['safari_operator_request_id' => $partner_request->id, 'status' => SafariOperator::STATUS_ACTIVE])->one();
            if (!empty($operator)) {
                if ($this->status == 1) {
                    return  new \common\events\operator\OperatorFollowedByUser($this->follower->name,$operator->business_name,$operator->operator_email);
                } elseif ($this->status == 0) {
                    return  new \common\events\operator\OperatorUnfollowedByUser($this->follower->name,$operator->business_name,$operator->operator_email);
                }
            }
        }
    }
}
