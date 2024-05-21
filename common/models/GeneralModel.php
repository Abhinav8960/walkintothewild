<?php

namespace common\models;

use common\models\master\country\MasterCountry;
use common\models\master\state\MasterState;
use Yii;
use yii\helpers\ArrayHelper;

class GeneralModel extends \yii\base\Model implements \common\interfaces\StatusInterface
{

    const ORDER_BOOKING_TYPE = 'SR';

    public static function DateFormatForDb($date)
    {

        $dbDateFormat = \Yii::$app->formatter->asDatetime($date, "php:Y-m-d");
        return $dbDateFormat;
    }
    public static function DateFormatForView($date)
    {

        $viewDateFormat = \Yii::$app->formatter->asDatetime($date, "php:d-m-Y");
        return $viewDateFormat;
    }

    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function statusoption()
    {
        return [self::STATUS_ACTIVE => 'Active', self::STATUS_SUSPEND => 'Suspend'];
    }

    /**
     * Get Status Active/Inactive Options List
     *
     * @return void
     */
    public static function sortingoption()
    {
        return [3 => 'A To Z', 4 => 'Z To A'];
    }

    /**
     * Get Yes No Option List
     *
     * @return void
     */
    public static function yesnooption()
    {
        return [1 => 'Yes', 0 => 'No'];
    }

    /**
     * Day short Name
     *
     * @return array
     */
    public static function dayshortname()
    {
        return [
            1 => 'mon',
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
            7 => 'sun',
        ];
    }

    /**
     * Day Name
     *
     * @return array
     */
    public static function dayname()
    {
        return [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];
    }


    public static function stateoption()
    {
        return ArrayHelper::map(MasterState::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['state_name' => SORT_ASC])->all(), 'id', 'state_name');
    }

    public static function countryoption()
    {
        return ArrayHelper::map(MasterCountry::find()->where(['status' => self::STATUS_ACTIVE])->orderBy(['country_name' => SORT_ASC])->all(), 'id', 'country_name');
    }

    public static function getAllState($countryId)
    {
        return ArrayHelper::map(MasterState::find()->where(['country_id' => $countryId, 'status' => self::STATUS_ACTIVE])->orderBy(['state_name' => SORT_ASC])->all(), 'id', 'state_name');
    }
}
