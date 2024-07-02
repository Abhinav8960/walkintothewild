<?php

namespace frontend\models;

use common\models\cms\article\Article;
use common\models\cms\article\ArticleComment;
use common\models\operator\SafariOperatorRating;
use common\models\operator\SafariOperatorRatingReport;
use Yii;
use yii\base\Model;

/**
 * SafariOperatorRatingReportForm is the model behind the SafariOperatorRatingReport form.
 */
class SafariOperatorRatingReportForm extends Model
{
    public $safari_operator_id;
    public $park_id;
    public $safari_operator_rating_id;
    public $report_reason_id;
    public $report_detail;
    public $status;
    public $action_url;
    public $action_validate_url;
    public $flag_model;


    public function __construct(SafariOperatorRatingReport $flag_model = null)
    {
        $this->flag_model = Yii::createObject([
            'class' => SafariOperatorRatingReport::className()
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
            'safari_operator_id' => 'Safari Operator',
            'park_id' => 'Park',
            'safari_operator_rating_id' => 'Safari Operator Rating',
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
        $this->flag_model->safari_operator_id = $this->safari_operator_id;
        $this->flag_model->park_id = $this->park_id;
        $this->flag_model->safari_operator_rating_id = $this->safari_operator_rating_id;
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
