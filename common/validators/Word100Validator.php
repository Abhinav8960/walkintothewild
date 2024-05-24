<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Class Word100Validator
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class Word100Validator extends Validator
{

    public function validateAttribute($model, $attribute)
    {

        if ($model->$attribute != '') {
            if (str_word_count($model->$attribute) > 100) {
                $this->addError($model, $attribute, $model->getAttributeLabel($attribute) . ' length can not exceeded 100 words.');
            }
        }
    }
}
