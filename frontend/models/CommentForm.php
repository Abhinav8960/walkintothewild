<?php

namespace frontend\models;

use common\models\cms\article\Article;
use common\models\cms\article\ArticleComment;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CommentForm extends Model
{
    public $comment;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'required'],
        ];
    }


    /**
     * Save Contatc Query
     *
     * @param Corporate $corporate
     * @return void
     */
    public function comment(Article $article)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $comment = new ArticleComment();
        $comment->comment = $this->comment;
        $comment->comment_datetime = date('Y-m-d H:i:s');
        $comment->user_id = Yii::$app->user->id;
        $comment->article_id = $article->id;
        $comment->ip_address = Yii::$app->getRequest()->getUserIp();
        $comment->device_type = $agent->device();
        $comment->browser = $agent->browser();
        $comment->os = $agent->platform();

        if ($article->approval_required == 1) {
            $comment->status = 3;
        } else {
            $comment->status = 1;
        }

        if ($comment->save()) {
            return $comment->save();
        }
    }
}
