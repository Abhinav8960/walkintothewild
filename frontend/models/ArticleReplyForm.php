<?php

namespace frontend\models;

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleComment;
use Yii;
use yii\base\Model;


/**
 * PackageReplyForm is the model behind the reply form.
 */
class ArticleReplyForm extends Model
{
    public $comment;
    public $parent_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment', 'parent_id'], 'required'],
            ['comment', 'validateContent'],
            ['comment', function () {
                if (!preg_match('/^[a-zA-Z0-9.,; ]*$/', $this->comment)) {
                    $this->addError('comment', 'Invalid Characters!!!');
                }
            }],
        ];
    }


    public function reply(Article $article)
    {

        // $agent = new \Jenssegers\Agent\Agent();
        // $agent->setUserAgent(Yii::$app->request->userAgent);
        $reply = new ArticleComment();
        $reply->comment = $this->comment;
        $reply->comment_datetime = date('Y-m-d H:i:s');
        $reply->user_id = Yii::$app->user->id;
        $reply->article_id = $article->id;
        $reply->parent_id = $this->parent_id;
        // $reply->ip_address = Yii::$app->getRequest()->getUserIp();
        // $reply->device_type = $agent->device();
        // $reply->browser = $agent->browser();
        // $reply->os = $agent->platform();



        if ($reply->save(false)) {
            return $reply;
        }
    }


    public function commentbyParent()
    {
        return ArticleComment::findone($this->parent_id);
    }

    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 100) {
            $this->addError($attribute, 'Please provide content within 100 words.');
        }
    }
}
