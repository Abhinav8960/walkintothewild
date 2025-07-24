<?php

namespace common\models\sharesafari\form;

use common\models\sharesafari\ShareSafariFaq;
use Yii;

class ShareSafariFaqForm extends \yii\base\Model
{
    public $share_safari_id;
    public $question;
    public $answer;
    public $position;
    public $status;
    public $share_safari_faq_model;
    public $action_url;
    public $action_validate_url;
    public $version;
    public $master_faq_id;



    /**
     * @param [type] $share_safari_faq_model
     */
    public function __construct(ShareSafariFaq $share_safari_faq_model = null)
    {
        $this->share_safari_faq_model = Yii::createObject([
            'class' => ShareSafariFaq::className()
        ]);
        if ($share_safari_faq_model != null) {
            $this->share_safari_faq_model = $share_safari_faq_model;
            $this->share_safari_id = $this->share_safari_faq_model->share_safari_id;
            $this->version = $this->share_safari_faq_model->version;
            $this->question = $this->share_safari_faq_model->question;
            $this->answer = $this->share_safari_faq_model->answer;
            $this->position = $this->share_safari_faq_model->position;
            $this->status = $this->share_safari_faq_model->status;
            $this->master_faq_id = $this->share_safari_faq_model->master_faq_id;

        }
    }

    public function rules()
    {
        return [
            [['answer', 'question'], 'required'],
            [['share_safari_id', 'position', 'status','version'], 'integer'],
            [['answer'], 'string'],
            [['position'], 'default', 'value' => 0],
            [['question'], 'string', 'max' => 512],
            [['master_faq_id'],'integer'],

        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'position' => 'Position',
            'master_faq_id' => 'Master Faq Id',
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
        $this->share_safari_faq_model->share_safari_id = $this->share_safari_id;
        $this->share_safari_faq_model->master_faq_id = $this->master_faq_id;
        $this->share_safari_faq_model->version = $this->version;
        $this->share_safari_faq_model->question = $this->question;
        $this->share_safari_faq_model->answer = $this->answer;
        $this->share_safari_faq_model->position = $this->position;
        $this->share_safari_faq_model->status = $this->status;
    }
}
