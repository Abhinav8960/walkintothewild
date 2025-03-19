<?php

namespace common\models\urlshortner;

use Yii;

/**
 * This is the model class for table "url_shortner_log".
 *
 * @property int $id
 * @property int $url_shortner_id
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_platform_version
 * @property string|null $user_browser
 * @property string|null $user_browser_version
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class UrlShortnerLog extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_shortner_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_device', 'user_agent', 'user_platform', 'user_platform_version', 'user_browser', 'user_browser_version', 'user_ip_address', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['id', 'url_shortner_id'], 'required'],
            [['id', 'url_shortner_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['user_device', 'user_agent', 'user_platform', 'user_platform_version', 'user_browser', 'user_browser_version', 'user_ip_address'], 'string', 'max' => 255],
            [['referrer_url'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_shortner_id' => 'Url Shortner ID',
            'user_device' => 'User Device',
            'user_agent' => 'User Agent',
            'user_platform' => 'User Platform',
            'user_platform_version' => 'User Platform Version',
            'user_browser' => 'User Browser',
            'user_browser_version' => 'User Browser Version',
            'user_ip_address' => 'User Ip Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
