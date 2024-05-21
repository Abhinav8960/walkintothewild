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
    public $know_as;
    public $short_description;
    public $long_description;
    public $image;
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
            $this->image = $this->animal_model->image;
            $this->slug = $this->animal_model->slug;
            $this->know_as = $this->animal_model->know_as;
            $this->name = $this->animal_model->name;
            $this->short_description = $this->animal_model->short_description;
            $this->long_description = $this->animal_model->long_description;
            $this->status = $this->animal_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'short_description'], 'required'],
            [['status'], 'integer'],
            [['name', 'slug', 'know_as'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 512],
            [['status'], 'default', 'value' => 1],
            [['long_description'], 'safe'],
            [
                ['image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 556,
                'maxWidth' => 556,
                'maxHeight' => 386,
                'minHeight' => 386,
                'maxSize' => 100 * 1024
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
            'image' => 'Image  (JPEG /JPG or PNG / 400 Pixels x 400 Pixels / 150 KB)',
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
        $this->animal_model->know_as = $this->know_as;
        $this->animal_model->name = $this->name;
        $this->animal_model->short_description = $this->short_description;
        $this->animal_model->long_description = $this->long_description;
        $this->animal_model->status = $this->status;
    }


    public function uploadFile()
    {
        if ($this->image) {
            $storagePath = Yii::$app->params['datapath'] . '/animal';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->animal_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'animal' . time() . '.' . $this->image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->image->saveAs($filePath)) {
                $this->animal_model->image = $fileName;
                $this->animal_model->save(false);
            }
        }
    }
}
