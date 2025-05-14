<?php

namespace common\models;

use common\models\feeds\Feeds;
use common\models\operator\SafariOperator;
use common\models\postscomment\UserPostComment;
use common\models\postscomment\UserPostLike;
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
            //     'type' => 'image',
            //     'collection' => Feeds::MODEL_POSTS,
            // ],
            [
                'class' => \common\behaviors\FeedsBehavior::class,
                'objective' => 'posts',
                'collection' => Feeds::MODEL_POSTS,
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
            [['user_id', 'height', 'width', 'status', 'size', 'created_at', 'created_by', 'updated_at', 'updated_by', 'safari_operator_id'], 'integer'],
            [['caption', 'filepath', 'etag'], 'string'],
            [['file', 'delete_reason'], 'string', 'max' => 512],
            [['version'], 'integer'],

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
            'safari_operator_id' => 'Safari Operator Id',
            'version' => 'Version',
            'file' => 'File',
            'caption' => 'Caption',
            'status' => 'Status',
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


    public function getLike()
    {
        return $this->hasMany(UserPostLike::class, ['user_post_id' => 'id']);
    }

    public function getLikes_count()
    {
        return $this->getLike()->count();
    }

    public function getComments()
    {
        return $this->hasMany(UserPostComment::class, ['user_posts_id' => 'id'])->andWhere(['parent_id' => null]);
    }

    public function getComments_count()
    {
        return $this->getComments()->andWhere(['user_post_comment.status' => 1])->count();
    }


    public function getReplies()
    {
        return $this->hasMany(UserPostComment::class, ['user_posts_id' => 'id'])->andWhere(['IS NOT', 'parent_id', null]);
    }

    public function getReplies_count()
    {
        return $this->getReplies()->andWhere(['user_post_comment.status' => 1])->count();
    }

    public function getFull_image_path()
    {
        if ($this->file) {
            return  Yii::$app->params['s3_endpoint'] . '/' . $this->filepath;
        }
        return null;
    }

    public function getSafarioperator()
    {
        return $this->hasOne(SafariOperator::class, ['id' => 'safari_operator_id']);
    }


    public function savehistory()
    {

        $historyModel = new UserPostsHistory();
        $historyModel->attributes = $this->attributes;
        $historyModel->parent_id = $this->id;

        if (!$historyModel->save(false)) {
            Yii::error('Failed to save User Post History: ' . print_r($historyModel->errors, true), __METHOD__);
        }
    }

      // public function afterSave($insert, $changedAttributes)
    // {
    //     parent::afterSave($insert, $changedAttributes);


    //     $relatedModel = new UserPostsHistory();
    //     $relatedModel->attributes = $this->attributes;
    //     $relatedModel->parent_id = $this->id;
    //     $relatedModel->save(false);

    //     return true;
    // }
}
