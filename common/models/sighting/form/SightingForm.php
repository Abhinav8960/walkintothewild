<?php

namespace common\models\sighting\form;

use common\Helper\FsHelper;
use common\models\master\animal\MasterAnimal;
use common\models\meta\MetaSafariSession;
use common\models\meta\MetaZoneType;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\park\SafariPark;
use common\models\sighting\Sighting;
use Yii;
use yii\base\Model;

/**
 * SightingForm form
 */
class SightingForm extends Model
{

    public $file;
    public $description;
    public $user_id;
    public $v_size;
    public $v_duration;

    public $sighting_model;
    public $status;
    public $video_thumbnail;

    public $location;
    public $master_animal_id;
    public $safari_session_id;
    public $post_datetime;
    public $zone_id;

    public $safari_operator_id;


    public function __construct(Sighting $sighting_model = null)
    {
        $this->sighting_model = Yii::createObject([
            'class' => Sighting::className()
        ]);
        if ($sighting_model != null) {
            $this->sighting_model = $sighting_model;

            $this->description = $this->sighting_model->description;
            $this->user_id = $this->sighting_model->user_id;
            $this->safari_operator_id = $this->sighting_model->safari_operator_id;
            $this->v_size = $this->sighting_model->v_size;
            $this->v_duration = $this->sighting_model->v_duration;
            $this->video_thumbnail = $this->sighting_model->video_thumbnail;
            $this->location = $this->sighting_model->location;

            $this->status = $this->sighting_model->status;

            $this->master_animal_id = $this->sighting_model->master_animal_id;
            $this->safari_session_id = $this->sighting_model->safari_session_id;
            $this->post_datetime = $this->sighting_model->post_datetime;
            $this->zone_id = $this->sighting_model->zone_id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'master_animal_id', 'safari_session_id', 'location', 'description'], 'required'],
            [
                ['file'],
                'file',
                'extensions' => ['mp4', 'avi', 'mkv', 'webm'],
                'maxSize' => 18 * 1024 * 1024,
            ],
            [
                ['video_thumbnail'],
                'file',
                'extensions' => ['jpeg', 'jpg', 'png'],
                // 'maxSize' => 10 * 1024,
            ],
            [['user_id', 'status', 'safari_operator_id'], 'integer'],
            [['description'], 'string'],
            [['v_size', 'v_duration', 'master_animal_id', 'safari_session_id', 'zone_id', 'location'], 'integer'],
            [['post_datetime'], 'date', 'format' => 'php:Y-m-d'],
            ['post_datetime', 'compare', 'compareValue' => date("Y-m-d"), 'operator' => '<='],
            [
                'post_datetime',
                'default',
                'value' => function () {
                    return date("Y-m-d");
                }
            ],
            ['master_animal_id', 'exist', 'targetClass' => MasterAnimal::class, 'targetAttribute' => ['master_animal_id' => 'id']],
            ['safari_session_id', 'exist', 'targetClass' => MetaSafariSession::class, 'targetAttribute' => ['safari_session_id' => 'id']],
            ['zone_id', 'exist', 'targetClass' => MetaZoneType::class, 'targetAttribute' => ['zone_id' => 'id']],
            // ['location', 'exist', 'targetClass' => SafariPark::class, 'targetAttribute' => ['location' => 'id']],
            ['location', 'validateOperatorPark'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'safari_operator_id' => 'Safari Operator ID',
            'file' => 'File',
            'filepath' => 'Filepath',
            'video_thumbnail' => 'Video Thumbnail',
            'video_thumbnail_path' => 'Video Thumbnail Path',
            'video_thumbnail_etag' => 'Video Thumbnail Etag',
            'etag' => 'Etag',
            'location' => 'Location',
            'description' => 'Description',
            'master_animal_id' => 'Master Animal ID',
            'safari_session_id' => 'Safari Session ID',
            'post_datetime' => 'Post Datetime',
            'zone_id' => 'Zone ID',
            'v_size' => 'V Size',
            'v_duration' => 'V Duration',
            'status' => 'Status',
        ];
    }

    public function initializeForm()
    {

        $this->sighting_model->description = $this->description;
        $this->sighting_model->user_id = $this->user_id;
        $this->sighting_model->safari_operator_id = $this->safari_operator_id;
        $this->sighting_model->v_size = $this->v_size;
        $this->sighting_model->v_duration = $this->v_duration;
        // $this->sighting_model->video_thumbnail = $this->video_thumbnail;
        $this->sighting_model->location = $this->location;
        $this->sighting_model->status = $this->status;

        $this->sighting_model->master_animal_id = $this->master_animal_id;
        $this->sighting_model->safari_session_id = $this->safari_session_id;
        $this->sighting_model->post_datetime = $this->post_datetime;
        $this->sighting_model->zone_id = $this->zone_id;
    }



    public function uploadFile()
    {
        if ($this->file) {
            $storagePath = 'watchpost';
            $userPath = $storagePath . '/' . $this->sighting_model->user_id . '/media';

            $fileName = $this->sighting_model->user_id . '_media_' . time() . '.' . $this->file->extension;
            $filePath = $userPath . '/' . $fileName;
            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $caption = NULL, $this->user_id);

            file_put_contents(Yii::getAlias('@runtime/logs/custom.log'), $fileName);

            if ($fileName) {
                // try {
                if ($etag =  FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
                    $this->sighting_model->file = $fileName;
                    $this->sighting_model->filepath = $filePath;
                    $this->sighting_model->etag = $etag;

                    $this->sighting_model->save(false);
                }
            }
        }

        if ($this->video_thumbnail) {
            $storagePath = 'watchpost';
            $userPath = $storagePath . '/' . $this->sighting_model->user_id . '/thumbnail';

            $fileName = $this->sighting_model->user_id . '_thumbnail_' . time() . '.' . $this->video_thumbnail->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->video_thumbnail, $filePath, $fileName, $caption = NULL, $this->user_id);
            // $fileName = FsHelper::UserPostUploadFile($this->video_thumbnail, $filePath, $fileName, $caption = NULL, $this->user_id);
            if ($fileName) {
                // try {
                if ($video_thumbnail_etag =  FsHelper::saveUploadedFile($this->video_thumbnail, $filePath, $fileName, true)) {
                    $this->sighting_model->video_thumbnail = $fileName;
                    $this->sighting_model->video_thumbnail_path = $filePath;
                    $this->sighting_model->video_thumbnail_etag = $video_thumbnail_etag;
                    $this->sighting_model->save(false);
                }
            }
        }
    }

    public function validateOperatorPark($attribute, $params)
    {
        $user = Yii::$app->user->identity;
        if ($user) {
            $operator = SafariOperator::find()->where(['user_id' => $user->id, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one();
            if ($operator) {
                $exists = SafariOperatorPark::find()
                    ->where(['safari_operator_id' => $operator->id, 'park_id' => $this->$attribute])
                    ->andWhere(['status' => 1])
                    ->exists();

                if (!$exists) {
                    $this->addError($attribute, 'You are not assigned to this park.');
                }
            }
        }
    }
}
