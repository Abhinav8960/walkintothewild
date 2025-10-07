<?php

namespace common\models\package\form;

use Yii;
use yii\base\Model;
use common\models\package\Package;

class PackageTemplateForm extends model
{

    public $template_code;
    public $delete_reason;
    public $package_template_model;


    public function __construct(?Package $package_template_model = null)
    {

        $this->package_template_model = Yii::createObject([
            'class' => Package::class
        ]);

        if ($package_template_model  != '') {
            $this->package_template_model = $package_template_model;
            $this->template_code              =  $this->package_template_model->template_code;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_code'], 'required'],
            [['template_code'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_code' => 'Template Code',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->package_template_model->template_code          =  $this->template_code;
    }
}
