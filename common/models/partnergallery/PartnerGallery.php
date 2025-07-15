<?php

namespace common\models\partnergallery;

use api\models\partnergalleryimage\PartnerGalleryImage as ApiPartnergalleryimage;
use common\models\operator\SafariOperator;
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

    const CANNOT_SEND_FOR_APPROVAL = 0;
    const DEFAULT_APPROVAL_STATUS = 1;

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
                'immutable' => true,
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
            [['safari_operator_id', 'title', 'slug'], 'required'],
            [['safari_operator_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'park_id'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            // [['safari_operator_id', 'title', 'slug'], 'unique', 'targetAttribute' => ['safari_operator_id', 'title', 'slug']],
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
            'park_id' => 'Park ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getGallery_count()
    {
        $gallery_count = PartnerGalleryImage::find()->where(['partner_gallery_id' => $this->id, 'status' => PartnerGalleryImage::STATUS_ACTIVE])->count();
        if ($gallery_count > 0) {
            return $gallery_count;
        }
        return 0;
    }

    public function getThumbnail()
    {
        $model = PartnerGalleryImage::find()->where(['partner_gallery_id' => $this->id])->andWhere(['set_as_thumbnail' => 1])->limit(1)->one();
        if ($model) {
            return Yii::$app->params['s3_endpoint'] . '/' . $model->filepath;
        }
        return null;
    }

    public function getGalleryActiveImages()
    {
        return $this->hasMany(ApiPartnergalleryimage::class, ['partner_gallery_id' => 'id'])->andWhere(['partner_gallery_image.status' => 1])->orderBy(['partner_gallery_image.sequence' => SORT_ASC]);
    }

    public function PrepareFullResponse()
    {
        return $arr = [
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'status' => (bool) $this->status,
            'image_count' => $this->getGalleryActiveImages()->count(),
            'images' => array_map(function ($image) {
                return $image->toArray();
            }, $this->galleryActiveImages),
        ];
    }

    public function getPartner()
    {
        return $this->hasOne(SafariOperator::class, ['id' => 'safari_operator_id']);
    }

    public function getPark()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'park_id']);
    }

    public function versionsave()
    {
        PartnerGalleryVersion::updateAll(['is_live' => 0], ['partner_gallery_id' => $this->id]);
        $version_model = PartnerGalleryVersion::find()->where(['partner_gallery_id' => $this->id])->orderBy(['version' => SORT_DESC])->limit(1)->one();

        $version_form_model = new PartnerGalleryVersion();
        $version_form_model->partner_gallery_id = $this->id;
        $version_form_model->version = !empty($version_model->version) ? $version_model->version + 1 : 1;
        $version_form_model->safari_operator_id = $this->safari_operator_id;
        $version_form_model->park_id = $this->park_id;
        $version_form_model->title = $this->title;
        $version_form_model->slug = $this->slug;
        $version_form_model->remark = $this->remark;
        $version_form_model->can_send_for_approval = $this->can_send_for_approval;
        $version_form_model->live_images = $this->live_images;
        $version_form_model->in_draft = $this->in_draft;
        $version_form_model->is_approved = $this->is_approved;
        $version_form_model->send_for_approval = $this->send_for_approval;
        $version_form_model->is_live = 1;
        $version_form_model->status = $this->status;

        $version_form_model->save(false);
    }
}
