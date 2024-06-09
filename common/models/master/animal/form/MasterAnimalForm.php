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
    public $banner_image;
    public $is_filter;
    public $status;
    public $status_option = [];
    public $animal_type_id;
    public $animal_model;


    public function __construct(MasterAnimal $animal_model = null)
    {

        $this->animal_model = Yii::createObject([
            'class' => MasterAnimal::className()
        ]);



        if ($animal_model  != '') {
            $this->animal_model = $animal_model;
            $this->image = $this->animal_model->image;
            $this->banner_image = $this->animal_model->banner_image;
            $this->slug = $this->animal_model->slug;
            $this->know_as = $this->animal_model->know_as;
            $this->name = $this->animal_model->name;
            $this->short_description = $this->animal_model->short_description;
            $this->long_description = $this->animal_model->long_description;
            $this->status = $this->animal_model->status;
            $this->is_filter = $this->animal_model->is_filter;
            $this->animal_type_id = $this->animal_model->animal_type_id;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = [
            'name', 'short_description', 'animal_type_id', 'image', 'banner_image', 'status', 'slug',
            'know_as', 'long_description', 'is_filter'
        ];
        $scenarios['update'] = [
            'name', 'short_description', 'animal_type_id', 'status', 'slug',
            'know_as', 'long_description', 'is_filter'
        ];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['name', 'short_description', 'animal_type_id', 'is_filter'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 125],
            [['name', 'slug', 'know_as'], 'string', 'max' => 125],
            [['short_description'], 'string', 'max' => 255],
            [['long_description'], 'string', 'max' => 512],
            [['status'], 'default', 'value' => 1],
            [['long_description'], 'safe'],
            [
                ['image',], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 285,
                'maxWidth' => 285,
                'maxHeight' => 285,
                'minHeight' => 285,
                'maxSize' => 250 * 1024
            ],
            [
                ['banner_image',], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 1920,
                'maxWidth' => 1920,
                'maxHeight' => 220,
                'minHeight' => 220,
                'maxSize' => 250 * 1024
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
            'image' => 'Image',
            'is_filter' => 'Is Filter',
            'banner_image' => 'Banner Image',
            'status' => 'Status',
            'animal_type_id' => 'Animal Type'

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
        $this->animal_model->is_filter = $this->is_filter;
        $this->animal_model->animal_type_id = $this->animal_type_id;
    }


    public function uploadFile()
    {

        if ($this->banner_image) {
            // dd($this->banner_image);
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

            $fileName = 'animal' . '-' . time() . '.' . $this->banner_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->banner_image->saveAs($filePath)) {
                $this->animal_model->banner_image = $fileName;
                $this->animal_model->save(false);
            }
        }

        if ($this->image) {
            // dd($this->image);

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
