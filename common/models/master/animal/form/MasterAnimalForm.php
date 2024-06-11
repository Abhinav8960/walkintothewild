<?php

namespace common\models\master\animal\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\master\animal\MasterAnimal;
use yii\web\UploadedFile;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Holiday
 */
class MasterAnimalForm extends model
{
    public $slug;
    public $name;
    public $short_description;
    public $is_filter;
    public $status;
    public $status_option = [];
    public $animal_model;


    public function __construct(MasterAnimal $animal_model = null)
    {

        $this->animal_model = Yii::createObject([
            'class' => MasterAnimal::className()
        ]);



        if ($animal_model  != '') {
            $this->animal_model = $animal_model;
            $this->slug = $this->animal_model->slug;
            $this->name = $this->animal_model->name;
            $this->short_description = $this->animal_model->short_description;
            $this->status = $this->animal_model->status;
            $this->is_filter = $this->animal_model->is_filter;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = [
            'name', 'short_description', 'status', 'slug',
            'is_filter'
        ];
        $scenarios['update'] = [
            'name', 'short_description', 'status', 'slug',
            'is_filter'
        ];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['name', 'short_description', 'is_filter'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 125],
            [['name', 'slug'], 'string', 'max' => 125],
            [['short_description'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [
                ['name'], 'unique', 'targetClass' => MasterAnimal::className(), 'message' => 'This name has already been taken.',
                'filter' => function ($query) {
                    if (!$this->animal_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->animal_model->id]]);
                    }
                }
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'is_filter' => 'Is Filter',
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
        $this->animal_model->slug = $this->slug;
        $this->animal_model->name = $this->name;
        $this->animal_model->short_description = $this->short_description;
        $this->animal_model->status = $this->status;
        $this->animal_model->is_filter = $this->is_filter;
    }
}
