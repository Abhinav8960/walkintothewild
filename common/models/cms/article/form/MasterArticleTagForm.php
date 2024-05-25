<?php

namespace common\models\cms\article\form;

use Yii;
use common\models\cms\article\MasterArticleTag;

/**
 * This is the model class for table "master_blog_category".
 *
 * @property int $id
 * @property int|null $title
 * @property string|null $color_code
 * @property int|null $description
 * @property int|null $status
 */
class MasterArticleTagForm extends \yii\base\Model
{
    public $title;
    public $status;
    public $slug;
    public $master_article_tag_model;
    public $action_url;
    public $action_validate_url;

    /**
     *
     * @param [type] $master_article_tag_model
     */
    public function __construct(MasterArticleTag $master_article_tag_model = null)
    {
        $this->master_article_tag_model = Yii::createObject([
            'class' => MasterArticleTag::className()
        ]);
        if ($master_article_tag_model != null) {
            $this->master_article_tag_model = $master_article_tag_model;
            $this->title = $this->master_article_tag_model->title;
            $this->slug = $this->master_article_tag_model->slug;
            $this->status = $this->master_article_tag_model->status;
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
                    return strtolower($this->master_article_tag_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => MasterArticleTag::className(), 'targetAttribute' => ['title'],
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
        $this->master_article_tag_model->title = $this->title;
        $this->master_article_tag_model->slug = $this->slug;
        $this->master_article_tag_model->status = $this->status;
    }
}
