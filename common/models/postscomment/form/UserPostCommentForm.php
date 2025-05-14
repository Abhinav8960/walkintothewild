<?php

namespace common\models\postscomment\form;

use common\models\GeneralModel;
use common\models\operator\SafariOperator;
use common\models\postscomment\UserPostComment;
use common\models\UserPosts;
use Yii;
use yii\base\Model;

/**
 * UserPostCommentForm is the model behind the UserPostComment form.
 */
class UserPostCommentForm extends Model
{
    public $comment;
    public $version;
    public $action_url;
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment','version'], 'required'],
            ['comment', 'validateContent'],
            ['comment', function () {
                if (!preg_match('/^[a-zA-Z0-9.,;\' ]*$/', $this->comment)) {
                    $this->addError('comment', 'Invalid Characters!!!');
                }
            }],
        ];
    }


    
    public function comment(UserPosts $userpost)
    {     
        $comment = new UserPostComment();
        $comment->comment = $this->comment;
        $comment->dateTime = date('Y-m-d H:i:s');
        $comment->user_id = Yii::$app->user->id;
        $comment->safari_operator_id = GeneralModel::operatorsIdOrNull(Yii::$app->user->id);
        $comment->user_posts_id = $userpost->id;
        $comment->status = 1;
        $comment->version = $this->version;

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
