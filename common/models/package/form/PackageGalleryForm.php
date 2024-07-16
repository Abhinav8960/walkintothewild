<?php

namespace common\models\package\form;

use Yii;
use common\models\package\PackageGallery;

class PackageGalleryForm extends \yii\base\Model
{
    public $package_id;
    public $image_caption;
    public $image;
    public $sequence;
    public $status;
    public $package_gallery_model;
    public $action_url;
    public $action_validate_url;


    /**
     * @param [type] $package_gallery_model
     */
    public function __construct(PackageGallery $package_gallery_model = null)
    {
        $this->package_gallery_model = Yii::createObject([
            'class' => PackageGallery::className()
        ]);
        if ($package_gallery_model != null) {
            $this->package_gallery_model = $package_gallery_model;
            $this->package_id = $this->package_gallery_model->package_id;
            $this->image_caption = $this->package_gallery_model->image_caption;
            $this->image = $this->package_gallery_model->image;
            $this->sequence = $this->package_gallery_model->sequence;
            $this->status = $this->package_gallery_model->status;
        }
    }

    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['sequence'], 'default', 'value' => 0],
            [['package_id', 'image_caption'], 'required'],
            [['package_id', 'sequence', 'status'], 'integer'],
            [['image'], 'safe'],
            [['image_caption'], 'string', 'max' => 512],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_caption' => 'Image Caption',
            'image' => 'Image',
            'position' => 'Position',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->package_gallery_model->package_id = $this->package_id;
        $this->package_gallery_model->image_caption = $this->image_caption;
        $this->package_gallery_model->sequence = $this->sequence;
        $this->package_gallery_model->status = $this->status;
    }


    /**
     * Upload Banner image
     *
     * @return void
     */
    public function UploadFile()
    {
        if ($this->image) {
            $storagePath = Yii::$app->params['datapath'] . '/package_gallery';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->package_gallery_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'image' . '-' . time() . '.' . $this->image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->image->saveAs($filePath)) {
                $this->package_gallery_model->image = $fileName;
                $this->package_gallery_model->save(false);
            }
        }
    }
}
