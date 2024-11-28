<?php

namespace api\models\package;

use api\models\User;
use Yii;

/**
 * This is the model class for table "package_comment".
 *
 * @property int $id
 * @property int|null $package_id
 * @property int|null $parent_id
 * @property int|null $user_id
 * @property string|null $comment
 * @property int $flaged
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_browser
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class PackageComment extends \common\models\package\PackageComment
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'user';
        $fields[] = 'replies';
        $fields[] = 'willflag';
        $hold_fields = ['id', 'user_id', 'package_id', 'comment_id', 'flaged', 'is_deleted', 'park_id', 'parent_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getReplies()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }


    // public function getReports()
    // {
    //     return $this->hasMany(PackageCommentReport::className(), ['package_comment_id' => 'id']);
    // }

    /**User Will flag */
    public function getWillflag()
    {
        if (Yii::$app->user->identity && $this->user_id != Yii::$app->user->identity->id) {
            return true;
        }
        return false;
    }
}
