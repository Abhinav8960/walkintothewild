<?php

namespace backend\modules\registration\model;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\registration\BirdingOperatorRequest;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class BirdingOperatorTourApprovalForm extends model
{
    public $comment;
    public $is_approved;

    public $status;
    public $status_option = [];
    public $birdingoperator_request_approval_model;


    public function __construct(BirdingOperatorRequest $birdingoperator_request_approval_model = null)
    {

        $this->birdingoperator_request_approval_model = Yii::createObject([
            'class' => BirdingOperatorRequest::className()
        ]);



        if ($birdingoperator_request_approval_model  != '') {
            $this->birdingoperator_request_approval_model = $birdingoperator_request_approval_model;
            $this->is_approved              =  $this->birdingoperator_request_approval_model->is_approved;
            $this->comment              =  $this->birdingoperator_request_approval_model->comment;
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
            [['comment'], 'safe']
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
        $this->birdingoperator_request_approval_model->is_approved               =  $this->is_approved;
        $this->birdingoperator_request_approval_model->comment                   =  $this->comment;
    }
}
