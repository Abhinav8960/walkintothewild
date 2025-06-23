<?php

namespace api\models\sharesafari;

use Yii;
use api\models\User;
use api\models\park\SafariPark;
use common\models\GeneralModel;

class ShareSafariComment extends \common\models\sharesafari\ShareSafariComment
{
    public function fields()
    {
        $fields = parent::fields();
        // $fields[] = 'park';
        // $fields[] = 'sharesafari';
        $fields[] = 'date_time';
        $fields[] = 'user';
        // $fields[] = 'parent';
        $fields[] = 'will_flag';
        $fields[] = 'replies';
        $fields[] = 'timestamp';
        
       
        $hold_fields = ['user_id','flaged', 'deleted_by', 'share_safari_id', 'park_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        $fields = array_diff($fields, $hold_fields);

        $fields['comment'] = function ($model) {
            return GeneralModel::apicommentConversion($model->comment);
        };
       
        return $fields;
    }


    public function getSharesafari()
    {
        return $this->hasOne(ShareSafari::className(), ['id' => 'share_safari_id']);
    }

    // public function getPark()
    // {
    //     return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    // }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }


    public function getReports()
    {
        return $this->hasMany(ShareSafariCommentReport::className(), ['share_safari_comment_id' => 'id']);
    }

    public function getReplies()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    public function getWill_flag()
    {
        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' =>  \Yii::$app->params['active_user_id'], 'share_safari_id' => $this->sharesafari->id, 'status' => 1])->limit(1)->one();
        if ($share_safari_intrested && $share_safari_intrested->user_id != $this->user_id) {
            return true;
        }
        return false;
    }

    public function getDate_time()
    {
        return date("F j, Y", $this->created_at) . ' at ' . date("H:i A", $this->created_at);
    }

    public function getTimestamp()
    {
        return $this->created_at;
    }
}
