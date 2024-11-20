<?php

namespace api\models\park;

use api\models\User;
use Yii;

/**
 * This is the model class for table "safari_park_rating".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $safari_park_id
 * @property float|null $rating
 * @property string|null $review
 * @property int|null $flaged
 * @property string|null $user_device
 * @property string|null $user_agent
 * @property string|null $user_platform
 * @property string|null $user_platform_version
 * @property string|null $user_browser
 * @property string|null $user_browser_version
 * @property string|null $user_ip_address
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */

class SafariParkRating extends \common\models\park\SafariParkRating
{
    public function fields()
    {
        $fields = parent::fields();
        
        $fields[] = 'user';
        $hold_fields = ['id','user_id', 'safari_park_id', 'user_device', 'user_agent', 'user_platform', 'user_platform_version', 'user_browser', 'user_browser_version', 'user_ip_address', 'status', 'created_by', 'updated_by', 'updated_at'];


        return array_diff($fields, $hold_fields);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::className(), ['id' => 'safari_park_id']);
    }
}
