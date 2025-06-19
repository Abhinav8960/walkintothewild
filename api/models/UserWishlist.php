<?php

namespace api\models;

use api\models\package\PackageVersion;
use api\models\sharesafari\ShareSafari;
use Yii;

class UserWishlist extends \common\models\UserWishlist
{
    public function fields()
    {
        $fields = parent::fields();
        if (in_array(\Yii::$app->controller->action->uniqueId, ['account/default/wishlist-shared-safari'])) {
            $fields[] = 'sharesafari';
        }
        if (in_array(\Yii::$app->controller->action->uniqueId, ['account/default/wishlist-package'])) {
            $fields[] = 'package';
        }
        $hold_fields = ['user_id', 'item_type_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getSharesafari()
    {
        return $this->hasMany(ShareSafari::class, ['id' => 'item_id']);
    }

    public function getPackage()
    {
        return $this->hasMany(PackageVersion::class, ['id' => 'item_id']);
    }
}
