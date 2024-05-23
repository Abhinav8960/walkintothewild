<?php

namespace common\models\cms\about\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\about\About;

/**
 * Class AboutForm
 * @package common\models\cms\about\form
 *
 * Handles the creation and updating of About models
 */
class AboutForm extends Model
{
    public $name;
    public $description;
    public $status;
    public $status_option = [];
    public $about_model;

    public function __construct(About $about_model = null, $config = [])
    {
        parent::__construct($config);

        if ($about_model === null) {
            $this->about_model = new About();
        } else {
            $this->about_model = $about_model;
            $this->name = $this->about_model->name;
            $this->description = $this->about_model->description;
            $this->status = $this->about_model->status;
        }

        $this->status_option = GeneralModel::statusOption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 251],
            [['description'], 'string'],
            [['description'], 'validateMaxWords', 'params' => ['max' => 500]],          
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
            'name' => 'Name',
            'description' => 'Description',
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
        $this->about_model->name = $this->name;
        $this->about_model->description = $this->description;
        $this->about_model->status = $this->status;
    }
}
