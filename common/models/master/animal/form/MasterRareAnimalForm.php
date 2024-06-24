<?php

namespace common\models\master\animal\form;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\GeneralModel;
use common\models\park\SafariParkRareAnimal;
use common\models\master\animal\MasterAnimal;
use common\models\master\animal\MasterRareAnimal;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Rare Animal
 */
class MasterRareAnimalForm extends model
{
    public $animal_name;
    public $know_as;
    public $short_description;
    public $feature_image;
    public $banner;
    public $status;
    public $status_option = [];
    public $rare_animal_model;
    public $assigned_park;

    public function __construct(MasterRareAnimal $rare_animal_model = null)
    {

        $this->rare_animal_model = Yii::createObject([
            'class' => MasterRareAnimal::className()
        ]);



        if ($rare_animal_model  != '') {
            $this->rare_animal_model = $rare_animal_model;
            $this->feature_image = $this->rare_animal_model->feature_image;
            $this->banner = $this->rare_animal_model->banner;
            $this->know_as = $this->rare_animal_model->know_as;
            $this->animal_name = $this->rare_animal_model->animal_name;
            $this->short_description = $this->rare_animal_model->short_description;
            $this->status = $this->rare_animal_model->status;

            $this->assigned_park = SafariParkRareAnimal::find()->select('safari_park_id')->where(['master_rare_animal_id' => $this->rare_animal_model->id, 'status' => 1])->column();
        }

        $this->status_option = GeneralModel::statusoption();
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = [
            'animal_name', 'short_description', 'feature_image', 'banner', 'status',
            'know_as', 'assigned_park'
        ];
        $scenarios['update'] = [
            'animal_name', 'short_description', 'status',
            'know_as', 'feature_image', 'banner', 'assigned_park'
        ];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['animal_name', 'short_description'], 'required'],
            [['status'], 'integer'],
            ['assigned_park', 'safe'],
            [['animal_name'], 'string', 'max' => 125],
            [['animal_name', 'know_as'], 'string', 'max' => 125],
            [['short_description'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [
                ['feature_image',], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 285,
                'maxWidth' => 285,
                'maxHeight' => 285,
                'minHeight' => 285,
                'maxSize' => 250 * 1024
            ],
            [
                ['banner',], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 1920,
                'maxWidth' => 1920,
                'maxHeight' => 220,
                'minHeight' => 220,
                'maxSize' => 250 * 1024
            ],
            [
                ['animal_name'], 'unique', 'targetClass' => MasterRareAnimal::className(), 'message' => 'This animal name has already been taken.',
                'filter' => function ($query) {
                    if (!$this->rare_animal_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->rare_animal_model->id]]);
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
            'animal_name' => 'Animal Name',
            'banner' => 'Banner',
            'feature_image' => 'Feature Image',
            'know_as' => 'Know As',
            'short_description' => 'Short Description',
            'status' => 'Status',
            'assigned_park' => 'Assigned Park',
        ];
    }
    /**
     * Initial Form Values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->rare_animal_model->know_as = $this->know_as;
        $this->rare_animal_model->animal_name = $this->animal_name;
        $this->rare_animal_model->short_description = $this->short_description;
        $this->rare_animal_model->status = $this->status;
    }


    /**
     * Assigned Park
     */
    public function assignedpark()
    {
        SafariParkRareAnimal::updateAll(['status' => 2], ['master_rare_animal_id' => $this->rare_animal_model->id]);
        $assigned_park = $this->assigned_park;
        if ($assigned_park) {
            foreach ($assigned_park as $park_id) {
                $parkrareAnimal = new SafariParkRareAnimal();
                $parkrareAnimal->safari_park_id = $park_id;
                $parkrareAnimal->master_rare_animal_id = $this->rare_animal_model->id;
                $parkrareAnimal->animal_name =  $this->rare_animal_model->animal_name;
                $parkrareAnimal->status = 1;
                $parkrareAnimal->save(false);
            }
        }
    }


    public function uploadFile()
    {

        if ($this->banner) {
            // dd($this->banner);
            $storagePath = Yii::$app->params['datapath'] . '/rareanimal';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->rare_animal_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'rareanimal' . '-' . time() . '.' . $this->banner->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->banner->saveAs($filePath)) {
                $this->rare_animal_model->banner = $fileName;
                $this->rare_animal_model->save(false);
            }
        }

        if ($this->feature_image) {
            // dd($this->feature_image);

            $storagePath = Yii::$app->params['datapath'] . '/rareanimal';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->rare_animal_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'rareanimal' . time() . '.' . $this->feature_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->feature_image->saveAs($filePath)) {
                $this->rare_animal_model->feature_image = $fileName;
                $this->rare_animal_model->save(false);
            }
        }
    }
}
