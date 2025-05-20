<?php

namespace common\Helper;


class SmsHelper
{


    public static function handleMaxlength($value)
    {
       return $value = strlen($value) > 25 ? (substr($value, 0, 25) . '...') : $value;        
    }
}
