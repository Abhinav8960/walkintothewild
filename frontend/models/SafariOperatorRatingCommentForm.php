<?php

namespace frontend\models;

use common\interfaces\StatusInterface;
use common\models\operator\SafariOperatorRating;
use common\models\operator\SafariOperatorRatingComment;
use Yii;
use yii\base\Model;


/**
 * ContactForm is the model behind the reply form.
 */
class SafariOperatorRatingCommentForm extends Model
{
  public $comment;
  public $safari_operator_rating_id;

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['comment', 'safari_operator_rating_id'], 'required'],
    ];
  }
}
