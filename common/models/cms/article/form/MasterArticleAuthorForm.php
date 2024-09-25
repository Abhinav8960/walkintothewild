<?php

namespace common\models\cms\article\form;

use common\models\cms\article\MasterArticleAuthor;
use common\models\GeneralModel;
use Yii;

/**
 * This is the model class for table "article_author".
 *
 * @property int $id
 * @property int|null $status
 */
class MasterArticleAuthorForm extends \yii\base\Model
{
    public $name;
    public $slug;
    public $status;
    public $master_article_author_model;
    public $status_option = [];

    /**
     *
     * @param [type] $master_master_article_author_model
     */
    public function __construct(MasterArticleAuthor $master_article_author_model = null)
    {
        $this->master_article_author_model = Yii::createObject([
            'class' => MasterArticleAuthor::className()
        ]);
        if ($master_article_author_model != null) {
            $this->master_article_author_model = $master_article_author_model;
            $this->name = $this->master_article_author_model->name;
            $this->slug = $this->master_article_author_model->slug;
            $this->status = $this->master_article_author_model->status;
        }

        $this->status_option = GeneralModel::newstatusoption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name','slug'], 'string', 'max' => 255],
            [
                'name',
                'unique',
                'when' => function ($model, $attribute) {
                    return strtolower($this->master_article_author_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => MasterArticleAuthor::className(),
                'targetAttribute' => ['name'],
                'message' => 'This Author Name has already been taken'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Author Name',
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
        $this->master_article_author_model->name = $this->name;
        $this->master_article_author_model->slug = $this->slug;
        $this->master_article_author_model->status = $this->status;
    }
}
