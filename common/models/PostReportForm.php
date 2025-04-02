<?php

namespace common\models;

use common\models\PostReport;
use Yii;
use yii\base\Model;

/**
 * SightingForm form
 */
class PostReportForm extends Model
{

    public $message;
    public $user_id;
    public $post_id;
    public $status;
    public $post_model;

    public function __construct(PostReport $post_model = null)
    {
        $this->post_model = Yii::createObject([
            'class' => PostReport::className()
        ]);
        if ($post_model != null) {
            $this->post_model = $post_model;
            $this->message = $this->post_model->message;
            $this->user_id = $this->post_model->user_id;
            $this->post_id = $this->post_model->post_id;
            $this->status = $this->post_model->status;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message','user_id','post_id'], 'required'],
            [['user_id', 'status','post_id'], 'integer'],
            [['message'], 'string'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'post_id' => 'Post ID',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {

        $this->post_model->message = $this->message;
        $this->post_model->user_id = $this->user_id;
        $this->post_model->status = $this->status;
        $this->post_model->post_id = $this->post_id;
    }

}
