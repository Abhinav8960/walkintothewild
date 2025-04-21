<?php

namespace common\models\packageapproval\form;

use common\models\master\faq\MasterFaq;
use Yii;
use common\models\packageapproval\PackageFaq;

class PackageFaqSelectForm extends \yii\base\Model
{
    public $package_id;
    public $faq_id;
    public $position;
    public $answer;
    public $question;
    public $status;
    public $package_faq_select_model;
    public $action_url;
    public $action_validate_url;


    /**
     * @param [type] $package_faq_select_model
     */
    public function __construct(PackageFaq $package_faq_select_model = null)
    {
        $this->package_faq_select_model = Yii::createObject([
            'class' => PackageFaq::className()
        ]);
        if ($package_faq_select_model != null) {
            $this->package_faq_select_model = $package_faq_select_model;
            $this->package_id = $this->package_faq_select_model->package_id;
            $this->faq_id = $this->package_faq_select_model->faq_id;
            $this->status = $this->package_faq_select_model->status;
        }
    }

    public function rules()
    {
        return [
            [['faq_id'], 'required'],
            [['package_id', 'position', 'status'], 'integer'],
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
        $this->package_faq_select_model->package_id = $this->package_id;
        $this->package_faq_select_model->faq_id = $this->faq_id;
        if ($this->faq_id) {
            $faq = MasterFaq::find()->where(['id' => $this->faq_id])->limit(1)->one();
            $this->package_faq_select_model->question = $faq->question;
            $this->package_faq_select_model->answer = $faq->answer;
            $this->package_faq_select_model->position = $faq->position;
        }
        $this->package_faq_select_model->status = $this->status;
    }
}
