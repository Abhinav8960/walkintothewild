<?php

namespace common\Helper;


class SmsHelper
{


    public static function handleMaxlength($value, $is_addon_needed = false)
    {
        $value = strlen($value) > 20 ? (substr($value, 0, 20) . '...') : $value;
        if ($is_addon_needed == true && !isset(\Yii::$app->params['environment']) || \Yii::$app->params['environment'] != 'production') {
            if ($is_addon_needed == true) {
                $value = $value . ' witw';
            }
        }
        return $value;
    }
}
