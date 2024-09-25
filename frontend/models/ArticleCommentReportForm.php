<?php

namespace frontend\models;

use common\models\cms\article\ArticleCommentReport;
use Yii;
use yii\base\Model;

/**
 * ArticleCommentReportForm is the model behind the ArticleCommentReport form.
 */
class ArticleCommentReportForm extends Model
{
    public $article_id;
    public $article_comment_id;
    public $report_reason_id;
    public $report_detail;
    public $status;
    public $action_url;
    public $action_validate_url;
    public $flag_model;


    public function __construct(ArticleCommentReport $flag_model = null)
    {
        $this->flag_model = Yii::createObject([
            'class' => ArticleCommentReport::className()
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
            'article_id' => 'Article',
            'article_comment_id' => 'Article Comment',
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
        $this->flag_model->user_id = Yii::$app->user->identity->id;
        $this->flag_model->article_id = $this->article_id;
        $this->flag_model->article_comment_id = $this->article_comment_id;
        $this->flag_model->report_reason_id = $this->report_reason_id;
        $this->flag_model->report_detail = $this->report_detail;
        $this->flag_model->status = 1;
    }
}
