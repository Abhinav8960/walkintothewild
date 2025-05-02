<?php

namespace common\models\sighting;

use common\models\feeds\Feeds;
use common\models\master\animal\MasterAnimal;
use common\models\meta\MetaSafariSession;
use common\models\park\SafariPark;
use common\models\User;
use common\traits\CommanRelationship;
use Yii;


class Sighting extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sighting';
    }

    public function behaviors()
    {
        return [
            //  [
            //     'class' => \common\behaviors\ModerationBehavior::class,
            //     'attributes' => ['filepath'],
            //     'type' => 'video',
            //     'collection' => Feeds::MODEL_SIGHTING,
            // ],
            [
                'class' => \common\behaviors\FeedsBehavior::class,
                'objective' => 'sighting',
                'collection' => Feeds::MODEL_SIGHTING,
            ],
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
            [['user_id', 'file', 'filepath', 'video_thumbnail', 'video_thumbnail_path', 'video_thumbnail_etag', 'etag', 'height', 'width', 'latitude', 'longitude', 'location', 'description', 'master_animal_id', 'safari_session_id', 'post_datetime', 'zone_id', 'v_size', 'v_duration', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['total_view'], 'default', 'value' => 0],
            [['user_id', 'height', 'width', 'location', 'master_animal_id', 'safari_session_id', 'zone_id', 'v_size', 'v_duration', 'status', 'total_view', 'created_at', 'created_by', 'updated_at', 'updated_by', 'safari_operator_id'], 'integer'],
            [['video_thumbnail', 'description'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['post_datetime'], 'safe'],
            [['file', 'filepath', 'etag'], 'string', 'max' => 255],
            [['video_thumbnail_path', 'video_thumbnail_etag'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'file' => 'File',
            'filepath' => 'Filepath',
            'video_thumbnail' => 'Video Thumbnail',
            'video_thumbnail_path' => 'Video Thumbnail Path',
            'video_thumbnail_etag' => 'Video Thumbnail Etag',
            'etag' => 'Etag',
            'height' => 'Height',
            'width' => 'Width',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'location' => 'Location',
            'description' => 'Description',
            'master_animal_id' => 'Master Animal ID',
            'safari_session_id' => 'Safari Session ID',
            'post_datetime' => 'Post Datetime',
            'zone_id' => 'Zone ID',
            'v_size' => 'V Size',
            'v_duration' => 'V Duration',
            'status' => 'Status',
            'total_view' => 'Total View',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLocationDetail()
    {
        return $this->hasOne(SafariPark::class, ['id' => 'location']);
    }

    public function getAnimalDetail()
    {
        return $this->hasOne(MasterAnimal::class, ['id' => 'master_animal_id']);
    }

    public function getSafariSessionDetail()
    {
        return $this->hasOne(MetaSafariSession::class, ['id' => 'safari_session_id']);
    }

    public function getThumbnail()
    {
        $this->filepath = \common\models\GeneralModel::extentionRemove($this->filepath);
        return Yii::$app->params['s3_thumbnail_endpoint'] . '/thumbnail/high/' . $this->filepath . '.jpg';
    }

    public function getLike()
    {
        return $this->hasMany(SightingLike::class, ['sighting_id' => 'id']);
    }

    public function getLikes_count()
    {
        return $this->getLike()->count();
    }

    public function getComments()
    {
        return $this->hasMany(SightingComment::class, ['sighting_id' => 'id'])->andWhere(['parent_id' => null]);
    }

    public function getComments_count()
    {
        return $this->getComments()->andWhere(['sighting_comment.status' => 1])->count();
    }

    public function getReplies()
    {
        return $this->hasMany(SightingComment::class, ['sighting_id' => 'id'])->andWhere(['!=', 'parent_id', null]);
    }

    public function getReplies_count()
    {
        return $this->getReplies()->andWhere(['sighting_comment.status' => 1])->count();
    }
    
    public function getFull_file_path()
    {
        if ($this->file) {
            return  Yii::$app->params['s3_endpoint'] . '/watchpost/' . $this->user_id . '/media/' . $this->file;
        }
        return null;
    }
}
