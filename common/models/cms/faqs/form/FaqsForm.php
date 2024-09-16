<?php

namespace common\models\cms\faqs\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\faqs\Faqs;

/**
 * Class Faq
 * @package common\models\cms\faqs\form
 *
 * Handles the creation and updating of Faq models
 */
class FaqsForm extends Model
{
    public $category_id;
    public $category_id_option = [];
    public $question;
    public $answer;
    public $status;
    public $status_option = [];
    public $faqs_model;

    public function __construct(Faqs $faqs_model = null, $config = [])
    {
        parent::__construct($config);

        if ($faqs_model === null) {
            $this->faqs_model = new Faqs();
        } else {
            $this->faqs_model = $faqs_model;
            $this->category_id = $this->faqs_model->category_id;
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
            [['category_id','question','answer'], 'required'],
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
            'category_id' => 'Category',
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
        $this->faqs_model->category_id = $this->category_id;
        $this->faqs_model->question = $this->question;
        $this->faqs_model->answer = $this->answer;
        $this->faqs_model->status = $this->status;
    }
}
