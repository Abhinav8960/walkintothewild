<?php

namespace api\models\sharesafari;

use Yii;
use yii\base\Model;

class ShareSafariDay extends \common\models\sharesafari\ShareSafariDay
{
    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'imagepath';
        $hold_fields = [
            'start_location',
            'end_location',
            'latitude',
            'longitude',
            'hotel_name',
            'day_image',
            'meal_lunch',
            'meal_breakfast',
            'meal_dinner',
            'day_activity',
            'day_accommodation',
            'day_note',
            'imagepath',
            'status',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        ];
        return array_diff($fields, $hold_fields);
        return $fields;
    }

    public function getImagepath()
    {
        if ($this->day_image != '') {
            return '/storage/share_safari/day/' . $this->id . '/' . $this->day_image;
        }
    }
}
