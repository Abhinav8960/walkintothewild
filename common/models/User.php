<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\behaviors\UserHandleBehavior;
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
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const ROLE_ADMINISTRATOR  = 1;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            // 'slug' => [
            //     'class' => 'skeeks\yii2\slug\SlugBehavior',
            //     'slugAttribute' => 'user_handle', //The attribute to be generated
            //     'attribute' => 'name', //The attribute from which will be generated
            //     'maxLength' => 255,
            //     'ensureUnique' => true,
            //     'slugifyOptions' => [
            //         'lowercase' => true,
            //         'separator' => '_',
            //         'trim' => true
            //     ]
            // ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['is_adminstrator', 'is_admin', 'is_safari_operator', 'is_birding_operator', 'is_cms_manager', 'is_resort_manager', 'name'], 'safe'],
            [['user_handle', 'user_bio'], 'safe']
        ];
    }

    public function afterLogin()
    {
        $session = Yii::$app->session;
        $sessionId = $session->get('user_session_id');
        $userId = Yii::$app->user->id;
        $token = Yii::$app->security->generateRandomString();
        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        Yii::$app->db->createCommand()->insert('user_session', [
            'id' => $sessionId,
            'user_id' => $userId,
            'last_activity' => new \yii\db\Expression('NOW()'),
            'token' => $token,
            'ip_address' => Yii::$app->request->userIP,
            'user_agent' => Yii::$app->request->userAgent,
            'user_device' => $agent->device(),
            'user_platform' => $agent->platform(),
            'user_browser' => $agent->browser(),
            'created_at' => new \yii\db\Expression('NOW()'),
            'app_name' => Yii::$app->params['app_name']
        ])->execute();

        $session->set('session_token', $token);
        $this->manageUserSessions($userId, $sessionId);
    }

    /**
     * Manage USer Sessions
     */
    private function manageUserSessions($userId, $sessionId)
    {
        $keepSessionIds = UserSession::find()->select(['id'])
            ->where(['user_id' => $userId, 'app_name' => Yii::$app->params['app_name']])
            ->orderBy(['last_activity' => SORT_ASC])
            ->limit(Yii::$app->params['user.maxLoginAccount'])
            ->asarray()->column();

        UserSession::deleteAll([
            'AND',
            ['user_id' => $userId],
            ['app_name' => Yii::$app->params['app_name']],
            ['NOT IN', 'id', $keepSessionIds],
            ['NOT IN', 'id', [$sessionId]]
        ]);
    }

    /**
     * Run After Logout
     */
    public function afterLogout()
    {
        $session = Yii::$app->session;
        $sessionId = $session->getId();
        Yii::$app->db->createCommand()->delete('user_session', ['id' => $sessionId])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $access_token = UserSession::findOne(['token' => $token]);
        if ($access_token) {

            return static::find()->where(['id' => $access_token->user_id, 'status' => static::STATUS_ACTIVE])->one();
        }

        return false;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsernameFrontend($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }


    public static function findByUsername($username)
    {
        return static::find()
            ->where(['username' => $username, 'status' => self::STATUS_ACTIVE])
            ->andWhere([
                'OR',
                ['is_adminstrator' => 1],
                ['is_admin' => 1],
                ['is_cms_manager' => 1],
                ['is_resort_manager' => 1],
                ['is_report_manager' => 1],
            ])
            ->one();
    }





    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }





    /**
     * Before Insert
     *
     * @param [type] $insert
     * @return void
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('token_key', \Yii::$app->security->generateRandomString(32));
            $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            if (\Yii::$app instanceof \yii\web\Application) {
                // $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * Blocks the user by setting 'blocked_at' field to current time.
     */
    public function block()
    {
        return (bool) $this->updateAttributes(['blocked_at' => time(), 'status' => User::STATUS_INACTIVE]);
    }

    /**
     * Blocks the user by setting 'blocked_at' field to null.
     */
    public function unblock()
    {
        return (bool) $this->updateAttributes(['blocked_at' => null, 'status' => User::STATUS_ACTIVE]);
    }

    /**
     * @return bool Whether the user is blocked or not.
     */
    public function getIsBlocked()
    {
        return $this->blocked_at != null;
    }

    /**
     * Get User Cascade Status
     *
     * @return void
     */
    public function getIsCascade()
    {
        return $this->cascade_at != null;
    }

    /**
     * Blocks the user by setting 'cascade_at' field to current time.
     */
    public function cascade()
    {
        return (bool) $this->updateAttributes(['cascade_at' => time()]);
    }

    /**
     * Blocks the user by setting 'cascade_at' field to null.
     */
    public function uncascade()
    {
        return (bool) $this->updateAttributes(['cascade_at' => null]);
    }

    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get How Many Days are Completed Until Password is Not Change
     *
     * @return void
     */
    public function getPasswordupdatedays()
    {
        if ($this->password_update_at != null) {
            $curent_time = time();
            $diff = $curent_time - $this->password_update_at;
            return ceil(abs($diff / 86400));
        }
        return 365;
    }
    // public function getPosts()
    // {
    //     return $this->hasMany(User::className(), ['user_id' => 'id']);
    // }


    public function getCheck($attribute)
    {

        if ($this->$attribute == 1) {
            return true;
        }

        return false;
    }

    public function getUserhandle()
    {
        return "@" . $this->user_handle;
    }

    public function getName()
    {
        if ($this->operator && $this->operator->user_id == $this->id) {
            return $this->operator->businessname;
        }
        return $this->name;
    }

    public function getProfileimage()
    {
        if ($this->operator && $this->operator->user_id == $this->id) {
            return $this->operator->imagepath;
        }

        if ($this->profile_image != '') {
            return '/storage/user/' . $this->id . '/' . $this->profile_image;
        }

        if ($this->avatar != '') {
            return $this->avatar;
        }
    }

    public function getCoverimage()
    {
        if ($this->cover_image != '') {
            return '/storage/user_cover_image/' . $this->id . '/' . $this->cover_image;
        }
    }

    public function getUserfollowers()
    {
        return $this->hasMany(UserFollow::class, ['follow_user_id' => 'id']);
    }

    public function getUserfollowings()
    {
        return $this->hasMany(UserFollow::class, ['user_id' => 'id']);
    }

    public function getSharesafari()
    {
        return $this->hasMany(ShareSafari::class, ['host_user_id' => 'id']);
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['user_id' => 'id'])->andWhere(['status' => SafariOperator::STATUS_ACTIVE]);
    }
}
