<?php

namespace common\models\sharesafari\form;


use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariRequest;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class ShareSafariApprovalForm extends model
{


    public $is_approved;
    public $share_safari_request_approval_model;


    public function __construct(ShareSafariRequest $share_safari_request_approval_model = null)
    {

        $this->share_safari_request_approval_model = Yii::createObject([
            'class' => ShareSafariRequest::className()
        ]);



        if ($share_safari_request_approval_model  != '') {
            $this->share_safari_request_approval_model = $share_safari_request_approval_model;
            $this->is_approved              =  $this->share_safari_request_approval_model->is_approved;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        return [
            [['is_approved'], 'integer'],
            [['is_approved'], 'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_approved' => 'Status',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->share_safari_request_approval_model->is_approved =  $this->is_approved;
    }
}
