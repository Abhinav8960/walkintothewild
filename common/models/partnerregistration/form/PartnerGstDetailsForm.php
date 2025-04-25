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
    public $status;
    public $gstdetail_model;

    public function __construct(PartnerGstDetails $gstdetail_model = null)
    {
        $this->gstdetail_model = Yii::createObject([
            'class' => PartnerGstDetails::className()
        ]);

        if ($gstdetail_model !== null) {
            $this->gstdetail_model = $gstdetail_model;
            $this->id = $this->gstdetail_model->id;
            $this->state = $this->gstdetail_model->state;
            $this->gst_number = $this->gstdetail_model->gst_number;
            $this->filepath = $this->gstdetail_model->filepath;
            $this->status = $this->gst_model->status;
        }
    }

    public function rules()
    {
        return [
            [['gst_number', 'filepath', 'state'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['gst_number', 'status', 'state'], 'integer'],
            [['filepath'], 'string', 'max' => 255],
            [['filepath'], 'file', 'extensions' => ['jpg', 'jpeg', 'pdf', 'doc', 'png', 'webp'], 'maxSize' => 5 * 1024 * 1024],

        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gst_number' => 'Gst Number',
            'filepath' => 'Filepath',
            'status' => 'Status',
            'state' => 'State',

        ];
    }

    public function initializeForm()
    {

        $this->gstdetail_model->state = $this->state;
        $this->gstdetail_model->gst_number = $this->gst_number;
        $this->gstdetail_model->filepath = $this->filepath;
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

        $file = UploadedFile::getInstance($this, 'filepath');

        if ($file) {
            $fileName = 'filepath' . '_' . time() . '.' . $file->extension;
            $filePath = $userFolder . '/' . $fileName;

            if ($file->saveAs($filePath)) {
                $this->gstdetail_model->filepath = $filePath;
            } else {
                Yii::error("Failed to save file: $fileName", __METHOD__);
            }
        }

        if (!$this->gstdetail_model->save(false)) {
            Yii::error("Failed to save operator model with uploaded file paths.", __METHOD__);
        }
    }
}
