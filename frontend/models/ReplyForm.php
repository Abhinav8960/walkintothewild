<?php

namespace frontend\models;

use common\models\cms\article\Article;
use common\models\cms\article\ArticleComment;
use Yii;
use yii\base\Model;


/**
 * ContactForm is the model behind the reply form.
 */
class ReplyForm extends Model
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
        ];
    }


    /**
     * Save Contatc Query
     *
     * @param Corporate $corporate
     * @return void
     */
    public function reply(Article $article)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $reply = new ArticleComment();
        $reply->comment = $this->comment;
        $reply->comment_datetime = date('Y-m-d H:i:s');
        $reply->user_id = Yii::$app->user->id;
        $reply->article_id = $article->id;
        $reply->ip_address = Yii::$app->getRequest()->getUserIp();
        $reply->device_type = $agent->device();
        $reply->browser = $agent->browser();
        $reply->os = $agent->platform();

        if ($article->approval_required == 1) {
            $reply->status = 3;
        } else {
            $reply->status = 1;
        }


        if ($reply->save()) {
            return $reply->save();
        }
    }
}
