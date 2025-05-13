<?php

namespace common\models\sighting\form;

use common\models\sighting\SightingCommentFlag;
use Yii;
use yii\base\Model;



class SightingCommentFlagActionForm extends model
{
    public $sighting_flag_action_model;
    public $status;
    public $reason;
    public $user_id;


    public function __construct(SightingCommentFlag $sighting_flag_action_model = null)
    {

        $this->sighting_flag_action_model = Yii::createObject([
            'class' => SightingCommentFlag::className()
        ]);


        if ($sighting_flag_action_model  != '') {
            $this->sighting_flag_action_model = $sighting_flag_action_model;
            $this->status =  $this->sighting_flag_action_model->status;
            $this->reason =  $this->sighting_flag_action_model->reason;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        return [
            [['status', 'user_id'], 'integer'],
            [['status', 'reason'], 'required']


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
            'user_id' => 'User Id',
            'reason' => 'Reason',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->sighting_flag_action_model->status =  $this->status;
        $this->sighting_flag_action_model->reason =  $this->reason;

    }
}
