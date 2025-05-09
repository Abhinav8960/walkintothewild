<?php

namespace common\models\operator\form;

use Yii;
use yii\base\Model;
use common\models\operator\SafariOperatorPark;

class SafariOperatorParkForm extends model
{

    public $parks;
    public $safari_operator_park_model;


    public function __construct(SafariOperatorPark $safari_operator_park_model = null)
    {

        $this->safari_operator_park_model = Yii::createObject([
            'class' => SafariOperatorPark::className()
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parks'], 'required'],
        ];
    }

}
