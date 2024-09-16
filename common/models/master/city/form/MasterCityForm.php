<?php

namespace common\models\master\city\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\city\MasterCity;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Holiday
 */
class MasterCityForm extends model
{
    public $country_id;
    public $state_id;
    public $city_name;
    public $status;
    public $status_option = [];
    public $city_model;
    public $uploadfile;



    public function __construct(MasterCity $city_model = null)
    {

        $this->city_model = Yii::createObject([
            'class' => MasterCity::className()
        ]);



        if ($city_model  != '') {
            $this->city_model = $city_model;
            $this->country_id = $this->city_model->country_id;
            $this->state_id = $this->city_model->state_id;
            $this->city_name = $this->city_model->city_name;
            $this->status = $this->city_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_name', 'state_id', 'country_id'], 'required'],
            [['status'], 'integer'],
            [['city_name', 'state_id', 'country_id'], 'string', 'max' => 125],
            [['status'], 'default', 'value' => 1],
            [['uploadfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
            [
                ['city_name'], 'unique', 'targetClass' => MasterCity::className(), 'targetAttribute' => ['city_name', 'state_id', 'country_id'],  'message' => 'The combination of City Name, State, and Country must be unique.',
                'filter' => function ($query) {
                    if (!$this->city_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->city_model->id]]);
                    }
                }
            ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = ['city_name', 'state_id',  'country_id', 'status'];
        $scenarios['update'] = ['city_name', 'state_id', 'country_id', 'status'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city_name' => 'City',
            'state_id' => 'State',
            'country_id' => 'Country',
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
        $this->city_model->country_id = $this->country_id;
        $this->city_model->state_id = $this->state_id;
        $this->city_model->city_name = $this->city_name;
        $this->city_model->status = $this->status;
    }
}
