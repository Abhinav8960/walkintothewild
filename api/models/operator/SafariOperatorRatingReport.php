<?php

namespace api\models\operator;

use common\models\cms\flagreason\Flagreason;
use Yii;
use api\models\User;
use api\models\park\SafariPark;

class SafariOperatorRatingReport extends \common\models\operator\SafariOperatorRatingReport
{


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getRating()
    {
        return $this->hasOne(SafariOperatorRating::className(), ['id' => 'safari_operator_rating_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'safari_operator_id']);
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }


    // public function getReportreason()
    // {
    //     return $this->hasOne(Flagreason::className(), ['id' => 'report_reason_id']);
    // }

    public function getParentname()
    {
        return isset($this->operator) ? $this->operator->business_name : '';
    }


    public function getCommentname()
    {
        return isset($this->rating) ? $this->rating->review : '';
    }
}
