<?php

namespace common\models\postscomment\form;

use common\models\postscomment\UserPostComment;
use common\models\UserPosts;
use Yii;
use yii\base\Model;

/**
 * UserPostCommentForm is the model behind the UserPostComment form.
 */
class UserPostCommentForm extends Model
{
    public $message;
    public $action_url;
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            ['message', 'validateContent'],
            ['message', function () {
                if (!preg_match('/^[a-zA-Z0-9.,;\' ]*$/', $this->message)) {
                    $this->addError('message', 'Invalid Characters!!!');
                }
            }],
        ];
    }


    
    public function comment(UserPosts $userpost)
    {     
        $comment = new UserPostComment();
        $comment->message = $this->message;
        $comment->comment_datetime = date('Y-m-d H:i:s');
        $comment->user_id = Yii::$app->user->id;
        $comment->user_posts_id = $userpost->id;
        $comment->status = 1;

        if ($comment->save(false)) {
            return $comment;
        }
    }

    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 100) {
            $this->addError($attribute, 'Please provide content within 100 words.');
        }
    }
}
