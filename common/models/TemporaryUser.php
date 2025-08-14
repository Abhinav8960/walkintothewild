<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\behaviors\UserHandleBehavior;
use common\models\master\userflag\MasterUserFlag;
use common\models\sharesafari\ShareSafari;
use common\models\operator\SafariOperator;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property Post[] $posts
 */
class TemporaryUser extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const ROLE_ADMINISTRATOR  = 1;
    const STATUS_MIGRATED = 11;

    const OBJECTIVE = "user";


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%temp_user}}';
    }

    /**
     * {@inheritdoc}
     */

     public function behaviors()
     {
         return [
             [
                 'class' => UserHandleBehavior::class,
                 'attribute' => 'name',
                 'slugAttribute' => 'user_handle',
                 'ensureUnique' => true,
                 'separator' => '_'
             ],
             TimestampBehavior::class,
         ];
     }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['user_handle','name', 'mobile_no', 'is_mobile_no_verified', 'email', 'is_email_verified'], 'safe'],
            [['is_expired','mobile_otp', 'email_otp', 'exp_datetime'], 'safe']

        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $access_token = UserSession::findOne(['token' => $token]);
        if ($access_token) {
            return static::findOne(['id' => $access_token->user_id, 'status' => self::STATUS_ACTIVE]);
        }
        return null;
    }

}
