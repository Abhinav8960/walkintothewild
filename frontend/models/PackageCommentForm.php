<?php

namespace frontend\models;

use common\interfaces\StatusInterface;
use common\models\package\Package;
use common\models\package\PackageComment;
use Yii;
use yii\base\Model;

/**
 * PackageCommentForm is the model behind the contact form.
 */
class PackageCommentForm extends Model
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
                if (!preg_match('/^[a-zA-Z0-9.,; ]*$/', $this->comment)) {
                    $this->addError('comment', 'Invalid Characters!!!');
                }
            }],
        ];
    }


    public function comment(Package $package)
    {

        // $agent = new \Jenssegers\Agent\Agent();
        // $agent->setUserAgent(Yii::$app->request->userAgent);
        $comment = new PackageComment();

        $comment->package_id = $package->id;
        $comment->user_id = Yii::$app->user->id;
        $comment->comment = $this->comment;
        // $comment->user_device = $agent->device();
        // $comment->user_agent = Yii::$app->request->userAgent;
        // $comment->user_platform =  $agent->platform();
        // $comment->user_browser = $agent->browser();
        // $comment->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $comment->status = StatusInterface::STATUS_ACTIVE;


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
