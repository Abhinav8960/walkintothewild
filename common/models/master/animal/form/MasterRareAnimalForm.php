<?php

namespace common\models\master\animal\form;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\GeneralModel;
use common\models\park\SafariParkAnimal;
use common\models\master\animal\MasterAnimal;

/**
 * @author Smriti Pal <smritipal2201@gmial.com>
 * 
 * Update and Create Rare Animal
 */
class MasterRareAnimalForm extends model
{
    public $name;
    public $know_as;
    public $short_description;
    public $feature_image;
    public $banner;
    public $status;
    public $status_option = [];
    public $rare_animal_model;
    public $assigned_park;
    public $animal_type;
    public $is_searchable;
    public $created_at;

    public function __construct(MasterAnimal $rare_animal_model = null)
    {

        $this->rare_animal_model = Yii::createObject([
            'class' => MasterAnimal::className()
        ]);



        if ($rare_animal_model  != '') {
            $this->rare_animal_model = $rare_animal_model;
            $this->animal_type = $this->rare_animal_model->animal_type;
            $this->feature_image = $this->rare_animal_model->feature_image;
            $this->banner = $this->rare_animal_model->banner;
            $this->know_as = $this->rare_animal_model->know_as;
            $this->name = $this->rare_animal_model->name;
            $this->short_description = $this->rare_animal_model->short_description;
            $this->is_searchable = $this->rare_animal_model->is_searchable;
            $this->status = $this->rare_animal_model->status;
            $this->created_at = $this->rare_animal_model->created_at;

            $this->assigned_park = SafariParkAnimal::find()->select('safari_park_id')->where(['master_animal_id' => $this->rare_animal_model->id, 'status' => 1])->column();
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = [
            'name',
            'short_description',
            'feature_image',
            'banner',
            'status',
            'know_as',
            'assigned_park',
            'is_searchable',
        ];
        $scenarios['update'] = [
            'name',
            'short_description',
            'status',
            'know_as',
            'feature_image',
            'banner',
            'assigned_park',
            'is_searchable',
        ];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['name', 'short_description'], 'required'],
            [['status', 'is_searchable'], 'integer'],
            ['assigned_park', 'safe'],
            [['name'], 'string', 'max' => 125],
            [['name', 'know_as'], 'string', 'max' => 125],
            [['short_description'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => 1],
            [['animal_type'], 'safe'],
            [
                ['feature_image',],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 285,
                'maxWidth' => 285,
                'maxHeight' => 285,
                'minHeight' => 285,
                'maxSize' => 250 * 1024
            ],
            [
                ['banner',],
                'image',
                'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 1920,
                'maxWidth' => 1920,
                'maxHeight' => 220,
                'minHeight' => 220,
                'maxSize' => 250 * 1024
            ],
            [
                ['name'],
                'unique',
                'targetClass' => MasterAnimal::className(),
                'message' => 'This animal name has already been taken.',
                'filter' => function ($query) {
                    if (!$this->rare_animal_model->isNewRecord) {
                        $query->andWhere(['not', ['id' => $this->rare_animal_model->id]]);
                    }
                }
            ],
            [['created_at'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Animal Name',
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
        $this->rare_animal_model->animal_type = $this->animal_type;
        $this->rare_animal_model->know_as = $this->know_as;
        $this->rare_animal_model->name = $this->name;
        $this->rare_animal_model->short_description = $this->short_description;
        $this->rare_animal_model->is_searchable = $this->is_searchable;
        $this->rare_animal_model->status = $this->status;
    }


    /**
     * Assigned Park
     */
    public function assignedpark()
    {
        SafariParkAnimal::updateAll(['status' => SafariParkAnimal::STATUS_SUSPEND], ['master_animal_id' => $this->rare_animal_model->id]);
        $assigned_park = $this->assigned_park;
        if ($assigned_park) {
            foreach ($assigned_park as $park_id) {
                $parkrareAnimal = new SafariParkAnimal();
                $parkrareAnimal->safari_park_id = $park_id;
                $parkrareAnimal->master_animal_id = $this->rare_animal_model->id;
                $parkrareAnimal->status = 1;
                $parkrareAnimal->save(false);
            }
        }
    }


    public function uploadFile()
    {

        // if ($this->banner) {
        //     // dd($this->banner);
        //     $storagePath = Yii::$app->params['datapath'] . '/rareanimal';

        //     if (!file_exists($storagePath)) {
        //         mkdir($storagePath);
        //         chmod($storagePath, 0777);
        //     }
        //     $storagePath = $storagePath . '/' . $this->rare_animal_model->id;
        //     if (!file_exists($storagePath)) {
        //         mkdir($storagePath);
        //         chmod($storagePath, 0777);
        //     }

        //     $fileName = 'rareanimal' . '-' . time() . '.' . $this->banner->extension;
        //     $filePath = $storagePath . '/' . $fileName;

        //     if ($this->banner->saveAs($filePath)) {
        //         $this->rare_animal_model->banner = $fileName;
        //         $this->rare_animal_model->save(false);
        //     }
        // }

        // if ($this->feature_image) {
        //     // dd($this->feature_image);

        //     $storagePath = Yii::$app->params['datapath'] . '/rareanimal';

        //     if (!file_exists($storagePath)) {
        //         mkdir($storagePath);
        //         chmod($storagePath, 0777);
        //     }
        //     $storagePath = $storagePath . '/' . $this->rare_animal_model->id;
        //     if (!file_exists($storagePath)) {
        //         mkdir($storagePath);
        //         chmod($storagePath, 0777);
        //     }

        //     $fileName = 'rareanimal' . time() . '.' . $this->feature_image->extension;
        //     $filePath = $storagePath . '/' . $fileName;

        //     if ($this->feature_image->saveAs($filePath)) {
        //         $this->rare_animal_model->feature_image = $fileName;
        //         $this->rare_animal_model->save(false);
        //     }
        // }
        // __________________________________________Move To S3 (9 June 2025)___________________________________________
        if ($this->banner) {
            $storagePath = 'rareanimal' . '/' . date('ym', $this->created_at);
            $fileName = $this->rare_animal_model->id . '_rareanimal_banner_' . time() . '.' . $this->banner->extension;

            $filePath = $storagePath . '/' . $fileName;

            if ($fileName) {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->banner, $filePath, $fileName, true)) {
                    $this->rare_animal_model->banner = $fileName;
                    $this->rare_animal_model->banner_path = $filePath;
                    $this->rare_animal_model->original_banner_name = $this->banner->name;
                    $this->rare_animal_model->save(false);
                }
            }
        }

        if ($this->feature_image) {
            $storagePath = 'rareanimal' . '/' . date('ym', $this->created_at);
            $fileName = $this->rare_animal_model->id . '_rareanimal_feature_' . time() . '.' . $this->feature_image->extension;

            $filePath = $storagePath . '/' . $fileName;

            if ($fileName) {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->feature_image, $filePath, $fileName, true)) {
                    $this->rare_animal_model->feature_image = $fileName;
                    $this->rare_animal_model->feature_image_path = $filePath;
                    $this->rare_animal_model->original_feature_image_name = $this->feature_image->name;
                    $this->rare_animal_model->save(false);
                }
            }
        }
    }
}
