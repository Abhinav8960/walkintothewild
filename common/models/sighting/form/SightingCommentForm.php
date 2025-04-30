<?php

namespace common\models\sighting\form;

use common\models\operator\SafariOperator;
use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use Yii;
use yii\base\Model;


class SightingCommentForm extends Model
{
    public $comment;


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



    public function comment(Sighting $sighting)
    {
        $comment = new SightingComment();
        $comment->comment = $this->comment;
        $comment->dateTime = date('Y-m-d H:i:s');
        $comment->user_id = Yii::$app->user->id;
        if (Yii::$app->user->identity) {
            $safari_operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->id, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one();
            if ($safari_operator) {
                $comment->safari_operator_id = $safari_operator->id;
            }
        }
        $comment->sighting_id = $sighting->id;
        $comment->status = 1;

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
