<?php

namespace common\models\sharesafari\form;


use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafari;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class ShareSafariApprovalForm extends model
{


    public $status;
    public $share_safari_model;


    public function __construct(ShareSafari $share_safari_model = null)
    {

        $this->share_safari_model = Yii::createObject([
            'class' => ShareSafari::className()
        ]);



        if ($share_safari_model  != '') {
            $this->share_safari_model = $share_safari_model;
            $this->status              =  $this->share_safari_model->status;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        return [
            [['status'], 'integer'],
            [['status'], 'required'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
        $this->share_safari_model->status =  $this->status;
    }
}
