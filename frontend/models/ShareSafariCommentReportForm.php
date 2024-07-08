<?php

namespace frontend\models;

use common\models\sharesafari\ShareSafariCommentReport;
use Yii;
use yii\base\Model;

/**
 * ShareSafariCommentReportForm is the model behind the ShareSafariCommentReport form.
 */
class ShareSafariCommentReportForm extends Model
{
    public $share_safari_id;
    public $park_id;
    public $share_safari_comment_id;
    public $report_reason_id;
    public $report_detail;
    public $status;
    public $action_url;
    public $action_validate_url;
    public $flag_model;


    public function __construct(ShareSafariCommentReport $flag_model = null)
    {
        $this->flag_model = Yii::createObject([
            'class' => ShareSafariCommentReport::className()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_reason_id', 'report_detail'], 'required'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_safari_id' => 'Shared Safari',
            'park_id' => 'Park',
            'share_safari_comment_id' => 'Shared Safari Comment',
            'report_reason_id' => 'Report Reason',
            'report_detail' => 'Report Detail',
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


    public function initializeForm()
    {
        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);

        $this->flag_model->user_id = Yii::$app->user->identity->id;
        $this->flag_model->share_safari_id = $this->share_safari_id;
        $this->flag_model->park_id = $this->park_id;
        $this->flag_model->share_safari_comment_id = $this->share_safari_comment_id;
        $this->flag_model->report_reason_id = $this->report_reason_id;
        $this->flag_model->report_detail = $this->report_detail;
        $this->flag_model->user_device  = $agent->device();
        $this->flag_model->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $this->flag_model->user_agent =  Yii::$app->request->userAgent;
        $this->flag_model->user_platform = $agent->platform();
        $this->flag_model->user_browser = $agent->browser();
        $this->flag_model->status = 1;
    }
}
