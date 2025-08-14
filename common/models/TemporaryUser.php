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
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property Post[] $posts
 */
class TemporaryUser extends ActiveRecord implements IdentityInterface
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
            [['user_handle','name', 'mobile_no', 'is_mobile_no_verified', 'email', 'is_email_verified'], 'safe']
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

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->token_key = Yii::$app->security->generateRandomString(32);
            $this->auth_key = Yii::$app->security->generateRandomString();
        }
        return parent::beforeSave($insert);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getFullname()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getUserhandle()
    {
        return "@" . $this->user_handle;
    }
}
