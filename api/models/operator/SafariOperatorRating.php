<?php

namespace api\models\operator;

use Yii;
use api\models\User;
use api\models\park\SafariPark;
use common\models\operator\SafariOperatorRatingReport;

class SafariOperatorRating extends \common\models\operator\SafariOperatorRating
{

    public function fields()
    {
        $fields = parent::fields();
        if(!in_array(\Yii::$app->controller->action->uniqueId, ['operator/default/user-rating-parklist']))
        {
            $fields[] = 'user';
            $fields[] = 'park';
            $hold_fields = ['safari_operator_id', 'park_id', 'parent_id', 'user_id', 'flaged', 'is_deleted', 'user_device', 'user_agent', 'user_platform', 'user_platform_version', 'user_browser', 'user_browser_version', 'user_ip_address', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        }else{
            $hold_fields = ['id', 'safari_operator_id','parent_id', 'user_id', 'flaged', 'is_deleted', 'user_device', 'user_agent', 'user_platform', 'user_platform_version', 'user_browser', 'user_browser_version', 'user_ip_address', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];

        }
        return array_diff($fields, $hold_fields);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(SafariOperator::className(), ['id' => 'safari_operator_id']);
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    // public function getCommentreply($review_id)
    // {
    //     return SafariOperatorRating::find()->where(['parent_id' => $review_id])->orderBy('id DESC')->all();
    // }

    public function getReports()
    {
        return $this->hasMany(SafariOperatorRatingReport::className(), ['safari_operator_rating_id' => 'id']);
    }
}
