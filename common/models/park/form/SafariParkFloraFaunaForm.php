<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\SafariParkFloraFauna;

/**
 * Update and Create Flora Fauna
 */
class SafariParkFloraFaunaForm extends model
{
    public $safari_park_id;
    public $title;
    public $description;
    public $sequence;

    public $status;
    public $status_option = [];
    public $safari_park_florafauna_model;


    public function __construct(SafariParkFloraFauna $safari_park_florafauna_model = null)
    {

        $this->safari_park_florafauna_model = Yii::createObject([
            'class' => SafariParkFloraFauna::className()
        ]);



        if ($safari_park_florafauna_model  != '') {
            $this->safari_park_florafauna_model = $safari_park_florafauna_model;
            $this->safari_park_id = $this->safari_park_florafauna_model->safari_park_id;
            $this->title = $this->safari_park_florafauna_model->title;
            $this->description = $this->safari_park_florafauna_model->description;
            $this->status = $this->safari_park_florafauna_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'title'], 'required'],
            [['status'], 'integer'],
            ['description', \common\validators\Word120Validator::className()],
            [['status'], 'default', 'value' => 1],
            [['title', 'safari_park_id'], 'safe'],
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'description' => 'Description',
            'title' => 'Title ',
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
        $this->safari_park_florafauna_model->title = $this->title;
        $this->safari_park_florafauna_model->safari_park_id = $this->safari_park_id;
        $this->safari_park_florafauna_model->description = $this->description;
        $this->safari_park_florafauna_model->status = $this->status;
    }
}
