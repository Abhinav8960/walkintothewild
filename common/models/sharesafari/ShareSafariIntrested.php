<?php

namespace common\models\sharesafari;

use Yii;
use common\models\User;

/**
 * This is the model class for table "share_safari_intrested".
 *
 * @property int $id
 * @property int|null $share_safari_id
 * @property int|null $park_id
 * @property int|null $user_id
 * @property int|null $intrested_at
 * @property int|null $unintrested_at
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_browser
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class ShareSafariIntrested extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'share_safari_intrested';
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
            [['share_safari_id', 'park_id', 'user_id', 'intrested_at', 'unintrested_at', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['user_device', 'user_platform', 'user_browser'], 'string', 'max' => 50],
            [['user_agent'], 'string', 'max' => 512],
            [['user_ip_address'], 'string', 'max' => 20],
            ['version', 'integer'],
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
            'user_id' => 'User ID',
            'intrested_at' => 'Intrested At',
            'unintrested_at' => 'Unintrested At',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_browser' => 'User Browser',
            'user_ip_address' => 'User Ip Address',
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

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->status == 1) {
            return  new \common\events\sharesafari\SafariJoinedByuser($this->sharesafari->slug, $this->user->name, $this->sharesafari->id);
        } elseif ($this->status == 0) {
            return  new \common\events\sharesafari\SafariUnjoinedByuser($this->sharesafari->slug, $this->user->name, $this->sharesafari->id);
        }
    }
}
