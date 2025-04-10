<?php

namespace common\models\sighting\form;

use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use Yii;
use yii\base\Model;


/**
 * SightingReplyForm is the model behind the reply form.
 */
class SightingReplyForm extends Model
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
            ['comment', 'validateContent'],
            ['comment', function () {
                if (!preg_match('/^[a-zA-Z0-9.,; ]*$/', $this->comment)) {
                    $this->addError('comment', 'Invalid Characters!!!');
                }
            }],
        ];
    }


    public function reply(Sighting $sighting)
    {
        $reply = new SightingComment();
        $reply->comment = $this->comment;
        $reply->dateTime = date('Y-m-d H:i:s');
        $reply->user_id = Yii::$app->user->id;
        $reply->sighting_id = $sighting->id;
        $reply->parent_id = $this->parent_id;

        if ($reply->save(false)) {
            return $reply;
        }
    }


    public function commentbyParent()
    {
        return SightingComment::findone($this->parent_id);
    }

    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 100) {
            $this->addError($attribute, 'Please provide content within 100 words.');
        }
    }
}
