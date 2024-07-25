<?php

namespace common\models\sharesafari\form;

use common\models\master\faq\MasterFaq;
use common\models\sharesafari\ShareSafariFaq;
use Yii;

class ShareSafariFaqSelectForm extends \yii\base\Model
{
    public $share_safari_id;
    public $faq_id;
    public $position;
    public $answer;
    public $question;
    public $status;
    public $share_safari_faq_select_model;
    public $action_url;
    public $action_validate_url;


    /**
     * @param [type] $share_safari_faq_select_model
     */
    public function __construct(ShareSafariFaq $share_safari_faq_select_model = null)
    {
        $this->share_safari_faq_select_model = Yii::createObject([
            'class' => ShareSafariFaq::className()
        ]);
        if ($share_safari_faq_select_model != null) {
            $this->share_safari_faq_select_model = $share_safari_faq_select_model;
            $this->share_safari_id = $this->share_safari_faq_select_model->share_safari_id;
            $this->faq_id = $this->share_safari_faq_select_model->faq_id;
            $this->status = $this->share_safari_faq_select_model->status;
        }
    }

    public function rules()
    {
        return [
            [['faq_id'], 'required'],
            [['share_safari_id', 'position', 'status'], 'integer'],
            [['position', 'question', 'answer'], 'safe'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'faq_id' => 'Faq',
            'answer' => 'Answer',
            'position' => 'Position',
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
        $this->share_safari_faq_select_model->share_safari_id = $this->share_safari_id;
        $this->share_safari_faq_select_model->faq_id = $this->faq_id;
        if ($this->faq_id) {
            $faq = MasterFaq::find()->where(['id' => $this->faq_id])->limit(1)->one();
            $this->share_safari_faq_select_model->question = $faq->question;
            $this->share_safari_faq_select_model->answer = $faq->answer;
            $this->share_safari_faq_select_model->position = $faq->position;
        }
        $this->share_safari_faq_select_model->status = $this->status;
    }
}
