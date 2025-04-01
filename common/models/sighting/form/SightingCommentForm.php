<?php

namespace common\models\sighting\form;

use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use Yii;
use yii\base\Model;


class SightingCommentForm extends Model
{
    public $message;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            ['message', 'validateContent'],
            ['message', function () {
                if (!preg_match('/^[a-zA-Z0-9.,;\' ]*$/', $this->message)) {
                    $this->addError('message', 'Invalid Characters!!!');
                }
            }],
        ];
    }



    public function comment(Sighting $sighting)
    {
        $comment = new SightingComment();
        $comment->message = $this->message;
        $comment->comment_datetime = date('Y-m-d H:i:s');
        $comment->user_id = Yii::$app->user->id;
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
