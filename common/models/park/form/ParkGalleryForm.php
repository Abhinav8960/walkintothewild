<?php

namespace common\models\park\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\park\ParkGallery;

/**
 * Update and Create Holiday
 */
class ParkGalleryForm extends model
{
    public $park_id;
    public $image;
    public $image_caption;
    public $sequence;

    public $status;
    public $status_option = [];
    public $park_gallery_model;


    public function __construct(ParkGallery $park_gallery_model = null)
    {

        $this->park_gallery_model = Yii::createObject([
            'class' => ParkGallery::className()
        ]);



        if ($park_gallery_model  != '') {
            $this->park_gallery_model = $park_gallery_model;
            $this->park_id = $this->park_gallery_model->park_id;
            $this->image = $this->park_gallery_model->image;
            $this->image_caption = $this->park_gallery_model->image_caption;
            $this->sequence = $this->park_gallery_model->sequence;
            $this->status = $this->park_gallery_model->status;
        }

        $this->status_option = GeneralModel::statusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['image_caption', 'image'], 'required'],
            [['status'], 'integer'],
            [['image_caption'], 'string', 'max' => 125],
            [['status'], 'default', 'value' => 1],
            [['image', 'sequence'], 'safe'],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image_caption' => 'Image Caption',
            'image' => 'Image  (JPEG /JPG or PNG / 75 Pixels x 75 Pixels / 150 KB)',
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
        // $this->park_gallery_model->icon = $this->icon;
        $this->park_gallery_model->image_caption = $this->image_caption;
        $this->park_gallery_model->status = $this->status;
    }


    public function uploadFile()
    {
        if ($this->icon) {
            $storagePath = Yii::$app->params['datapath'] . '/parkgallery';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->park_gallery_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'vehicle' . time() . '.' . $this->icon->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->icon->saveAs($filePath)) {
                $this->park_gallery_model->icon = $fileName;
                $this->park_gallery_model->save(false);
            }
        }
    }
}
