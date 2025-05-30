<?php

namespace common\models\partnergalleryimage\form;

use common\Helper\FsHelper;
use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\partnergalleryimage\PartnerGalleryImage;

class PartnerGalleryImageForm extends model
{
    public $partner_gallery_id;
    public $file;
    public $title;
    public $caption;
    public $created_at;
    public $status;

    public $partner_gallery_image_model;

    public $status_option = [];
    public $sequence;
    public $set_as_thumbnail;

    public function __construct(PartnerGalleryImage $partner_gallery_image_model = null)
    {

        $this->partner_gallery_image_model = Yii::createObject([
            'class' => PartnerGalleryImage::className()
        ]);



        if ($partner_gallery_image_model  != '') {
            $this->partner_gallery_image_model = $partner_gallery_image_model;
            $this->partner_gallery_id = $this->partner_gallery_image_model->partner_gallery_id;
            $this->title = $this->partner_gallery_image_model->title;
            $this->caption = $this->partner_gallery_image_model->caption;
            $this->created_at = $this->partner_gallery_image_model->created_at;
            $this->status = $this->partner_gallery_image_model->status;
            $this->sequence = $this->partner_gallery_image_model->sequence;
            $this->set_as_thumbnail = $this->partner_gallery_image_model->set_as_thumbnail;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['partner_gallery_id', 'status', 'created_at','sequence','set_as_thumbnail'], 'integer'],
            [['caption'], 'string'],
            [['title'], 'string', 'max' => 255],
            [
                ['file'],
                'file',
                'extensions' => ['jpg', 'jpeg', 'png'],
                'maxSize' => 8 * 1024 * 1024,
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
            'partner_gallery_id' => 'Partner Gallery ID',
            'original_filename' => 'Original Filename',
            'filepath' => 'Filepath',
            'file' => 'File',
            'title' => 'Title',
            'caption' => 'Caption',
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
        $this->partner_gallery_image_model->title = $this->title;
        $this->partner_gallery_image_model->partner_gallery_id = $this->partner_gallery_id;
        $this->partner_gallery_image_model->title = $this->title;
        $this->partner_gallery_image_model->caption = $this->caption;
        $this->partner_gallery_image_model->status = $this->status;
        $this->partner_gallery_image_model->sequence = $this->sequence;
        $this->partner_gallery_image_model->set_as_thumbnail = $this->set_as_thumbnail;
    }

    public function uploadFile()
    {

        if ($this->file) {
            $storagePath = 'partner_gallery' . '/' . date('ym', $this->created_at) . '/' . $this->partner_gallery_id;
            $fileName = $this->partner_gallery_image_model->id . '_' . time() . '.' . $this->file->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($fileName) {
                if ($etag =  FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
                    $this->partner_gallery_image_model->file = $fileName;
                    $this->partner_gallery_image_model->filepath = $filePath;
                    $this->partner_gallery_image_model->original_filename = $this->file->name;
                    $this->partner_gallery_image_model->save(false);
                }
            }
        }
    }
}
