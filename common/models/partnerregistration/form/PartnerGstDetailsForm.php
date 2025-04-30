<?php

namespace common\models\partnerregistration\form;

use common\models\partnerregistration\PartnerGstDetails;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class PartnerGstDetailsForm extends Model
{
    public $id;
    public $state;
    public $gst_number;
    public $filepath;
    public $filepath_upload;
    public $status;
    public $gstdetail_model;
    public $isNew = true;

    public function __construct(PartnerGstDetails $gstdetail_model = null)
    {
        $this->gstdetail_model = Yii::createObject([
            'class' => PartnerGstDetails::className()
        ]);

        if ($gstdetail_model !== null) {
            $this->isNew = false;
            $this->gstdetail_model = $gstdetail_model;
            $this->id = $gstdetail_model->id;
            $this->state = $gstdetail_model->state;
            $this->gst_number = $gstdetail_model->gst_number;
            $this->filepath = $gstdetail_model->filepath;
            $this->status = $gstdetail_model->status;
        }
    }

    public function rules()
    {
        return [
            [['gst_number', 'state'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['status', 'state'], 'integer'],
            [['gst_number'], 'string', 'max' => 50],
            [
                'filepath_upload',
                'required',
                'when' => function ($model) {
                    return empty($model->filepath);
                },
                'whenClient' => 'function (attribute, value) {
                    return $("#filepath").val() === "";
                }',
            ],
            [['filepath_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'pdf', 'doc', 'png', 'webp'], 'maxSize' => 5 * 1024 * 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gst_number' => 'GST Number',
            'filepath' => 'File',
            'status' => 'Status',
            'state' => 'State',
        ];
    }

    public function initializeForm()
    {
        $this->gstdetail_model->state = $this->state;
        $this->gstdetail_model->gst_number = $this->gst_number;
        $this->gstdetail_model->filepath = $this->filepath;
        $this->gstdetail_model->status = $this->status;
    }

    public function uploadFiles()
    {
        $basePath = Yii::$app->params['datapath'] . '/Uploads';
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $userFolder = $basePath . '/' . $this->gstdetail_model->id;
        if (!file_exists($userFolder)) {
            mkdir($userFolder, 0777, true);
        }
       
        if ($this->filepath_upload) {
            $fileName = 'filepath_upload'. '_' . time() . '.' . $this->filepath_upload->extension;
            $filePath = $userFolder . '/' . $fileName;
            if ($this->filepath_upload->saveAs($filePath)) {
                $this->filepath_upload = $filePath;
                $this->gstdetail_model->filepath = $filePath;
            } else {
                Yii::error("Failed to save file: $fileName", __METHOD__);
            }
        }

        if (!$this->gstdetail_model->save(false)) {
            Yii::error("Failed to save GST model after uploading file.", __METHOD__);
        }
    }
}
