<?php

namespace common\models;

use common\models\carpet\Carpet;
use common\traits\CommanRelationship;
use Yii;

/**
 * This is the model class for table "user_posts".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $type_of_post
 * @property string|null $file
 * @property string|null $caption
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UserPosts extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use CommanRelationship;

    const IMAGE_TYPE = 1;
    const VIDEO_TYPE = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_posts';
    }

    public function behaviors()
    {
        return [
            // [
            //     'class' => \common\behaviors\ModerationBehavior::class,
            //     'attributes' => ['filepath'],
            //     'type' => 'type_of_post',
            //     'type_options' => [SELF::IMAGE_TYPE => 'image', SELF::VIDEO_TYPE => 'video'],
            // ],
            [
                'class' => \common\behaviors\CarpetBehavior::class,
                'objective' => 'Posts',
                'collection' => Carpet::MODEL_POSTS,
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
            [['type_of_post', 'user_id', 'height', 'width', 'like_count', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['caption', 'description', 'location', 'filepath', 'etag'], 'string'],
            // [['latitude', 'longitude'], 'number'],
            [['file'], 'string', 'max' => 512],
            [['v_size', 'v_duration','master_animal_id', 'safari_session_id','zone_id',], 'integer'],
            [['post_datetime'], 'date', 'format' => 'php:Y-m-d H:i:s'],

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
            'type_of_post' => 'Type Of Post',
            'file' => 'File',
            'caption' => 'Caption',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    // public function getImagepath()
    // {
    //     if ($this->file != '') {
    //         return '/storage/userpost/' . $this->user_id . '/' . $this->file;
    //     }
    // }
}
