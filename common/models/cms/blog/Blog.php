<?php

namespace common\models\cms\blog;

use common\models\User;
use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $sub_title
 * @property string|null $description
 * @property string|null $banner
 * @property string|null $feature_image
 * @property int|null $blog_author_id
 * @property string|null $author_name
 * @property string $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $view
 * @property resource|null $post_body
 * @property int|null $comment_allowed
 * @property int|null $approval_required
 * @property int|null $is_schedule
 * @property string|null $publish_date_time
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Blog extends \yii\db\ActiveRecord implements \common\interfaces\NewStatusInterface
{
    use \common\traits\CommanRelationship;

    const USER_TYPE_INDIVIDUAL = 1;
    const USER_TYPE_SAFARI_OPERATOR = 2;
    const USER_TYPE_ADMIN = 3;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
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
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'slug', //The attribute to be generated
                'attribute' => 'title', //The attribute from which will be generated
                'maxLength' => 255,
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true
                ]
            ]
        ];
    }


    public function rules()
    {
        return [
            [['description', 'meta_description', 'meta_keywords',], 'string'],
            [['status', 'user_id',  'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['blog_date'], 'safe'],
            [['title', 'banner_image', 'meta_title'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            // 'sub_title' => 'Sub Title',
            'description' => 'Description',
            'banner_image' => 'Banner Image',
            // 'feature_image' => 'Feature Image',
            // 'blog_author_id' => 'Blog Author ID',
            // 'author_name' => 'Author Name',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            // 'view' => 'View',
            // 'post_body' => 'Post Body',
            // 'comment_allowed' => 'Comment Allowed',
            // 'approval_required' => 'Approval Required',
            // 'is_schedule' => 'Is Schedule',
            // 'publish_date_time' => 'Publish Date Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    // public function getBlogAuthor()
    // {
    //     return $this->hasOne(BlogAuthor::className(), ['id' => 'blog_author_id']);
    // }

    public function getBlogtag()
    {
        return $this->hasOne(MasterBlogTag::className(), ['id' => 'blog_tag_id']);
    }

    public function getBlogtopics()
    {
        return $this->hasMany(BlogTopic::className(), ['blog_id' => 'id'])->andWhere(['blog_topic.status' => 1]);
    }

    public function getBlogtags()
    {
        return $this->hasMany(BlogTag::className(), ['blog_id' => 'id'])->andWhere(['blog_tag.status' => 1]);
    }

    public function getBlogcomments()
    {
        return $this->hasMany(BlogComment::className(), ['blog_id' => 'id'])->andWhere(['is_deleted' => 0, 'blog_comment.status' => 1]);
    }
    public function getFeatureimagepath()
    {
        if ($this->feature_image != '') {
            return '/storage/blog/' . $this->id . '/' . $this->feature_image;
        }
    }

    public function getBannerimagepath()
    {
        if ($this->banner_image != '') {
            return '/storage/blog/' . $this->id . '/' . $this->banner_image;
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
