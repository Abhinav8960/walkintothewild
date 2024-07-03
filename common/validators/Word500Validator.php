<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class Word500Validator
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class Word500Validator extends Validator
{

    public function validateAttribute($model, $attribute)
    {

        if ($model->$attribute != '') {
            if (str_word_count($model->$attribute) > 500) {
                $this->addError($model, $attribute, $model->getAttributeLabel($attribute) . ' length can not exceeded 120 words.');
                // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                // return $model->errors;
            }
        }
    }
}
