<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\SafariParkAnimal;

/**
 * Update and Create Holiday
 */
class SafariParkAnimalForm extends model
{
    public $safari_park_id;
    public $master_animal_id;
    public $animal_name;

    public $status;
    public $status_option = [];
    public $safari_park_animal_model;


    public function __construct(SafariParkAnimal $safari_park_animal_model = null)
    {

        $this->safari_park_animal_model = Yii::createObject([
            'class' => SafariParkAnimal::className()
        ]);



        if ($safari_park_animal_model  != '') {
            $this->safari_park_animal_model = $safari_park_animal_model;
            $this->safari_park_id = $this->safari_park_animal_model->safari_park_id;
            $this->master_animal_id = $this->safari_park_animal_model->master_animal_id;
            $this->animal_name = $this->safari_park_animal_model->animal_name;
            $this->status = $this->safari_park_animal_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_animal_id'], 'required'],
            [['status'], 'integer'],
            [['animal_name'], 'string', 'max' => 125],
            [['status'], 'default', 'value' => 1],
            [['master_animal_id', 'safari_park_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'safari_park_id' => 'Safari Park',
            'master_animal_id' => 'Master Animals',
            'animal_name' => 'Animal Name',
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
        $this->safari_park_animal_model->safari_park_id = $this->safari_park_id;
        $this->safari_park_animal_model->master_animal_id = $this->master_animal_id;
        if ($this->master_animal_id) {
            $this->safari_park_animal_model->animal_name =  GeneralModel::animaloption()[$this->master_animal_id];
        }
        $this->safari_park_animal_model->status = $this->status;
    }
}
