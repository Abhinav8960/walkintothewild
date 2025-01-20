<?php

namespace frontend\models;

use common\interfaces\NewStatusInterface;
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
    public $action_url;
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'required'],
            ['comment', 'validateContent'],
            ['comment', function () {
                if (!preg_match('/^[a-zA-Z0-9.,;\' ]*$/', $this->comment)) {
                    $this->addError('comment', 'Invalid Characters!!!');
                }
            }],
        ];
    }


    public function comment(ShareSafari $share_safari)
    {

        // $comment = ShareSafariComment::find()
        //     ->where([
        //         'share_safari_id' => $share_safari->id,
        //         'park_id' =>  $share_safari->park->id,
        //         'user_id' => Yii::$app->user->id,
        //         'comment' => $this->comment
        //     ])->andWhere(['>=', 'created_at', time() - Yii::$app->params['comment_threshold']])->one();
        // if ($comment) {
        //     return $comment;
        // }
        // $agent = new \Jenssegers\Agent\Agent();
        // $agent->setUserAgent(Yii::$app->request->userAgent);
        $comment = new ShareSafariComment();

        $comment->share_safari_id = $share_safari->id;
        $comment->park_id = $share_safari->park->id;
        $comment->user_id = Yii::$app->user->id;
        $comment->comment = $this->comment;
        // $comment->user_device = $agent->device();
        // $comment->user_agent = Yii::$app->request->userAgent;
        // $comment->user_platform =  $agent->platform();
        // $comment->user_browser = $agent->browser();
        // $comment->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $comment->status = NewStatusInterface::STATUS_ACTIVE;


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
