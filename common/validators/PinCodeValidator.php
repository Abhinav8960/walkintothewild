<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Pincode Validator
 * 
 * 
 * @author Aayush Kumar <aayushsaini9999@gmail.com>
 */

class PinCodeValidator extends Validator
{

    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute != '') {
            if (!preg_match('/^[0-9]{6}+$/', $model->$attribute)) {
                $this->addError($model, $attribute, 'Invalid pin code');
            }
        }
    }
}
