<?php

namespace common\models\operator\form;

use common\models\operator\SafariOperatorStayCategory;
use Yii;
use yii\base\Model;

class SafariOperatorStayCategoryForm extends model
{

    public $meta_stay_category;
    public $stay_category_model;

    public function __construct(SafariOperatorStayCategory $stay_category_model = null)
    {

        $this->stay_category_model = Yii::createObject([
            'class' => SafariOperatorStayCategory::class
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta_stay_category'], 'safe'],
        ];
    }

}
