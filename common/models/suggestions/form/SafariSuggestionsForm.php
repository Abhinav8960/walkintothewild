<?php

namespace common\models\suggestions\form;

use Yii;
use yii\base\Model;
use common\models\GeneralModel;
use common\models\suggestions\SafariSuggestions;

/**
 * Class SafariSuggestionsForm
 * @package common\models\suggestions\form
 *
 * Handles the creation and updating of SafariSuggestions models
 */
class SafariSuggestionsForm extends Model
{
    public $park_id;
    public $master_suggestion_id;
    public $you_are_id;
    public $user_agent;
    public $ip_address;
    public $details;
    public $email;
    public $phone;
    public $name;
    public $status;
    public $is_approved;
    public $status_option = [];
    public $safari_suggestion_model;
    public $action_url;
    public $action_validate_url;

    public function __construct(SafariSuggestions $safari_suggestion_model = null, $config = [])
    {
        parent::__construct($config);

        if ($safari_suggestion_model === null) {
            $this->safari_suggestion_model = new SafariSuggestions();
        } else {
            $this->safari_suggestion_model = $safari_suggestion_model;
            $this->park_id = $this->safari_suggestion_model->park_id;
            $this->master_suggestion_id = $this->safari_suggestion_model->master_suggestion_id;
            $this->you_are_id = $this->safari_suggestion_model->you_are_id;
            $this->details = $this->safari_suggestion_model->details;
            $this->user_agent = $this->safari_suggestion_model->user_agent;
            $this->ip_address = $this->safari_suggestion_model->ip_address;
            $this->email = $this->safari_suggestion_model->email;
            $this->phone = $this->safari_suggestion_model->phone;
            $this->name = $this->safari_suggestion_model->name;
            $this->status = $this->safari_suggestion_model->status;
            $this->is_approved = $this->safari_suggestion_model->is_approved;
        }

        $this->status_option = GeneralModel::statusOption();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_suggestion_id', 'details'], 'required'],
            [['status', 'park_id'], 'integer'],
            [['details'], 'string'],
            [['details'], 'validateMaxWords', 'params' => ['max' => 500]],
            [['status'], 'default', 'value' => 1],
            [['is_approved'], 'default', 'value' => 0],
            [['details'], 'safe'],
            [['user_agent', 'email', 'name'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 10],
            [['phone'], 'match', 'pattern' => '/^[1234567890]\d{9}$/', 'message' => 'Invalid Phone number.'],
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
        $this->safari_suggestion_model->park_id = $this->park_id;
        $this->safari_suggestion_model->master_suggestion_id = $this->master_suggestion_id;
        $this->safari_suggestion_model->you_are_id = $this->you_are_id;
        $this->safari_suggestion_model->details = $this->details;
        $this->safari_suggestion_model->user_agent = Yii::$app->request->userAgent;
        $this->safari_suggestion_model->ip_address = $this->ip_address;
        $this->safari_suggestion_model->email = $this->email;
        $this->safari_suggestion_model->phone = $this->phone;
        $this->safari_suggestion_model->name = $this->name;
        $this->safari_suggestion_model->status = $this->status;
        $this->safari_suggestion_model->is_approved = $this->is_approved;
    }
}
