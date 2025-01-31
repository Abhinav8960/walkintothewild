<?php

namespace api\models\sharesafari\form;

class CreateDepartureForm extends \frontend\models\form\CreateDepartureForm
{
    
    public function rules()
    {
        return [
            [['share_safari_title', 'host_type', 'park_list', 'share_safari_agenda_id', 'no_of_safari', 'cost_per_person', 'total_seat', 'share_seat', 'start_date', 'end_date', 'safari_plan'], 'required', 'message' => '{attribute}:Required'],
            [['host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'cost_per_person', 'total_seat', 'share_seat', 'tour_duration', 'status', 'type'], 'integer'],
            [['start_date', 'end_date', 'park_list', 'rand_text'], 'safe'],
            [['share_safari_title'], 'string', 'max' => 255],
            [['safari_plan'], 'string'],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>'],
            [['safari_plan'], 'validateContent'],
            [['no_of_safari', 'total_seat', 'share_seat'], 'integer', 'max' => 100],
            ['cost_per_person', 'integer', 'max' => 1000000],
            ['cut_off_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '<'],
            [['breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'], 'safe'],
            [['breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included','mail_sent'], 'default', 'value' => 0],
            ['share_seat', 'compare', 'compareAttribute' => 'total_seat', 'operator' => '<=', 'message' => "Available Seat must be less than or equal to Total Seat"],

        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['inclusion'] = ['share_safari_inclusion', 'share_safari_exclusion', 'share_safari_included', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'];
        $scenarios['policy_info'] = ['share_safari_terms_condtition', 'privacy_policy', 'change_policy', 'what_you_must_carry', 'date_change_policy', 'refund_policy', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'];
        $scenarios['getting_there'] = ['getting_there', 'breakfast_included', 'lunch_included', 'dinner_included', 'meal_not_included'];
        return $scenarios;
    }

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
            'stay_category_id' => 'Accommodation',
            'cost_per_person' => 'Cost Per Person',
            'tour_duration' => 'Total Duration',
            'safari_plan' => 'Safari Plan',
            'total_seat' => 'Total Seat',
            'status' => 'Status',
        ];
    }

}
