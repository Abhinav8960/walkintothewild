<?php

namespace frontend\models;

use common\interfaces\NewStatusInterface;
use common\models\operator\SafariOperator;
use common\models\package\PackageVersion;
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
    public $action_url;
    public $action_validate_url;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment', 'parent_id'], 'required'],
            ['comment', 'validateContent'],
            // ['comment', function () {
            //     if (!preg_match('/^[a-zA-Z0-9%#*@.,;\'"\-?!:()&\n\r ]*$/', $this->comment)) {
            //         $this->addError('comment', 'Invalid Characters!!!');
            //     }
            // }],
        ];
    }


    public function reply(Package $package)
    {
        // $reply = PackageComment::find()
        //     ->where([
        //         'package_id' => $package->id,
        //         'user_id' => Yii::$app->user->id,
        //         'parent_id' => $this->parent_id,
        //         'comment' => $this->comment
        //     ])->andWhere(['>=', 'created_at', time() - Yii::$app->params['comment_threshold']])->one();
        // if ($reply) {
        //     return $reply;
        // }
        // $agent = new \Jenssegers\Agent\Agent();
        // $agent->setUserAgent(Yii::$app->request->userAgent);
        $reply = new PackageComment();
        $reply->package_id = $package->id;
        $reply->version = $package->live_version;
        $reply->user_id = Yii::$app->user->id;
        if (Yii::$app->user->identity) {
            $safari_operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->id, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one();
            if ($safari_operator) {
                $reply->safari_operator_id = $safari_operator->id;
            }
        }
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


    public function commentbyParent()
    {
        return PackageComment::findone($this->parent_id);
    }


    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 200) {
            $this->addError($attribute, 'Please provide content within 200 words.');
        }
    }
}
