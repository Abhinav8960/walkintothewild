<?php

namespace common\models\master\packagefeature\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\packagefeature\MasterPackagefeature;


/**
 * Update and Create package_feature
 */
class MasterPackagefeatureForm extends model
{
    public $title;
    public $status;
    public $status_option = [];
    public $package_feature_model;


    public function __construct(MasterPackagefeature $package_feature_model = null)
    {

        $this->package_feature_model = Yii::createObject([
            'class' => MasterPackagefeature::className()
        ]);



        if ($package_feature_model  != '') {
            $this->package_feature_model = $package_feature_model;
            $this->title = $this->package_feature_model->title;
            $this->status = $this->package_feature_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
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
        $this->package_feature_model->title = $this->title;
        $this->package_feature_model->status = $this->status;
    }
}
