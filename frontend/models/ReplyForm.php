<?php

namespace frontend\models;

use common\interfaces\NewStatusInterface;
use common\models\cms\blog\Blog;
use common\models\cms\blog\BlogComment;
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
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment', 'parent_id'], 'required'],
            ['comment', 'validateContent'],
            ['comment', function () {
                // if (!preg_match('/^[a-zA-Z0-9.,;\' ]*$/', $this->comment)) {
                if (!preg_match('/^[a-zA-Z0-9%#*@.,;\'"\-?!:()&\n\r ]*$/', $this->comment)) {
                    $this->addError('comment', 'Invalid Characters!!!');
                }
            }],
        ];
    }


    public function reply(ShareSafari $share_safari)
    {
        // $reply = ShareSafariComment::find()
        //     ->where([
        //         'share_safari_id' => $share_safari->id,
        //         'park_id' =>  $share_safari->park->id,
        //         'user_id' => Yii::$app->user->id,
        //         'parent_id' => $this->parent_id,
        //         'comment' => $this->comment
        //     ])->andWhere(['>=', 'created_at', time() - Yii::$app->params['comment_threshold']])->one();
        // if ($reply) {
        //     return $reply;
        // }

        // $agent = new \Jenssegers\Agent\Agent();
        // $agent->setUserAgent(Yii::$app->request->userAgent);
        $reply = new ShareSafariComment();
        $reply->share_safari_id = $share_safari->id;
        $reply->park_id = $share_safari->park->id;
        $reply->user_id = Yii::$app->user->id;
        $reply->parent_id = $this->parent_id;
        $reply->comment = $this->comment;
        // $reply->user_device = $agent->device();
        // $reply->user_agent = Yii::$app->request->userAgent;
        // $reply->user_platform =  $agent->platform();
        // $reply->user_browser = $agent->browser();
        // $reply->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $reply->status = NewStatusInterface::STATUS_ACTIVE;



        if ($reply->save(false)) {
            return $reply;
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
