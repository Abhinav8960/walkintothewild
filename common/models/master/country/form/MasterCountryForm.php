<?php

namespace common\models\master\country\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\country\MasterCountry;


class MasterCountryForm extends model
{
    public $country_name;
    public $status;
    public $status_option = [];
    public $country_model;


    public function __construct(MasterCountry $country_model = null)
    {

        $this->country_model = Yii::createObject([
            'class' => MasterCountry::className()
        ]);

        if ($country_model  != '') {
            $this->country_model = $country_model;
            $this->country_name = $this->country_model->country_name;
            $this->status = $this->country_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_name'], 'required'],
            [['status'], 'integer'],
            [['country_name'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'country_name' => 'Country',
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
        $this->country_model->country_name = $this->country_name;
        $this->country_model->status = $this->status;
    }
}
