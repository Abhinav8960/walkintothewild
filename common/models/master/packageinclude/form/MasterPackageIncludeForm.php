<?php

namespace common\models\master\packageinclude\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\packageinclude\MasterPackageInclude;

/**
 * Update and Create package_feature
 */
class MasterPackageIncludeForm extends model
{
    public $title;
    public $status;
    public $status_option = [];
    public $package_include_model;


    public function __construct(MasterPackageInclude $package_include_model = null)
    {

        $this->package_include_model = Yii::createObject([
            'class' => MasterPackageInclude::className()
        ]);



        if ($package_include_model  != '') {
            $this->package_include_model = $package_include_model;
            $this->title = $this->package_include_model->title;
            $this->status = $this->package_include_model->status;
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
            [['title'], 'string', 'max' => 512],
            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
        $this->package_include_model->title = $this->title;
        $this->package_include_model->status = $this->status;
    }
}
