<?php

namespace common\models\package\form;

use Yii;
use common\models\package\PackageTermCondition;

class PackageTermConditionForm extends \yii\base\Model
{
    public $package_id;
    public $title;
    public $description;
    public $status;
    public $package_termcondition_model;
    public $action_url;
    public $action_validate_url;


    /**
     * @param [type] $package_termcondition_model
     */
    public function __construct(PackageTermCondition $package_termcondition_model = null)
    {
        $this->package_termcondition_model = Yii::createObject([
            'class' => PackageTermCondition::className()
        ]);
        if ($package_termcondition_model != null) {
            $this->package_termcondition_model = $package_termcondition_model;
            $this->package_id = $this->package_termcondition_model->package_id;
            $this->title = $this->package_termcondition_model->title;
            $this->description = $this->package_termcondition_model->description;
            $this->status = $this->package_termcondition_model->status;
        }
    }

    public function rules()
    {
        return [
            [['package_id', 'title', 'description'], 'required'],
            [['package_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 512],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'title',
            'description' => 'description',
            'position' => 'Position',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->package_termcondition_model->package_id = $this->package_id;
        $this->package_termcondition_model->title = $this->title;
        $this->package_termcondition_model->description = $this->description;
        $this->package_termcondition_model->status = $this->status;
    }
}
