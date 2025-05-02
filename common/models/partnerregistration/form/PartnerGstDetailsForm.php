<?php

namespace common\models\partnerregistration\form;

use common\Helper\FsHelper;
use common\models\partnerregistration\PartnerGstDetails;
use common\models\partnerregistration\PartnerRegistration;
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
    public $partner_registration_id;

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
            $this->partner_registration_id = $gstdetail_model->partner_registration_id;
        }
    }

    public function rules()
    {
        return [
            [['gst_number', 'state'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['status', 'state','partner_registration_id'], 'integer'],
            [['gst_number'], 'string', 'max' => 50],
            // [
            //     'filepath_upload',
            //     'required',
            //     'when' => function ($model) {
            //         return empty($model->filepath);
            //     },
            //     'whenClient' => 'function (attribute, value) {
            //         return $("#filepath").val() === "";
            //     }',
            // ],
            [['filepath_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'pdf', 'doc', 'png', 'webp'], 'maxSize' => 1 * 1024 * 1024, 'skipOnEmpty' => !$this->isNew],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_registration_id'=>'Partner Registration ID',
            'gst_number' => 'GST Number',
            'filepath' => 'File',
            'status' => 'Status',
            'state' => 'State',
        ];
    }

    public function initializeForm()
    {
        $this->gstdetail_model->partner_registration_id = $this->partner_registration_id;
        $this->gstdetail_model->state = $this->state;
        $this->gstdetail_model->gst_number = $this->gst_number;
        $this->gstdetail_model->filepath = $this->filepath;
        $this->gstdetail_model->status = $this->status;
    }

    public function uploadFiles()
    {
        // $basePath = Yii::$app->params['datapath'] . '/Uploads';
        // if (!file_exists($basePath)) {
        //     mkdir($basePath, 0777, true);
        // }

        // $userFolder = $basePath . '/' . $this->gstdetail_model->id;
        // if (!file_exists($userFolder)) {
        //     mkdir($userFolder, 0777, true);
        // }
       
        // if ($this->filepath_upload) {
        //     $fileName = 'filepath_upload'. '_' . time() . '.' . $this->filepath_upload->extension;
        //     $filePath = $userFolder . '/' . $fileName;
        //     if ($this->filepath_upload->saveAs($filePath)) {
        //         $this->filepath_upload = $filePath;
        //         $this->gstdetail_model->filepath = $filePath;
        //     } else {
        //         Yii::error("Failed to save file: $fileName", __METHOD__);
        //     }
        // }

        // if (!$this->gstdetail_model->save(false)) {
        //     Yii::error("Failed to save GST model after uploading file.", __METHOD__);
        // }
        if ($this->filepath_upload) {
            $storagePath = 'operator-registration';
            $userPath = $storagePath . '/' . $this->gstdetail_model->user->user_id . '/gstimage';

            $fileName = $this->gstdetail_model->user->user_id . '_gstimage_' . time() . '.' . $this->filepath_upload->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                // try {
                    if ($etag =  FsHelper::saveUploadedFile($this->filepath_upload, $filePath, $fileName, true)) {
                        // $this->filepath = $fileName;
                        $this->gstdetail_model->filepath = $filePath;
                        // $this->gstdetail_model->etag = $etag;

                        $extension = $this->filepath_upload->extension;
                        if ($extension === 'svg') {
                            $width = 0;
                            $height = 0;
                        } else {
                            list($width, $height) = getimagesize($this->filepath_upload->tempName);
                        }
                        // $this->gstdetail_model->height =  $height;
                        // $this->gstdetail_model->width = $width;
                        $this->gstdetail_model->save(false);
                    }
                // } catch (\Exception $e) {
                //     throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                // }
            }
        }

    }
    
}


// if ($this->file) {
//     $storagePath = 'watchpost';
//     $userPath = $storagePath . '/' . $this->user_photo_model->user_id . '/media';

//     $fileName = $this->user_photo_model->user_id . '_media_' . time() . '.' . $this->file->extension;
//     $filePath = $userPath . '/' . $fileName;

//     // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
//     if ($fileName) {
//         try {
//             if ($etag =  FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
//                 $this->user_photo_model->file = $fileName;
//                 $this->user_photo_model->filepath = $filePath;
//                 $this->user_photo_model->etag = $etag;

//                 $extension = $this->file->extension;
//                 if ($extension === 'svg') {
//                     $width = 0;
//                     $height = 0;
//                 } else {
//                     list($width, $height) = getimagesize($this->file->tempName);
//                 }
//                 $this->user_photo_model->height =  $height;
//                 $this->user_photo_model->width = $width;
//                 $this->user_photo_model->save(false);
//             }
//         } catch (\Exception $e) {
//             throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
//         }
//     }
// }