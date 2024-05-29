<?php

namespace backend\modules\registration\model;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\registration\SafariOperatorRequest;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class SafariOperatorTourApprovalForm extends model
{
    public $comment;
    public $is_approved;
    public $safari_operator_id;

    public $status;
    public $status_option = [];
    public $safarioperator_request_approval_model;


    public function __construct(SafariOperatorRequest $safarioperator_request_approval_model = null)
    {

        $this->safarioperator_request_approval_model = Yii::createObject([
            'class' => SafariOperatorRequest::className()
        ]);



        if ($safarioperator_request_approval_model  != '') {
            $this->safarioperator_request_approval_model = $safarioperator_request_approval_model;
            $this->is_approved              =  $this->safarioperator_request_approval_model->is_approved;
            $this->comment              =  $this->safarioperator_request_approval_model->comment;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        return [
            [['is_approved', 'status'], 'integer'],
            [['is_approved', 'comment'], 'required'],
            [['comment', 'safari_operator_id'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_approved' => 'Is Approved',
            'comment' => 'Comment',
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
        $this->safarioperator_request_approval_model->is_approved               =  $this->is_approved;
        $this->safarioperator_request_approval_model->comment                   =  $this->comment;
    }
}
