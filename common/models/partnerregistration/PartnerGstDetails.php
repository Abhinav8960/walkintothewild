<?php

namespace common\models\partnerregistration;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "partner_gst_details".
 *
 * @property int $id
 * @property int|null $gst_number
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
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => function () {
                    return Yii::$app->user->id ?? '';
                },
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gst_number', 'filepath', 'state'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['gst_number', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'state'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['filepath'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gst_number' => 'Gst Number',
            'filepath' => 'Filepath',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'state' => 'State',
        ];
    }


    public function uploadFiles()
    {
        $basePath = Yii::$app->params['datapath'] . '/Uploads';
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $userFolder = $basePath . '/' . $this->id;
        if (!file_exists($userFolder)) {
            mkdir($userFolder, 0777, true);
        }

        $file = UploadedFile::getInstance($this, 'filepath');

        if ($file) {
            $fileName = 'filepath' . '_' . time() . '.' . $file->extension;
            $filePath = $userFolder . '/' . $fileName;

            if ($file->saveAs($filePath)) {
                $this->filepath = $filePath;
            } else {
                Yii::error("Failed to save file: $fileName", __METHOD__);
            }
        }
        if (!$this->save(false)) {
            Yii::error("Failed to save operator model with uploaded file paths.", __METHOD__);
        }
    }

}
