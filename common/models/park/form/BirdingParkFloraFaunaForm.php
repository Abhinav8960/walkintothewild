<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\BirdingParkFloraFauna;

/**
 * Update and Create Flora Fauna
 */
class BirdingParkFloraFaunaForm extends model
{
    public $birding_park_id;
    public $title;
    public $description;
    public $sequence;

    public $status;
    public $status_option = [];
    public $birding_park_florafauna_model;


    public function __construct(BirdingParkFloraFauna $birding_park_florafauna_model = null)
    {

        $this->birding_park_florafauna_model = Yii::createObject([
            'class' => BirdingParkFloraFauna::className()
        ]);



        if ($birding_park_florafauna_model  != '') {
            $this->birding_park_florafauna_model = $birding_park_florafauna_model;
            $this->birding_park_id = $this->birding_park_florafauna_model->birding_park_id;
            $this->title = $this->birding_park_florafauna_model->title;
            $this->description = $this->birding_park_florafauna_model->description;
            $this->status = $this->birding_park_florafauna_model->status;
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
            ['description', \common\validators\Word500Validator::className()],
            [['status'], 'default', 'value' => 1],
            [['title', 'birding_park_id'], 'safe'],
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
        $this->birding_park_florafauna_model->title = $this->title;
        $this->birding_park_florafauna_model->birding_park_id = $this->birding_park_id;
        $this->birding_park_florafauna_model->description = $this->description;
        $this->birding_park_florafauna_model->status = $this->status;
    }
}
