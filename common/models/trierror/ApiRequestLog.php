<?php

namespace common\models\trierror;

use Yii;
use common\models\User;

/**
 * This is the model class for table "site_api_request".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $user_ip
 * @property string|null $request_group
 * @property string|null $slug
 * @property string|null $route
 * @property string|null $request_url
 * @property string|null $request_full_url
 * @property string|null $request_type
 * @property string|null $request_parameter
 * @property string|null $request_data
 * @property int $request_code
 * @property string|null $response_error
 * @property int|null $is_server_error
 * @property int|null $is_client_error
 * @property string|null $device
 * @property string|null $system
 * @property string|null $platform
 * @property string|null $browser
 * @property string|null $browser_version
 * @property int $is_count
 * @property int $is_reqeust_trace
 * @property string $created_at
 */
class ApiRequestLog extends \common\models\trierror\ActiveLogRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return  'site_api_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_ip', 'request_group', 'slug', 'route', 'request_url', 'request_full_url', 'request_type', 'request_parameter', 'request_data', 'response_error', 'is_server_error', 'is_client_error', 'device', 'system', 'platform', 'browser', 'browser_version', 'response'], 'default', 'value' => null],
            [['is_reqeust_trace'], 'default', 'value' => 0],
            [['user_id', 'request_code', 'is_server_error', 'is_client_error', 'is_count', 'is_reqeust_trace'], 'integer'],
            [['request_full_url', 'request_parameter', 'request_data', 'response_error','platform_version','application_version'], 'string'],
            [['created_at','platform_version','application_version'], 'safe'],
            [['user_ip', 'device', 'system', 'platform', 'browser', 'browser_version'], 'string', 'max' => 155],
            [['request_group', 'route'], 'string', 'max' => 255],
            [['slug', 'request_url'], 'string', 'max' => 555],
            [['request_type'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_ip' => 'User Ip',
            'request_group' => 'Request Group',
            'slug' => 'Slug',
            'route' => 'Route',
            'request_url' => 'Request Url',
            'request_full_url' => 'Request Full Url',
            'request_type' => 'Request Type',
            'request_parameter' => 'Request Parameter',
            'request_data' => 'Request Data',
            'request_code' => 'Request Code',
            'response_error' => 'Response Error',
            'is_server_error' => 'Is Server Error',
            'is_client_error' => 'Is Client Error',
            'device' => 'Device',
            'system' => 'System',
            'response' => 'Response',
            'platform' => 'Platform',
            'platform_version' => 'Platform Version',
            'application_version' => 'Application Version',
            'browser' => 'Browser',
            'browser_version' => 'Browser Version',
            'is_count' => 'Is Count',
            'is_reqeust_trace' => 'Is Reqeust Trace',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
