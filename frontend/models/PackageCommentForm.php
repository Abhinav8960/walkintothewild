<?php

namespace frontend\models;

use common\interfaces\NewStatusInterface;
use common\models\GeneralModel;
use common\models\operator\SafariOperator;
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
            // ['comment', function () {
            //     if (!preg_match('/^[a-zA-Z0-9%#*@.,;\'"\-?!:()&\n\r ]*$/', $this->comment)) {
            //         $this->addError('comment', 'Invalid Characters!!!');
            //     }
            // }],
        ];
    }


    public function comment(Package $package)
    {

        // $comment = PackageComment::find()
        //     ->where([
        //         'package_id' => $package->id,
        //         'user_id' => Yii::$app->user->id,
        //         'comment' => $this->comment
        //     ])->andWhere(['>=', 'created_at', time() - Yii::$app->params['comment_threshold']])->one();
        // if ($comment) {
        //     return $comment;
        // }
        // $agent = new \Jenssegers\Agent\Agent();
        // $agent->setUserAgent(Yii::$app->request->userAgent);
        $comment = new PackageComment();

        $comment->package_id = $package->id;
        $comment->version = $package->live_version;
        $comment->user_id = Yii::$app->user->id;
        $comment->safari_operator_id = GeneralModel::operatorsIdOrNull(Yii::$app->user->id);
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
        if ($wordCount >= 200) {
            $this->addError($attribute, 'Please provide content within 200 words.');
        }
    }
}
