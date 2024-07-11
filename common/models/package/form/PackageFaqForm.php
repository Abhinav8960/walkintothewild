<?php

namespace common\models\package\form;

use Yii;
use common\models\package\PackageFaq;

class PackageFaqForm extends \yii\base\Model
{
    public $package_id;
    public $question;
    public $answer;
    public $position;
    public $package_faq_model;
    public $action_url;
    public $action_validate_url;


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
            $this->question = $this->package_faq_model->question;
            $this->answer = $this->package_faq_model->answer;
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
            [['question'], 'string', 'max' => 512],
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
        $this->package_faq_model->question = $this->question;
        $this->package_faq_model->answer = $this->answer;
        $this->package_faq_model->position = $this->position;
        $this->package_faq_model->status = $this->status;
    }

    /**
     * Upload Banner image
     *
     * @return void
     */
    public function UploadFile()
    {
        if ($this->package_image) {
            $storagePath = Yii::$app->params['datapath'] . '/package';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->package_faq_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }

            $fileName = 'package_image' . '-' . time() . '.' . $this->package_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->package_image->saveAs($filePath)) {
                $this->package_faq_model->package_image = $fileName;
                $this->package_faq_model->save(false);
            }
        }
    }
}
