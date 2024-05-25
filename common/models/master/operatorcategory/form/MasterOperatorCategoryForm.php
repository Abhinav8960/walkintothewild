<?php

namespace common\models\master\operatorcategory\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\operatorcategory\MasterOperatorCategory;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create operator
 */
class MasterOperatorCategoryForm extends model
{
    public $type_id;
    public $title;
    public $status;
    public $status_option = [];
    public $operator_category_model;
    public $uploadfile;


    public function __construct(MasterOperatorCategory $operator_category_model = null)
    {

        $this->operator_category_model = Yii::createObject([
            'class' => MasterOperatorCategory::className()
        ]);



        if ($operator_category_model  != '') {
            $this->operator_category_model = $operator_category_model;
            $this->type_id = $this->operator_category_model->type_id;
            $this->operator_category_model = $operator_category_model;
            $this->title = $this->operator_category_model->title;
            $this->status = $this->operator_category_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'title', 'status'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            ['uploadfile', 'required', 'on' => 'uploadfile'],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = ['type_id', 'title'];
        $scenarios['update'] = ['type_id', 'title'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'City',
            'state_id' => 'State',
            'country_id' => 'Country',
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
        $this->operator_category_model->type_id = $this->type_id;
        $this->operator_category_model->title = $this->title;
        $this->operator_category_model->status = $this->status;
    }
}
