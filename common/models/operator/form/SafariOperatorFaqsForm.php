<?php

namespace common\models\operator\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorFaq;

class SafariOperatorFaqsForm extends Model
{
    public $safari_operator_id;
    public $question;
    public $answer;
    public $status;
    public $status_option = [];
    public $faqs_model;

    public function __construct(SafariOperatorFaq $faqs_model = null, $config = [])
    {
        parent::__construct($config);

        if ($faqs_model === null) {
            $this->faqs_model = new SafariOperatorFaq();
        } else {
            $this->faqs_model = $faqs_model;
            $this->safari_operator_id = $this->faqs_model->safari_operator_id;
            $this->question = $this->faqs_model->question;
            $this->answer = $this->faqs_model->answer;
            $this->status = $this->faqs_model->status;
        }

        $this->status_option = GeneralModel::newstatusOption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_id','question','answer'], 'required'],
            [['status'], 'integer'],
            [['question'], 'string', 'max' => 512],
            [['answer'], 'validateMaxWords', 'params' => ['max' => 100]],
            [['status'], 'default', 'value' => 1],
            [['description'], 'safe'],
        ];
    }
    public function validateMaxWords($attribute, $params)
    {
        $maxWords = $params['max'];
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount > $maxWords) {
            $this->addError($attribute, "The $attribute must not exceed $maxWords words.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question' => 'Question',
            'answer' => 'Answer',
            'status' => 'Status',
        ];
    }

    /**
     * Initialize form values
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->faqs_model->safari_operator_id = $this->safari_operator_id;
        $this->faqs_model->question = $this->question;
        $this->faqs_model->answer = $this->answer;
        $this->faqs_model->status = $this->status;
    }
}
