<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\BirdingParkAnimal;

/**
 * Update and Create Holiday
 */
class BirdingParkAnimalForm extends model
{
    public $birding_park_id;
    public $master_animal_id;
    public $animal_name;

    public $status;
    public $status_option = [];
    public $birding_park_animal_model;


    public function __construct(BirdingParkAnimal $birding_park_animal_model = null)
    {

        $this->birding_park_animal_model = Yii::createObject([
            'class' => BirdingParkAnimal::className()
        ]);



        if ($birding_park_animal_model  != '') {
            $this->birding_park_animal_model = $birding_park_animal_model;
            $this->birding_park_id = $this->birding_park_animal_model->birding_park_id;
            $this->master_animal_id = $this->birding_park_animal_model->master_animal_id;
            $this->animal_name = $this->birding_park_animal_model->animal_name;
            $this->status = $this->birding_park_animal_model->status;
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
            [['master_animal_id', 'birding_park_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'birding_park_id' => 'Safari Park',
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
        $this->birding_park_animal_model->birding_park_id = $this->birding_park_id;
        $this->birding_park_animal_model->master_animal_id = $this->master_animal_id;
        if ($this->master_animal_id) {
            $this->birding_park_animal_model->animal_name =  GeneralModel::animaloption()[$this->master_animal_id];
        }
        $this->birding_park_animal_model->status = $this->status;
    }
}
