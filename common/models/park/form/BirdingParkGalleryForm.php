<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\BirdingParkGallery;

/**
 * Update and Create Holiday
 */
class BirdingParkGalleryForm extends model
{
    public $birding_park_id;
    public $image;
    public $image_caption;
    public $sequence;

    public $status;
    public $status_option = [];
    public $birding_park_gallery_model;


    public function __construct(BirdingParkGallery $birding_park_gallery_model = null)
    {

        $this->birding_park_gallery_model = Yii::createObject([
            'class' => BirdingParkGallery::className()
        ]);



        if ($birding_park_gallery_model  != '') {
            $this->birding_park_gallery_model = $birding_park_gallery_model;
            $this->birding_park_id = $this->birding_park_gallery_model->birding_park_id;
            $this->image = $this->birding_park_gallery_model->image;
            $this->image_caption = $this->birding_park_gallery_model->image_caption;
            $this->sequence = $this->birding_park_gallery_model->sequence;
            $this->status = $this->birding_park_gallery_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_caption', 'image'], 'required', 'on' => 'create'],
            [['image_caption'], 'required', 'on' => 'update'],
            [['status'], 'integer'],
            [['image_caption'], 'string', 'max' => 125],
            [['status'], 'default', 'value' => 1],
            [['image', 'sequence', 'birding_park_id'], 'safe'],
            // [
            //     ['image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
            //     'minWidth' => 75,
            //     'maxWidth' => 75,
            //     'maxHeight' => 75,
            //     'minHeight' => 75,
            //     'maxSize' => 100 * 1024
            // ],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['image_caption', 'image', 'status', 'birding_park_id'];
        $scenarios['update'] = ['image_caption', 'image', 'status', 'birding_park_id'];


        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image_caption' => 'Image Caption *',
            'image' => 'Image  (JPEG /JPG or PNG / 75 Pixels x 75 Pixels / 150 KB) *',
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
        // $this->birding_park_gallery_model->image = $this->image;
        $this->birding_park_gallery_model->birding_park_id = $this->birding_park_id;
        $this->birding_park_gallery_model->image_caption = $this->image_caption;
        $this->birding_park_gallery_model->status = $this->status;
    }


    public function uploadFile()
    {
        if ($this->image) {
            $storagePath = Yii::$app->params['datapath'] . '/birdingparkgallery';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->birding_park_gallery_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'gallery' . time() . '.' . $this->image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->image->saveAs($filePath)) {
                $this->birding_park_gallery_model->image = $fileName;
                $this->birding_park_gallery_model->save(false);
            }
        }
    }
}
