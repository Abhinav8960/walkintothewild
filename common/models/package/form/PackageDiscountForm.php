<?php

namespace common\models\package\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\package\Package;

class PackageDiscountForm extends model
{

    public $discount_type;
    public $discount_in_percentage;
    public $discount_in_value;
    public $package_discount_model;


    public function __construct(?Package $package_discount_model = null)
    {

        $this->package_discount_model = Yii::createObject([
            'class' => Package::class
        ]);



        if ($package_discount_model  != '') {
            $this->package_discount_model = $package_discount_model;
            $this->discount_type              =  $this->package_discount_model->discount_type;
            $this->discount_in_percentage     =  $this->package_discount_model->discount_in_percentage;
            $this->discount_in_value          =  $this->package_discount_model->discount_in_value;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discount_type'], 'required'],
            [['discount_type', 'discount_in_percentage'], 'number'],
            [
                'discount_in_percentage',
                'required',
                'when' => function ($model) {
                    return $model->discount_type == 1;
                },
                'whenClient' => "function (attribute, value) {
                return $('#discount_type').val() == '1';
            }"
            ],

            [
                'discount_in_value',
                'required',
                'when' => function ($model) {
                    return $model->discount_type == 2;
                },
                'whenClient' => "function (attribute, value) {
                return $('#discount_type').val() == '2';
            }"
            ],
            [['discount_in_percentage'], 'default', 'value' => 0.00],
            [['discount_in_value'], 'default', 'value' => 0.00],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'discount_type' => 'Discount Type',
            'discount_in_percentage' => 'Discount In Percentage',
            'discount_in_value' => 'Discount In Value',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->package_discount_model->discount_type = $this->discount_type;
        $this->package_discount_model->discount_in_percentage = $this->discount_in_percentage;
        $this->package_discount_model->discount_in_value = $this->discount_in_value;
    }
}
