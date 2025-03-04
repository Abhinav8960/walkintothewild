<?php

namespace common\models\urlshortner;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "url_shortner".
 *
 * @property int $id
 * @property string $shortner_url
 * @property string $short_id
 * @property int $code
 * @property string|null $alias
 * @property int|null $created_at
 */
class UrlShortner extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;


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
        return 'url_shortner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'default', 'value' => 302],
            [['shortner_url', 'short_id'], 'required'],
            [['shortner_url'], 'string'],
            [['code', 'created_at'], 'integer'],
            [['short_id', 'alias'], 'string', 'max' => 10],
            [['short_id'], 'unique'],
            [['click_count', 'one_time_valid'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shortner_url' => 'Shortner Url',
            'referrer_url' => 'Referrer Url',
            'short_id' => 'Short ID',
            'code' => 'Code',
            'alias' => 'Alias',
            'one_time_valid' => 'One Time Valid',
            'created_at' => 'Created At',
        ];
    }

    public function incrementClick()
    {
        $this->updateCounters(['click_count' => 1]);
    }


    public function urlshortnerlog()
    {
        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);

        $url_shortner_log = new UrlShortnerLog();
        $url_shortner_log->url_shortner_id = $this->id;
        $url_shortner_log->user_device  = $agent->device();
        $url_shortner_log->referrer_url = Yii::$app->request->referrer;
        $url_shortner_log->user_agent =  Yii::$app->request->userAgent;
        $url_shortner_log->user_platform = $agent->platform();
        $url_shortner_log->user_platform_version = $agent->version($url_shortner_log->user_platform);
        $url_shortner_log->user_browser = $agent->browser();
        $url_shortner_log->user_browser_version = $agent->version($url_shortner_log->user_browser);
        $url_shortner_log->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $url_shortner_log->status = UrlShortnerLog::STATUS_ACTIVE;
        $url_shortner_log->save(false);
    }
}
