<?php

namespace common\models\postscomment\form;

use common\models\postscomment\UserPostCommentFlag;
use Yii;
use yii\base\Model;



class UserPostCommentFlagActionForm extends model
{
    public $user_post_flag_action_model;
    public $status;
    public $reason;
    public $user_id;


    public function __construct(UserPostCommentFlag $user_post_flag_action_model = null)
    {

        $this->user_post_flag_action_model = Yii::createObject([
            'class' => UserPostCommentFlag::className()
        ]);


        if ($user_post_flag_action_model  != '') {
            $this->user_post_flag_action_model = $user_post_flag_action_model;
            $this->status =  $this->user_post_flag_action_model->status;
            $this->reason =  $this->user_post_flag_action_model->reason;
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
        $this->user_post_flag_action_model->status =  $this->status;
        $this->user_post_flag_action_model->reason =  $this->reason;

    }
}
