<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * GSTIN validation
 * 
 * 
 * @author Aayush Kumar <aayushsaini9999@gmail.com>
 */
class GSTINValidator extends Validator
{

    public function validateAttribute($model, $attribute)
    {
        $regex = "/^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/";
        if ($model->$attribute) {
            if (!preg_match($regex, $model->$attribute)) {
                $flag = "Invalid GST number ";
                $this->addError($model, $attribute, 'Invalid GST number');
            }
        }
    }
}
