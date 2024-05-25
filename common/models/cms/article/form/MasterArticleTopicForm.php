<?php

namespace common\models\cms\article\form;

use Yii;
use common\models\cms\article\MasterArticleTopic;

/**
 * This is the model class for table "master_blog_category".
 *
 * @property int $id
 * @property int|null $title
 * @property string|null $color_code
 * @property int|null $description
 * @property int|null $status
 */
class MasterArticleTopicForm extends \yii\base\Model
{
    public $title;
    public $status;
    public $slug;
    public $master_article_topic_model;
    public $action_url;
    public $action_validate_url;

    /**
     *
     * @param [type] $master_article_topic_model
     */
    public function __construct(MasterArticleTopic $master_article_topic_model = null)
    {
        $this->master_article_topic_model = Yii::createObject([
            'class' => MasterArticleTopic::className()
        ]);
        if ($master_article_topic_model != null) {
            $this->master_article_topic_model = $master_article_topic_model;
            $this->title = $this->master_article_topic_model->title;
            $this->slug = $this->master_article_topic_model->slug;
            $this->status = $this->master_article_topic_model->status;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'default', 'value' => 1],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 230],
            [['slug'], 'string', 'max' => 300],
            [
                'title', 'unique', 'when' => function ($model, $attribute) {
                    return strtolower($this->master_article_topic_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => MasterArticleTopic::className(), 'targetAttribute' => ['title'],
                'message' => 'This Topic has already been taken'
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
            'title' => 'title',
            'slug' => 'Slug',
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
        $this->master_article_topic_model->title = $this->title;
        $this->master_article_topic_model->slug = $this->slug;
        $this->master_article_topic_model->status = $this->status;
    }
}
