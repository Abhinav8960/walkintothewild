<?php

namespace common\models\cms\termscondition\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\cms\termscondition\Termscondition;

/**
 * Class TermsconditionForm
 * @package common\models\cms\termscondition\form
 *
 * Handles the creation and updating of Termscondition models
 */
class TermsconditionForm extends Model
{
    public $type;
    public $description;
    public $status;
    public $status_option = [];
    public $termscondition_model;

    public function __construct(Termscondition $termscondition_model = null, $config = [])
    {
        parent::__construct($config);

        if ($termscondition_model === null) {
            $this->termscondition_model = new Termscondition();
        } else {
            $this->termscondition_model = $termscondition_model;
            $this->type = $this->termscondition_model->type;
            $this->description = $this->termscondition_model->description;
            $this->status = $this->termscondition_model->status;
        }

        $this->status_option = GeneralModel::statusOption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['status'], 'integer'],
            [['type'], 'string', 'max' => 251],
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
            'type' => 'Type',
            'description' => 'Module Description',
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
        $this->termscondition_model->type = $this->type;
        $this->termscondition_model->description = $this->description;
        $this->termscondition_model->status = $this->status;
    }
}
