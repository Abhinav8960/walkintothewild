<?php

namespace common\models\postscomment;

use common\models\User;
use common\models\UserPosts;
use Yii;

/**
 * This is the model class for table "post_comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_posts_id
 * @property int|null $parent_id
 * @property string $comment
 * @property string $comment_date
 * @property int|null $like_counts
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UserPostComment extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    const DELETED_BY_ADMIN = 1;
    const PARENT_DELETED = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_post_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_posts_id', 'parent_id', 'status', 'created_by', 'created_at', 'updated_at', 'updated_by', 'safari_operator_id'], 'integer'],
            [['comment'], 'string'],
            [['dateTime'], 'safe'],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_posts_id' => 'User Posts ID',
            'parent_id' => 'Parent ID',
            'comment' => 'comment',
            'dateTime' => 'Comment Date',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function getPost()
    {
        return $this->hasOne(UserPosts::className(), ['id' => 'user_posts_id']);
    }

    public function getReplies()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    public function getReplies_count()
    {
        return $this->getReplies()->andWhere(['user_post_comment.status' => 1])->count();
    }

    public function getReports()
    {
        return $this->hasMany(UserPostCommentFlag::className(), ['user_post_comment_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updatePostCommentCount();
        parent::afterSave($insert, $changedAttributes);
        if($this->status == Self ::STATUS_ACTIVE){
            $host = UserPosts::find()->where(['id'=>$this->user_posts_id,'status'=>UserPosts::STATUS_ACTIVE])->one();
            $host_user = User::find()->where(['id'=>$host->user_id,'status'=>User::STATUS_ACTIVE])->one();
            if(!empty($host && $host_user)){
            return new \common\events\post\PostCommentByUser($this->user->name,$host_user->id,$host_user->name);
            }
        }
    }

    public function afterDelete()
    {
        $this->updatePostCommentCount();
        parent::afterDelete();
    }
    
    public function updatePostCommentCount()
    {
        if ($this->user_posts_id) {
            $userposts = UserPosts::find()->where(['status' => UserPosts :: STATUS_ACTIVE, 'id' => $this->user_posts_id])->one();
            $likes = UserPostComment::find()->where(['user_posts_id' => $this->user_posts_id])->count();
            if ($userposts) {                
                $userposts->comment_count = $likes;
                $userposts->save(false); 
            }
        }
    }
    
}
