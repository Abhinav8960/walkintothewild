<?php

namespace common\models\postscomment\form;

use common\models\cms\flagreason\Flagreason;
use common\models\postscomment\UserPostCommentFlag;
use Yii;
use yii\base\Model;

/**
 * UserPostCommentFlagForm is the model behind the UserPostCommentFlagForm form.
 */
class UserPostCommentFlagForm extends Model
{
    public $user_posts_id;
    public $user_post_comment_id;
    public $flag_reason_id;
    public $flag_detail;
    public $status;
    public $user_post_flag_model;


    public function __construct(UserPostCommentFlag $user_post_flag_model = null)
    {
        $this->user_post_flag_model = Yii::createObject([
            'class' => UserPostCommentFlag::className()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_reason_id', 'flag_detail'], 'required'],
            ['flag_reason_id', 'exist', 'targetClass' => Flagreason::class, 'targetAttribute' => ['flag_reason_id' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_posts_id' => 'User Posts ID',
            'user_post_comment_id' => 'User Post Comment ID',
            'flag_reason_id' => 'Flag Reason ID',
            'flag_detail' => 'Flag Detail',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }


    public function initializeForm()
    {

        $this->user_post_flag_model->user_id = Yii::$app->user->identity->id;
        $this->user_post_flag_model->user_posts_id = $this->user_posts_id;
        $this->user_post_flag_model->user_post_comment_id = $this->user_post_comment_id;
        $this->user_post_flag_model->flag_reason_id = $this->flag_reason_id;
        $this->user_post_flag_model->flag_detail = $this->flag_detail;
        $this->user_post_flag_model->status = 1;
    }
}
