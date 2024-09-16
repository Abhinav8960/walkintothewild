<?php

namespace common\models\master\suggetioncategory\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\suggetioncategory\MasterSuggestionCategory;

class MasterSuggestionCategoryForm extends model
{
    public $title;
    public $status;
    public $status_option = [];
    public $suggestion_category_model;


    public function __construct(MasterSuggestionCategory $suggestion_category_model = null)
    {

        $this->suggestion_category_model = Yii::createObject([
            'class' => MasterSuggestionCategory::className()
        ]);

        if ($suggestion_category_model  != '') {
            $this->suggestion_category_model = $suggestion_category_model;
            $this->title = $this->suggestion_category_model->title;
            $this->status = $this->suggestion_category_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 125],
            [['status'], 'default', 'value' => 1],
            [
                ['title'], 'unique', 'targetClass' => MasterSuggestionCategory::className(), 'message' => 'This title has already been taken.',
                'filter' => function ($query) {
                    if (!$this->suggestion_category_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->suggestion_category_model->id]]);
                    }
                }
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'status' => 'Status',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->suggestion_category_model->title = $this->title;
        $this->suggestion_category_model->status = $this->status;
    }
}
