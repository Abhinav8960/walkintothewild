<?php

namespace common\models\partnerregistration;

use api\models\master\state\MasterState;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "partner_gst_details".
 *
 * @property int $id
 * @property string|null $gst_number
 * @property string|null $filepath
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int|null $state
 */
class PartnerGstDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_gst_details';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => fn () => Yii::$app->user->id ?? null,
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => fn () => time(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by','partner_regestration_id'], 'integer'],
            [['gst_number'], 'string', 'max' => 50],
            [['filepath'], 'string', 'max' => 255],
            [['gst_number', 'state'], 'required'],
            [['filepath'], 'file', 'skipOnEmpty' => true, 'extensions' => ['pdf', 'jpg', 'jpeg', 'png']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_registration_id'=>'Partner Registration ID',
            'gst_number' => 'GST Number',
            'filepath' => 'GST File Upload',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'state' => 'State',
        ];
    }

    /**
     * Handles file upload and sets the path
     */
    // public function uploadFiles()
    // {
    //     $file = UploadedFile::getInstance($this, 'filepath');

    //     if ($file) {
    //         $basePath = Yii::$app->params['datapath'] . '/Uploads';

    //         if (!is_dir($basePath)) {
    //             mkdir($basePath, 0777, true);
    //         }

    //         $folderName = Yii::$app->user->id;
    //         $userFolder = $basePath . '/' . $folderName;

    //         if (!is_dir($userFolder)) {
    //             mkdir($userFolder, 0777, true);
    //         }

    //         $fileName = 'gst_' . time() . '.' . $file->extension;
    //         $filePath = $userFolder . '/' . $fileName;

    //         if ($file->saveAs($filePath)) {
    //             $this->filepath = 'Uploads/' . $folderName . '/' . $fileName;
    //         } else {
    //             Yii::error("Failed to save GST file: $fileName", __METHOD__);
    //         }
    //     }
    // }

    public function getStateRelation(){
        return $this->hasOne(MasterState :: class ,['id'=>'state']);
    }

    public function getUser(){
        return $this->hasOne(PartnerRegistration::className(), ['gst_id' => 'id']);
    }
}
