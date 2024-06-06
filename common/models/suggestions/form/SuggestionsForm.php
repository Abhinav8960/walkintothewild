<?php

namespace common\models\suggestions\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\suggestions\Suggestions;

/**
 * Class SuggestionsForm
 * @package common\models\Suggestions\form
 *
 * Handles the creation and updating of Suggestions models
 */
class SuggestionsForm extends Model
{
    public $park_id;
    public $master_suggestion_id;
    public $you_are_id;
    public $user_agent;
    public $ip_address;
    public $details;
    public $status;
    public $status_option = [];
    public $suggestion_model;
    public $action_url;
    public $action_validate_url;

    public function __construct(Suggestions $suggestion_model = null, $config = [])
    {
        parent::__construct($config);

        if ($suggestion_model === null) {
            $this->suggestion_model = new Suggestions();
        } else {
            $this->suggestion_model = $suggestion_model;
            $this->park_id = $this->suggestion_model->park_id;
            $this->master_suggestion_id = $this->suggestion_model->master_suggestion_id;
            $this->you_are_id = $this->suggestion_model->you_are_id;
            $this->details = $this->suggestion_model->details;
            $this->user_agent = $this->suggestion_model->user_agent;
            $this->ip_address = $this->suggestion_model->ip_address;
            $this->status = $this->suggestion_model->status;
        }

        $this->status_option = GeneralModel::statusOption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_suggestion_id', 'you_are_id', 'details'], 'required'],
            [['status', 'park_id'], 'integer'],
            [['details'], 'string'],
            [['details'], 'validateMaxWords', 'params' => ['max' => 500]],
            [['status'], 'default', 'value' => 1],
            [['details'], 'safe'],
            [['user_agent'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 45],
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
            'park_id' => 'Park',
            'details' => 'Details',
            'master_suggestion_id' => 'Select Category',
            'you_are_id' => 'You Are',
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
        $this->suggestion_model->park_id = $this->park_id;
        $this->suggestion_model->master_suggestion_id = $this->master_suggestion_id;
        $this->suggestion_model->you_are_id = $this->you_are_id;
        $this->suggestion_model->details = $this->details;
        $this->suggestion_model->user_agent = Yii::$app->request->userAgent;
        $this->suggestion_model->ip_address = $this->ip_address;
        $this->suggestion_model->status = $this->status;
    }
}
