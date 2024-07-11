<?php

namespace common\models\sharesafari\form;

use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use Yii;
use yii\base\Model;


/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Approval
 */
class ShareSafariCommentActionForm extends model
{
    public $comment_action_model;
    public $status;


    public function __construct(ShareSafariCommentReport $comment_action_model = null)
    {

        $this->comment_action_model = Yii::createObject([
            'class' => ShareSafariCommentReport::className()
        ]);


        if ($comment_action_model  != '') {
            $this->comment_action_model = $comment_action_model;
            $this->status =  $this->comment_action_model->status;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {


        return [
            [['status'], 'integer'],
            ['status', 'required']


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
        $this->comment_action_model->status =  $this->status;
    }
}
