<?php

namespace api\models;

use Yii;
use api\models\User;

/**
 * This is the model class for table "user_follower".
 *
 * @property int $id
 * @property int $user_id
 * @property int $follow_user_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class UserFollow extends \common\models\UserFollow
{
    

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getFollower()
    {
        return $this->hasOne(User::className(), ['id' => 'follow_user_id']);
    }
}
