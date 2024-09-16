<?php

namespace common\models\sharesafari\form;

use Yii;
use common\models\sharesafari\ShareSafariGallery;

class ShareSafariGalleryForm extends \yii\base\Model
{
    public $share_safari_id;
    public $image_caption;
    public $image;
    public $sequence;
    public $status;
    public $share_safari_gallery_model;
    public $action_url;
    public $action_validate_url;


    /**
     * @param [type] $share_safari_gallery_model
     */
    public function __construct(ShareSafariGallery $share_safari_gallery_model = null)
    {
        $this->share_safari_gallery_model = Yii::createObject([
            'class' => ShareSafariGallery::className()
        ]);
        if ($share_safari_gallery_model != null) {
            $this->share_safari_gallery_model = $share_safari_gallery_model;
            $this->share_safari_id = $this->share_safari_gallery_model->share_safari_id;
            $this->image_caption = $this->share_safari_gallery_model->image_caption;
            $this->image = $this->share_safari_gallery_model->image;
            $this->sequence = $this->share_safari_gallery_model->sequence;
            $this->status = $this->share_safari_gallery_model->status;
        }
    }

    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 1],
            [['sequence'], 'default', 'value' => 0],
            [['share_safari_id', 'image_caption'], 'required'],
            [['share_safari_id', 'sequence', 'status'], 'integer'],
            [['image'], 'safe'],
            [['image_caption'], 'string', 'max' => 512],
            [
                ['image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                // 'minWidth' => 940,
                // 'maxWidth' => 940,
                // 'maxHeight' => 430,
                // 'minHeight' => 430,
                // 'maxSize' => 250 * 1024,
                // 'skipOnEmpty' => true,
            ],
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
        $this->share_safari_gallery_model->share_safari_id = $this->share_safari_id;
        $this->share_safari_gallery_model->image_caption = $this->image_caption;
        $this->share_safari_gallery_model->sequence = $this->sequence;
        $this->share_safari_gallery_model->status = $this->status;
    }


    /**
     * Upload Banner image
     *
     * @return void
     */
    public function UploadFile()
    {
        if ($this->image) {
            $storagePath = Yii::$app->params['datapath'] . '/share_safari/gallery';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->share_safari_gallery_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'image' . '-' . time() . '.' . $this->image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->image->saveAs($filePath)) {
                $this->share_safari_gallery_model->image = $fileName;
                $this->share_safari_gallery_model->save(false);
            }
        }
    }
}
