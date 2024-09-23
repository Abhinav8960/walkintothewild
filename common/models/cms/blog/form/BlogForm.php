<?php

namespace common\models\cms\blog\form;

use Yii;
use common\models\cms\blog\Blog;
use common\models\cms\blog\BlogAuthor;
use common\models\cms\blog\BlogTag;
use common\models\cms\blog\BlogTopic;
use common\models\GeneralModel;

/**
 * This is the model class for table "master_blog".
 *
 * @property int $id
 * @property int|null $name
 * @property string|null $color_code
 * @property int|null $description
 * @property int|null $status
 */
class BlogForm extends \yii\base\Model
{
    public $user_type;
    public $title;
    public $sub_title;
    public $slug;
    public $blog_author_id;
    public $author_name;
    public $blog_tags;
    public $tag_name;
    public $description;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;
    public $view;
    public $post_body;
    public $comment_allowed;
    public $approval_required;
    public $blog_date;
    public $is_schedule;
    public $publish_date_time;
    public $status;
    public $banner_image;
    public $feature_image;
    public $blog_topics;
    public $blog_model;
    public $is_approved;
    public $action_url;
    public $action_validate_url;

    /**
     * @param [type] $blog_model
     */
    public function __construct(Blog $blog_model = null)
    {
        $this->blog_model = Yii::createObject([
            'class' => Blog::className()
        ]);
        if ($blog_model != null) {
            $this->blog_model = $blog_model;
            $this->title = $this->blog_model->title;
            $this->banner_image = $this->blog_model->banner_image;
            $this->feature_image = $this->blog_model->feature_image;
            $this->sub_title = $this->blog_model->sub_title;
            $this->slug = $this->blog_model->slug;
            $this->description = $this->blog_model->description;
            $this->blog_author_id = $this->blog_model->blog_author_id;
            $this->author_name = $this->blog_model->author_name;
            $this->meta_title = $this->blog_model->meta_title;
            $this->meta_description = $this->blog_model->meta_description;
            $this->meta_keywords = $this->blog_model->meta_keywords;
            $this->view = $this->blog_model->view;
            $this->blog_date = $this->blog_model->blog_date;
            $this->post_body = $this->blog_model->post_body;
            $this->comment_allowed = $this->blog_model->comment_allowed;
            $this->approval_required = $this->blog_model->approval_required;
            $this->is_schedule = $this->blog_model->is_schedule;
            $this->publish_date_time = $this->blog_model->publish_date_time;
            $this->is_approved = $this->blog_model->is_approved;
            $this->status = $this->blog_model->status;
            $this->user_type = $this->blog_model->user_type;
            // $this->blog_topics = BlogTopic::find()->select('master_blog_topic_id')->where(['corporate_id' => $this->blog_model->corporate_id, 'master_blog_id' => $this->blog_model->id, 'status' => 1])->column();

            $this->blog_topics = BlogTopic::find()->select('master_blog_topic_id')->where(['blog_id' => $this->blog_model->id, 'status' => 1])->column();
            $this->blog_tags = BlogTag::find()->select('master_blog_tag_id')->where(['blog_id' => $this->blog_model->id, 'status' => 1])->column();
            // dd($this->blog_tags);
        }
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['uploadfile'] = ['uploadfile'];
        $scenarios['create'] = [
            'user_type', 'title', 'sub_title', 'description', 'blog_tags', 'tag_name', 'feature_image', 'banner_image', 'status', 'slug',
            'blog_date', 'long_description', 'blog_author_id', 'author_name', 'meta_title', 'meta_description', 'comment_allowed',
            'approval_required', 'is_schedule', 'publish_date_time', 'sequence', 'view', 'post_body', 'meta_keywords', 'blog_topics', 'is_approved'
        ];
        $scenarios['update'] = [
            'user_type', 'title', 'sub_title', 'description', 'blog_tags', 'tag_name', 'status', 'slug', 'banner_image',
            'blog_date', 'long_description', 'blog_author_id', 'author_name', 'meta_title', 'meta_description', 'comment_allowed',
            'approval_required', 'is_schedule', 'publish_date_time', 'sequence', 'view', 'post_body', 'meta_keywords', 'blog_topics', 'is_approved'
        ];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'blog_tags', 'comment_allowed', 'blog_topics', 'user_type'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['status', 'blog_author_id'], 'integer'],
            [['description', 'meta_description'], 'string'],
            [['blog_topics'], 'safe'],
            [
                ['banner_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
                'minWidth' => 940,
                'maxWidth' => 940,
                'maxHeight' => 430,
                'minHeight' => 430,
                'maxSize' => 250 * 1024,
                'skipOnEmpty' => true,
            ],

            // [
            //     ['feature_image'], 'image', 'extensions' => ['jpeg', 'jpg', 'png'],
            //     'minWidth' => 350,
            //     'maxWidth' => 350,
            //     'maxHeight' => 350,
            //     'minHeight' => 350,
            //     'maxSize' => 250 * 1024,
            //     'skipOnEmpty' => true,
            // ],
            [['title'], 'string', 'max' => 255],
            [['slug', 'meta_title'], 'string', 'max' => 255],
            [
                'title', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->blog_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => Blog::className(), 'targetAttribute' => ['title'],
                'message' => 'This Title has already been taken'
            ],
            [['description', 'meta_description', 'meta_keywords', 'post_body'], 'string'],
            [['blog_author_id', 'view', 'comment_allowed', 'approval_required', 'is_schedule', 'status'], 'integer'],
            [['publish_date_time', 'blog_date'], 'safe'],
            [['title', 'author_name', 'meta_title', 'tag_name'], 'string', 'max' => 255],
            [['sub_title'], 'string', 'max' => 75],
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
            'sub_title' => 'Sub Title',
            'description' => 'Description',
            'banner' => 'Banner',
            'feature_image' => 'Feature Image',
            'banner_image' => 'Banner Image',
            'blog_author_id' => 'Blog Author',
            'author_name' => 'Author Name',
            'blog_tags' => 'Blog Tag',
            'tag_name' => 'Tag Name',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'view' => 'View',
            'blog_date' => 'Blog Date',
            'post_body' => 'Post Body',
            'comment_allowed' => 'Comment Allowed',
            'approval_required' => 'Approval Required',
            'is_schedule' => 'Is Schedule',
            'publish_date_time' => 'Publish Date Time',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->blog_model->title = $this->title;
        $this->blog_model->sub_title = $this->sub_title;
        $this->blog_model->slug = $this->slug;
        $this->blog_model->description = $this->description;
        $this->blog_model->blog_author_id = $this->blog_author_id;
        if ($this->blog_author_id) {
            $author = BlogAuthor::find()->where(['id' => $this->blog_author_id])->one();
            if ($author) {
                $this->blog_model->author_name =  $author->author_name;
            }
        }
        // $this->blog_model->blog_tags = $this->blog_tags;
        // if ($this->blog_tags) {
        //     $this->blog_model->tag_name =  GeneralModel::tagoption()[$this->blog_tags];
        // }
        $this->blog_model->meta_title = $this->meta_title;
        $this->blog_model->meta_description = $this->meta_description;
        $this->blog_model->meta_keywords = $this->meta_keywords;
        $this->blog_model->view = $this->view;
        $this->blog_model->blog_date = $this->blog_date;
        $this->blog_model->post_body = $this->post_body;
        $this->blog_model->comment_allowed = $this->comment_allowed;
        $this->blog_model->approval_required = $this->approval_required;
        $this->blog_model->is_schedule = $this->is_schedule;
        $this->blog_model->publish_date_time = $this->publish_date_time;
        $this->blog_model->is_approved = $this->is_approved;
        $this->blog_model->status = $this->status;
        $this->blog_model->user_type = $this->user_type;
    }

    /**
     * Upload Banner image
     *
     * @return void
     */
    public function UploadFile()
    {
        if ($this->banner_image) {
            $storagePath = Yii::$app->params['datapath'] . '/blog';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->blog_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'blog_banner' . '-' . time() . '.' . $this->banner_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->banner_image->saveAs($filePath)) {
                $this->blog_model->banner_image = $fileName;
                $this->blog_model->save(false);
            }
        }

        if ($this->feature_image) {
            $storagePath = Yii::$app->params['datapath'] . '/blog';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->blog_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'blog_feature' . time() . '.' . $this->feature_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->feature_image->saveAs($filePath)) {
                $this->blog_model->feature_image = $fileName;
                $this->blog_model->save(false);
            }
        }
    }
}
