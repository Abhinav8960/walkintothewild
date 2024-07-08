<?php

namespace frontend\models;

use common\interfaces\StatusInterface;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariComment;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ShareSafariCommentForm extends Model
{
    public $comment;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'required'],
            ['comment', \common\validators\Word120Validator::className()],
        ];
    }


    public function comment(ShareSafari $share_safari)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $comment = new ShareSafariComment();

        $comment->share_safari_id = $share_safari->id;
        $comment->park_id = $share_safari->park->id;
        $comment->user_id = Yii::$app->user->id;
        $comment->comment = $this->comment;
        $comment->user_device = $agent->device();
        $comment->user_agent = Yii::$app->request->userAgent;
        $comment->user_platform =  $agent->platform();
        $comment->user_browser = $agent->browser();
        $comment->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $comment->status = StatusInterface::STATUS_ACTIVE;


        if ($comment->save()) {
            return $comment->save();
        }
    }
}
