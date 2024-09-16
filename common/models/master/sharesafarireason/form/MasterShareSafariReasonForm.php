<?php

namespace common\models\master\sharesafarireason\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\sharesafarireason\MasterShareSafariReason;

/**
 * Update and Create Reason
 */
class MasterShareSafariReasonForm extends model
{
    public $reason;
    public $status;
    public $status_option = [];
    public $share_safari_reason_model;


    public function __construct(MasterShareSafariReason $share_safari_reason_model = null)
    {

        $this->share_safari_reason_model = Yii::createObject([
            'class' => MasterShareSafariReason::className()
        ]);



        if ($share_safari_reason_model  != '') {
            $this->share_safari_reason_model = $share_safari_reason_model;
            $this->reason = $this->share_safari_reason_model->reason;
            $this->status = $this->share_safari_reason_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason'], 'required'],
            [['status'], 'integer'],
            [['reason'], 'string', 'max' => 512],
            [['status'], 'default', 'value' => 1],
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
        $this->share_safari_reason_model->reason = $this->reason;
        $this->share_safari_reason_model->status = $this->status;
    }
}
