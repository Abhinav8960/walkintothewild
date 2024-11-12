<?php

namespace api\models\package;

use Yii;

/**
 * This is the model class for table "package_day".
 *
 * @property int $id
 * @property int $package_id
 * @property int $day
 * @property string|null $day_title
 * @property string|null $day_description
 * @property string|null $start_location
 * @property string|null $end_location
 * @property string|null $hotel_name
 * @property string|null $day_image
 * @property int|null $meal_lunch
 * @property int|null $meal_breakfast
 * @property int|null $meal_dinner
 * @property string|null $day_activity
 * @property string|null $day_accommodation
 * @property string|null $day_note
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PackageDay extends \common\models\package\PackageDay
{
    public function fields()
    {
        $fields = parent::fields();
        $hold_fields = ['id', 'package_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImagepath()
    {
        if ($this->day_image != '') {
            return '/storage/package/day/' . $this->id . '/' . $this->day_image;
        }
    }
}
