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
    public $comment;


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
     * Save Contatc Query
     *
     * @param Corporate $corporate
     * @return void
     */
    public function comment(SafariOperatorRating $safari_operator_rating)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $safari_operator_rating_report = new SafariOperatorRatingReport();
        $safari_operator_rating_report->safari_operator_id = $this->report_reason_id;
        $safari_operator_rating_report->park_id = $this->report_reason_id;
        $safari_operator_rating_report->safari_operator_rating_id = $safari_operator_rating->id;
        $safari_operator_rating_report->report_reason_id = $this->report_reason_id;
        $safari_operator_rating_report->report_detail = $this->report_detail;
        $safari_operator_rating_report->user_id = Yii::$app->user->id;
        $safari_operator_rating_report->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $safari_operator_rating_report->user_platform = $agent->device();
        $safari_operator_rating_report->user_browser = $agent->browser();
        $safari_operator_rating_report->user_agent = $agent->platform();
        $safari_operator_rating_report->status = 1;
        return $safari_operator_rating_report->save();
    }
}
