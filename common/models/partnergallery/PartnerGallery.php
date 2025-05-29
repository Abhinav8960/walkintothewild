<?php

namespace common\models\partnergallery;

use common\models\park\SafariPark;
use common\models\partnergalleryimage\PartnerGalleryImage;
use common\traits\CommanRelationship;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "partner_gallery".
 *
 * @property int $id
 * @property int $safari_operator_id
 * @property string $title
 * @property int $safari_park_id
 * @property string $slug
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class PartnerGallery extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_gallery';
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
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['safari_operator_id', 'title', 'safari_park_id', 'slug'], 'required'],
            [['safari_operator_id', 'safari_park_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['safari_operator_id', 'title', 'slug'], 'unique', 'targetAttribute' => ['safari_operator_id', 'title', 'slug']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_operator_id' => 'Safari Operator ID',
            'title' => 'Title',
            'safari_park_id' => 'Safari Park ID',
            'slug' => 'Slug',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getPark_label()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'safari_park_id']);
    }

    public function getGallery_count()
    {
        $gallery_count = PartnerGalleryImage::find()->where(['partner_gallery_id' => $this->id, 'status' => PartnerGalleryImage::STATUS_ACTIVE])->count();
        if ($gallery_count > 0) {
            return $gallery_count;
        }
        return 0;
    }
}
