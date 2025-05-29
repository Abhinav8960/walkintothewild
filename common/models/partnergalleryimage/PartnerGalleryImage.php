<?php

namespace common\models\partnergalleryimage;

use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "partner_gallery_image".
 *
 * @property int $id
 * @property int $partner_gallery_id
 * @property string $original_filename
 * @property string $filepath
 * @property string $file
 * @property string|null $title
 * @property string|null $caption
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PartnerGalleryImage extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{

    use CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_gallery_image';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
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
            [['title', 'caption', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['partner_gallery_id'], 'required'],
            [['partner_gallery_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['caption'], 'string'],
            [['original_filename', 'filepath', 'file'], 'string', 'max' => 512],
            [['title'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getGallery_image()
    {
        if ($this->filepath) {
            return Yii::$app->params['s3_endpoint'] . '/' . $this->filepath;
        }
        return '';
    }
}
