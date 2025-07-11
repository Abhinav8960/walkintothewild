<?php

namespace common\models\package\form;

use Yii;
use common\models\package\PackageFaq;

class PackageFaqForm extends \yii\base\Model
{
    public $package_id;
    public $version;
    public $question;
    public $answer;
    public $position;
    public $status;
    public $package_faq_model;
    public $action_url;
    public $action_validate_url;
    public $master_faq_id;


    /**
     * @param [type] $package_faq_model
     */
    public function __construct(PackageFaq $package_faq_model = null)
    {
        $this->package_faq_model = Yii::createObject([
            'class' => PackageFaq::className()
        ]);
        if ($package_faq_model != null) {
            $this->package_faq_model = $package_faq_model;
            $this->package_id = $this->package_faq_model->package_id;
            $this->version = $this->package_faq_model->version;
            $this->question = $this->package_faq_model->question;
            $this->answer = $this->package_faq_model->answer;
            $this->master_faq_id = $this->package_faq_model->master_faq_id;
            $this->position = $this->package_faq_model->position;
            $this->status = $this->package_faq_model->status;
        }
    }

    public function rules()
    {
        return [
            [['answer', 'question'], 'required'],
            [['package_id', 'position', 'status'], 'integer'],
            [['answer'], 'string'],
            [['position'], 'default', 'value' => 0],
            [['question','version'], 'string', 'max' => 512],
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
        $this->package_faq_model->package_id = $this->package_id;
        $this->package_faq_model->master_faq_id = $this->master_faq_id;
        $this->package_faq_model->version = $this->version;
        $this->package_faq_model->question = $this->question;
        $this->package_faq_model->answer = $this->answer;
        $this->package_faq_model->position = $this->position;
        $this->package_faq_model->status = $this->status;
    }
}
