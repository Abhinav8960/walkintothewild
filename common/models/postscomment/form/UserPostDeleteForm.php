<?php

namespace common\models\postscomment\form;

use Yii;
use yii\base\Model;
use common\models\UserPosts;

class UserPostDeleteForm extends model
{

    public $delete_reason;
    public $status;
    public $user_posts_model;


    public function __construct(UserPosts $user_posts_model = null)
    {

        $this->user_posts_model = Yii::createObject([
            'class' => UserPosts::className()
        ]);

        if ($user_posts_model  != '') {
            $this->user_posts_model    = $user_posts_model;
            $this->delete_reason       =  $this->user_posts_model->delete_reason;
            $this->status              =  $this->user_posts_model->status;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delete_reason'], 'required'],
            [['delete_reason'], 'string', 'max' => 512],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delete_reason' => 'Delete Reason',
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
        $this->user_posts_model->delete_reason          =  $this->delete_reason;
        $this->user_posts_model->status               =  $this->status;
    }
}
