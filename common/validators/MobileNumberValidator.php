<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class Mobile Nummber Validator
 * 
 * 
 * @author Aayush Kumar <aayushsaini9999@gmail.com>
 */
class MobileNumberValidator extends Validator
{

    public function validateAttribute($model, $attribute)
    {
        if (isset($model->$attribute) and $model->$attribute != '') {
            if (!preg_match('/^[123456789]\d{9}$/', $model->$attribute)) {
                $this->addError($model, $attribute, $model->getAttributeLabel($attribute) . ' Invalid Mobile Number');
                // $this->addError($model, $attribute, 'Invalid Mobile Number');
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->errors;
            }
        }
    }
}
