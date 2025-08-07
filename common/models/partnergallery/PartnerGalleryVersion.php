<?php

namespace common\models\partnergallery;

use common\models\partnergalleryimage\PartnerGalleryImage;
use Yii;

/**
 * This is the model class for table "partner_gallery_version".
 *
 * @property int $id
 * @property int $version
 * @property int $safari_operator_id
 * @property int|null $park_id
 * @property string $title
 * @property string $slug
 * @property string|null $remark
 * @property string|null $live_images
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PartnerGalleryVersion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_gallery_version';
    }

    
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
            [['park_id', 'remark',  'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['listing_status'], 'default', 'value' => 1],
            [['version', 'safari_operator_id', 'park_id',  'listing_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['live_images'], 'string'],
            [['title', 'slug', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version' => 'Version',
            'safari_operator_id' => 'Safari Operator ID',
            'park_id' => 'Park ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'remark' => 'Remark',
            'live_images' => 'Live Images',
            'listing_status' => 'Lisitng Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }


    public function getThumbnail()
    {
        $model = PartnerGalleryImage::find()->where(['partner_gallery_id' => $this->partner_gallery_id])->andWhere(['set_as_thumbnail' => 1])->limit(1)->one();
        if ($model) {
            return Yii::$app->params['s3_endpoint'] . '/' . $model->filepath;
        }
        return null;
    }

    // public function getGallery_count()
    // {
    //     $gallery_count = PartnerGalleryImage::find()->where(['partner_gallery_id' => $this->partner_gallery_id, 'status' => PartnerGalleryImage::STATUS_ACTIVE])->count();
    //     if ($gallery_count > 0) {
    //         return $gallery_count;
    //     }
    //     return 0;
    // }

    public function getPartnerGallery()
    {
        return $this->hasOne(PartnerGallery::class, ['id' => 'partner_gallery_id']);
    }
}
