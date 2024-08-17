<?php

namespace frontend\models;

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\cms\article\ArticleComment;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariComment;
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


    public function reply(ShareSafari $share_safari)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $reply = new ShareSafariComment();
        $reply->share_safari_id = $share_safari->id;
        $reply->park_id = $share_safari->park->id;
        $reply->user_id = Yii::$app->user->id;
        $reply->parent_id = $this->parent_id;
        $reply->comment = $this->comment;
        $reply->user_device = $agent->device();
        $reply->user_agent = Yii::$app->request->userAgent;
        $reply->user_platform =  $agent->platform();
        $reply->user_browser = $agent->browser();
        $reply->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $reply->status = StatusInterface::STATUS_ACTIVE;



        if ($reply->save(false)) {
            return $reply;
        }
    }
}
