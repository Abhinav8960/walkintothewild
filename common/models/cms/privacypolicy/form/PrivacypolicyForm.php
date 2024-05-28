<?php

namespace common\models\cms\about\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\privacypolicy\Privacypolicy;

/**
 * Class PrivacypolicyForm
 * @package common\models\cms\privactpolicy\form
 *
 * Handles the creation and updating of About models
 */
class PrivacypolicyForm extends Model
{
    public $name;
    public $description;
    public $status;
    public $status_option = [];
    public $privacypolicy_model;

    public function __construct(Privacypolicy $privacypolicy_model = null, $config = [])
    {
        parent::__construct($config);

        if ($privacypolicy_model === null) {
            $this->privacypolicy_model = new Privacypolicy();
        } else {
            $this->privacypolicy_model = $privacypolicy_model;
            $this->name = $this->privacypolicy_model->name;
            $this->description = $this->privacypolicy_model->description;
            $this->status = $this->privacypolicy_model->status;
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
            [['name'], 'string', 'max' => 512],
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
        $this->privacypolicy_model->name = $this->name;
        $this->privacypolicy_model->description = $this->description;
        $this->privacypolicy_model->status = $this->status;
    }
}
