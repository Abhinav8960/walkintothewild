<?php

namespace common\models\master\packagefeature\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\packagetag\MasterPackageTag;

/**
 * Update and Create package_feature
 */
class MasterPackageTagForm extends model
{
    public $tag_name;
    public $tag_color;
    public $status;
    public $status_option = [];
    public $package_tag_model;


    public function __construct(? MasterPackageTag $package_tag_model = null)
    {

        $this->package_tag_model = Yii::createObject([
            'class' => MasterPackageTag::class
        ]);



        if ($package_tag_model  != '') {
            $this->package_tag_model = $package_tag_model;
            $this->tag_name = $this->package_tag_model->tag_name;
            $this->tag_color = $this->package_tag_model->tag_color;
            $this->status = $this->package_tag_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_name','tag_color'], 'required'],
            [['status'], 'integer'],
            [['tag_name','tag_color'], 'string', 'max' => 512],
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
            'tag_name' => 'Tag Name',
            'tag_color' => 'Tag Color',
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
        $this->package_tag_model->tag_name = $this->tag_name;
        $this->package_tag_model->tag_color = $this->tag_color;
        $this->package_tag_model->status = $this->status;
    }
}
