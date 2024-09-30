<?php

namespace api\models\sharesafari;

use api\models\cms\flagreason\Flagreason;
use Yii;
use api\models\User;
use api\models\park\SafariPark;
use yii\base\Model;

class ShareSafariCommentReport extends Model
{
    public function fields()
    {
        $fields = parent::fields();
       
        $fields[] = 'sharesafari';
        $fields[] = 'comment';
        $fields[] = 'park';
        $fields[] = 'reportreason';
        $fields[] = 'user';
        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }


    public function getSharesafari()
    {
        return $this->hasOne(ShareSafari::className(), ['id' => 'share_safari_id']);
    }



    public function getComment()
    {
        return $this->hasOne(ShareSafariComment::className(), ['id' => 'share_safari_comment_id']);
    }


    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }

    public function getReportreason()
    {
        return $this->hasOne(Flagreason::className(), ['id' => 'report_reason_id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // public function getParentname()
    // {
    //     return isset($this->sharesafari) ? $this->sharesafari->share_safari_title : '';
    // }

    // public function getCommentname()
    // {
    //     return isset($this->comment) ? $this->comment->comment : '';
    // }
}
