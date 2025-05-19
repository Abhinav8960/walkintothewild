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
        $fields[] = "image_path";
        $fields[] = "image_thumbnails";
        $hold_fields = ['id', 'version', 'meal_lunch', 'meal_breakfast', 'day_image', 'meal_dinner', 'day_activity', 'day_accommodation', 'day_note', 'package_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImage_path()
    {
        if ($this->day_image) {
            return \Yii::$app->params['endpoint'] . '/' . $this->day_image;
        }
        return '';
    }

    public function getImage_thumbnails()
    {
        if ($this->day_image) {
            return $arr = [
                'high' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/high/' . $this->day_image,
                'standard' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/standard/' . $this->day_image,
                'medium' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/medium/' . $this->day_image,
                'low' => Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/low/' . $this->day_image,
            ];
        }
        return [];
    }
}
