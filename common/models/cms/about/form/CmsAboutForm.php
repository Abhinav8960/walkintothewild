<?php

namespace common\models\cms\about\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\about\CmsAbout;

/**
 * Class CmsAboutForm
 * @package common\models\cms\about\form
 *
 * Handles the creation and updating of CmsAbout models
 */
class CmsAboutForm extends Model
{
    public $name;
    public $description;
    public $status;
    public $statusOptions = [];
    public $aboutModel;

    public function __construct(CmsAbout $aboutModel = null, $config = [])
    {
        parent::__construct($config);

        if ($aboutModel === null) {
            $this->aboutModel = new CmsAbout();
        } else {
            $this->aboutModel = $aboutModel;
            $this->name = $this->aboutModel->name;
            $this->description = $this->aboutModel->description;
            $this->status = $this->aboutModel->status;
        }

        $this->statusOptions = GeneralModel::statusOption();
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
        $this->aboutModel->name = $this->name;
        $this->aboutModel->description = $this->description;
        $this->aboutModel->status = $this->status;
    }
}
