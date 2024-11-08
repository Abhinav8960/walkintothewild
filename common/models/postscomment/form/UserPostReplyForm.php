<?php

namespace common\models\postscomment\form;

use api\models\posts\UserPostComment;
use common\models\UserPosts;
use Yii;
use yii\base\Model;


/**
 * UserPostReplyForm is the model behind the reply form.
 */
class UserPostReplyForm extends Model
{
    public $message;
    public $parent_id;
    public $action_url;
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'parent_id'], 'required'],
            ['message', 'validateContent'],
            ['message', function () {
                if (!preg_match('/^[a-zA-Z0-9.,; ]*$/', $this->message)) {
                    $this->addError('message', 'Invalid Characters!!!');
                }
            }],
        ];
    }


    public function reply(UserPosts $userpost)
    {
        $reply = new UserPostComment();
        $reply->message = $this->message;
        $reply->comment_datetime = date('Y-m-d H:i:s');
        $reply->user_id = Yii::$app->user->id;
        $reply->user_posts_id = $userpost->id;
        $reply->parent_id = $this->parent_id;

        if ($reply->save(false)) {
            return $reply;
        }
    }


    public function commentbyParent()
    {
        return UserPostComment::findone($this->parent_id);
    }

    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 100) {
            $this->addError($attribute, 'Please provide content within 100 words.');
        }
    }
}
