<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class Word120Validator
 * @author Smriti Pal <smritipal2201@gmail.com>
 */
class Word120Validator extends Validator
{

    public $word_limit = 120;
    public function validateAttribute($model, $attribute)
    {

        if ($model->$attribute != '') {
            if (str_word_count($model->$attribute) > $this->word_limit) {
                $this->addError($model, $attribute, $model->getAttributeLabel($attribute) . ' length can not exceeded ' . $this->word_limit . ' words.');
                // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                // return $model->errors;
            }
        }
    }
}
