<?php

namespace common\models\cms\mastercategory\form;

use Yii;
use common\models\cms\mastercategory\MasterTopic;

/**
 * This is the model class for table "master_blog_category".
 *
 * @property int $id
 * @property int|null $title
 * @property string|null $color_code
 * @property int|null $description
 * @property int|null $status
 */
class MasterTopicForm extends \yii\base\Model
{
    public $title;
    public $status;
    public $slug;
    public $master_topic_model;
    public $action_url;
    public $action_validate_url;

    /**
     *
     * @param [type] $master_topic_model
     */
    public function __construct(MasterTopic $master_topic_model = null)
    {
        $this->master_topic_model = Yii::createObject([
            'class' => MasterTopic::className()
        ]);
        if ($master_topic_model != null) {
            $this->master_topic_model = $master_topic_model;
            $this->title = $this->master_topic_model->title;
            $this->slug = $this->master_topic_model->slug;
            $this->status = $this->master_topic_model->status;
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
                    return strtolower($this->master_topic_model->$attribute) != strtolower($model->$attribute);
                },
                'targetClass' => MasterTopic::className(), 'targetAttribute' => ['title'],
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
            'title' => 'Title',
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
        $this->master_topic_model->title = $this->title;
        $this->master_topic_model->slug = $this->slug;
        $this->master_topic_model->status = $this->status;
    }
}
