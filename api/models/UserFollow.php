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
    public function fields()
    {
        if (in_array(\Yii::$app->controller->action->uniqueId, ['profile/default/followers-list'])) {
            if ($this->user) {
                foreach ($this->user->toArray() as $key => $value) {
                    $fields[$key] = function () use ($key) {
                        if ($key == 'is_safari_operator') {
                            return (bool) $this->user->is_safari_operator;
                        }
                        if ($key == 'is_blue_badge_verified') {
                            return (bool) $this->user->is_blue_badge_verified;
                        }
                        return $this->user->{$key};
                    };
                }
            }
        }

        if (in_array(\Yii::$app->controller->action->uniqueId, ['profile/default/followings-list'])) {
            if ($this->follower) {
                foreach ($this->follower->toArray() as $key => $value) {
                    $fields[$key] = function () use ($key) {
                        if ($key == 'is_safari_operator') {
                            return (bool) $this->follower->is_safari_operator;
                        }
                        if ($key == 'is_blue_badge_verified') {
                            return (bool) $this->follower->is_blue_badge_verified;
                        }
                        return $this->follower->{$key};
                    };
                }
            }
        }
        $fields['joined_at'] = function () {
            return $this->created_at;
        };

        return $fields;
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getFollower()
    {
        return $this->hasOne(User::className(), ['id' => 'follow_user_id']);
    }
}
