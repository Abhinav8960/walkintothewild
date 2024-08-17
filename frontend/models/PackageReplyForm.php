<?php

namespace frontend\models;

use common\interfaces\StatusInterface;
use common\models\package\Package;
use common\models\package\PackageComment;
use Yii;
use yii\base\Model;


/**
 * PackageReplyForm is the model behind the reply form.
 */
class PackageReplyForm extends Model
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


    public function reply(Package $package)
    {

        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);
        $reply = new PackageComment();
        $reply->package_id = $package->id;
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


    public function commentbyParent()
    {
        return PackageComment::findone($this->parent_id);
    }
}
