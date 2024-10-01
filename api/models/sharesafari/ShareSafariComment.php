<?php

namespace api\models\sharesafari;

use Yii;
use api\models\User;
use api\models\park\SafariPark;


class ShareSafariComment extends \common\models\sharesafari\ShareSafariComment
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'park';
        $fields[] = 'sharesafari';
        $fields[] = 'user';
        $fields[] = 'parent';
        $fields[] = 'reports';
        $fields[] = 'replies';
        $hold_fields = ['status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }


    public function getSharesafari()
    {
        return $this->hasOne(ShareSafari::className(), ['id' => 'share_safari_id']);
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'park_id']);
    }


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
}
