<?php

namespace frontend\models\form;

use Yii;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariParklist;

class CreateDepartureForm extends \yii\base\Model
{
    public $type;
    public $shared_safari_departure_model;
    public $host_user_id;
    public $host_type;
    public $park_list;
    public $park_id;
    public $share_safari_agenda_id;
    public $no_of_safari;
    public $start_date;
    public $end_date;
    public $stay_category_id;
    public $cost_per_person;
    public $safari_plan;
    public $total_seat;
    public $tour_duration;
    public $status;
    public $share_safari_inclusion;
    public $share_safari_exclusion;
    public $share_safari_included;
    public $share_safari_terms_condtition;
    public $privacy_policy;
    public $change_policy;
    public $what_you_must_carry;
    public $date_change_policy;
    public $refund_policy;
    public $getting_there;

    public $action_url;
    public $action_validate_url;



    public function __construct(ShareSafari $shared_safari_departure_model = null)
    {
        $this->shared_safari_departure_model = Yii::createObject([
            'class' => ShareSafari::className()
        ]);
        if ($shared_safari_departure_model  != '') {
            $this->shared_safari_departure_model = $shared_safari_departure_model;

            $this->type =  $this->shared_safari_departure_model->type;
            $this->host_user_id =  $this->shared_safari_departure_model->host_user_id;
            $this->host_type =  $this->shared_safari_departure_model->host_type;

            $this->share_safari_agenda_id =  $this->shared_safari_departure_model->share_safari_agenda_id;
            $this->no_of_safari =  $this->shared_safari_departure_model->no_of_safari;
            $this->start_date =  $this->shared_safari_departure_model->start_date;
            $this->end_date =  $this->shared_safari_departure_model->end_date;
            $this->stay_category_id =  $this->shared_safari_departure_model->stay_category_id;
            $this->cost_per_person =  $this->shared_safari_departure_model->cost_per_person;
            $this->safari_plan =  $this->shared_safari_departure_model->safari_plan;
            $this->total_seat =  $this->shared_safari_departure_model->total_seat;
            $this->tour_duration =  $this->shared_safari_departure_model->tour_duration;
            $this->status =  $this->shared_safari_departure_model->status;

            $this->share_safari_inclusion = $this->shared_safari_departure_model->share_safari_inclusion;
            $this->share_safari_exclusion = $this->shared_safari_departure_model->share_safari_exclusion;
            $this->share_safari_terms_condtition = $this->shared_safari_departure_model->share_safari_terms_condtition;
            $this->privacy_policy = $this->shared_safari_departure_model->privacy_policy;
            $this->change_policy = $this->shared_safari_departure_model->change_policy;
            $this->what_you_must_carry = $this->shared_safari_departure_model->what_you_must_carry;
            $this->date_change_policy = $this->shared_safari_departure_model->date_change_policy;
            $this->refund_policy = $this->shared_safari_departure_model->refund_policy;
            $this->getting_there = $this->shared_safari_departure_model->getting_there;


            $this->park_list =  ShareSafariParklist::find()->select('park_id')->where(['share_safari_id' => $this->shared_safari_departure_model->id])->column(); //abb multiple park ko store karenge
        }
    }

    public function rules()
    {
        return [
            [['host_type', 'park_list', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'cost_per_person', 'total_seat', 'start_date', 'end_date', 'safari_plan'], 'required', 'message' => 'Required'],
            [['host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'cost_per_person', 'total_seat', 'tour_duration', 'status', 'type'], 'integer'],
            [['start_date', 'end_date', 'park_list'], 'safe'],
            [['safari_plan'], 'string'],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>'],
            [['safari_plan'], 'validateContent'],
        ];
    }



    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['inclusion'] = ['share_safari_inclusion', 'share_safari_exclusion', 'share_safari_included'];
        $scenarios['policy_info'] = ['share_safari_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy'];
        $scenarios['getting_there'] = ['getting_there'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host_user_id' => 'Host User ID',
            'host_type' => 'Host Type',
            'park_id' => 'Park ID',
            'share_safari_agenda_id' => 'Share Safari Agenda ID',
            'no_of_safari' => 'No Of Safari',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'stay_category_id' => 'Stay Category ID',
            'cost_per_person' => 'Cost Per Person',
            'tour_duration' => 'Total Duration',
            'safari_plan' => 'Safari Plan',
            'total_seat' => 'Total Seat',
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

        $this->shared_safari_departure_model->type = $this->type;
        $this->shared_safari_departure_model->host_user_id = $this->host_user_id;
        $this->shared_safari_departure_model->host_type = $this->host_type; // iss bhi check karna ha
        $this->shared_safari_departure_model->type = $this->type;
        $this->shared_safari_departure_model->share_safari_agenda_id = $this->share_safari_agenda_id;
        $this->shared_safari_departure_model->no_of_safari = $this->no_of_safari;
        $this->shared_safari_departure_model->start_date = $this->start_date;
        $this->shared_safari_departure_model->end_date = $this->end_date;
        $this->shared_safari_departure_model->stay_category_id = $this->stay_category_id;
        $this->shared_safari_departure_model->cost_per_person = $this->cost_per_person;
        $this->shared_safari_departure_model->safari_plan = $this->safari_plan;
        $this->shared_safari_departure_model->total_seat = $this->total_seat;
        $this->shared_safari_departure_model->tour_duration = abs((round(strtotime($this->end_date) - strtotime($this->start_date)) / (60 * 60 * 24)));
        $this->shared_safari_departure_model->status = $this->status;


        $this->shared_safari_departure_model->share_safari_inclusion = $this->share_safari_inclusion;
        $this->shared_safari_departure_model->share_safari_exclusion = $this->share_safari_exclusion;
        $this->shared_safari_departure_model->share_safari_terms_condtition = $this->share_safari_terms_condtition;
        $this->shared_safari_departure_model->privacy_policy = $this->privacy_policy;
        $this->shared_safari_departure_model->change_policy = $this->change_policy;
        $this->shared_safari_departure_model->what_you_must_carry = $this->what_you_must_carry;
        $this->shared_safari_departure_model->date_change_policy = $this->date_change_policy;
        $this->shared_safari_departure_model->refund_policy = $this->refund_policy;
        $this->shared_safari_departure_model->getting_there = $this->getting_there;

        if ($this->park_list) {
            $this->shared_safari_departure_model->park_id = $this->park_list[0];
        }

        if ($this->shared_safari_departure_model->slug == '') {
            $without_space_string = str_replace(' ', '-', strtolower($this->shared_safari_departure_model->safarioperator->business_name));
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $without_space_string);
            $slug =  $string . '-' . substr(sha1(mt_rand()), 17, 6) . '-' . $this->shared_safari_departure_model->host_user_id . time() . '-shared-safari';
            $this->shared_safari_departure_model->slug = $slug;
        }
    }


    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 100) {
            $this->addError($attribute, 'Please provide content within 100 words.');
        }
    }
}
