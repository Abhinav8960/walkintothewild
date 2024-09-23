<?php

namespace frontend\models;

use common\models\cms\blog\BlogCommentReport;
use Yii;
use yii\base\Model;

/**
 * BlogCommentReportForm is the model behind the BlogCommentReport form.
 */
class BlogCommentReportForm extends Model
{
    public $blog_id;
    public $blog_comment_id;
    public $report_reason_id;
    public $report_detail;
    public $status;
    public $action_url;
    public $action_validate_url;
    public $flag_model;


    public function __construct(BlogCommentReport $flag_model = null)
    {
        $this->flag_model = Yii::createObject([
            'class' => BlogCommentReport::className()
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
            'blog_id' => 'Blog',
            'blog_comment_id' => 'Blog Comment',
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
        // $agent = new \Jenssegers\Agent\Agent();
        // $agent->setUserAgent(Yii::$app->request->userAgent);

        $this->flag_model->user_id = Yii::$app->user->identity->id;
        $this->flag_model->blog_id = $this->blog_id;
        $this->flag_model->blog_comment_id = $this->blog_comment_id;
        $this->flag_model->report_reason_id = $this->report_reason_id;
        $this->flag_model->report_detail = $this->report_detail;
        // $this->flag_model->user_device  = $agent->device();
        // $this->flag_model->user_ip_address = Yii::$app->getRequest()->getUserIp();
        // $this->flag_model->user_agent =  Yii::$app->request->userAgent;
        // $this->flag_model->user_platform = $agent->platform();
        // $this->flag_model->user_browser = $agent->browser();
        $this->flag_model->status = 1;
    }
}
