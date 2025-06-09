<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\ParkStayCategory;

class ParkStayCategoryForm extends model
{
    public $safari_park_id;
    public $park_stay_categories;

    public $status;
    public $status_option = [];

    public $park_stay_category_model;


    public function __construct($park_stay_category_model = null)
    {

        $this->park_stay_category_model = Yii::createObject([
            'class' => ParkStayCategory::className()
        ]);



        if ($park_stay_category_model  != null) {
            $this->park_stay_category_model = $park_stay_category_model;
            $this->safari_park_id = $this->park_stay_category_model->safari_park_id;
            // $this->park_stay_categories = $this->park_stay_category_model->park_stay_categories;
            $this->status = $this->park_stay_category_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['safari_park_id', 'park_stay_categories'], 'required'],
            [['safari_park_id', 'status'], 'integer'],
            // [['park_stay_categories'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_park_id' => 'Safari Park ID',
            'park_stay_categories' => 'Park Accomodation Categories',
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
        $this->park_stay_category_model->safari_park_id = $this->safari_park_id;
        $this->park_stay_category_model->status = $this->status;
    }
}
