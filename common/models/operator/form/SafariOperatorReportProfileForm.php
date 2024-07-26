<?php

namespace common\models\operator\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorReportProfile;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Safari Operator
 */
class SafariOperatorReportProfileForm extends model
{
    public $reason;
    public $user_id;
    public $safari_operator_id;
    public $reason_id;

    public $status;
    public $status_option = [];

    public $report_model;


    public function __construct(SafariOperatorReportProfile $report_model = null)
    {

        $this->report_model = Yii::createObject([
            'class' => SafariOperatorReportProfile::className()
        ]);

        if ($report_model  != '') {
            $this->report_model = $report_model;
            $this->reason_id              =  $this->report_model->reason_id;
            $this->reason              =  $this->report_model->reason;
            $this->status              =  $this->report_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason', 'reason_id'], 'required'],
            [['reason'], 'string', 'max' => 512],
            [['user_id', 'safari_operator_id', 'status', 'reason_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reason' => 'Reason',
            'status' => 'Status',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->report_model->user_id          =  $this->user_id;
        $this->report_model->reason_id          =  $this->reason_id;
        $this->report_model->safari_operator_id          =  $this->safari_operator_id;
        $this->report_model->reason          =  $this->reason;
        $this->report_model->status          =  $this->status;
    }
}
