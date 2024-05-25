<?php

namespace common\models\master\location\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\location\MasterLocation;

class MasterLocationForm extends model
{
    public $title;
    public $status;
    public $status_option = [];
    public $location_model;


    public function __construct(MasterLocation $location_model = null)
    {

        $this->location_model = Yii::createObject([
            'class' => MasterLocation::className()
        ]);



        if ($location_model  != '') {
            $this->location_model = $location_model;
            $this->location_model = $location_model;
            $this->title = $this->location_model->title;
            $this->status = $this->location_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
        $this->location_model->title = $this->title;
        $this->location_model->status = $this->status;
    }
}
