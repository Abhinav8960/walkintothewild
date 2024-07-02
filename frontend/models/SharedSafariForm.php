<?php

namespace frontend\models;

use common\interfaces\StatusInterface;
use common\models\sharesafari\ShareSafari;
use Yii;


class SharedSafariForm extends \yii\base\Model
{
    public $shared_safari_model;
    public $host_user_id;
    public $host_type;
    public $park_id;
    public $share_safari_agenda_id;
    public $no_of_safari;
    public $start_date;
    public $end_date;
    public $stay_category_id;
    public $estimate_price_min;
    public $estimate_price_max;
    public $safari_plan;
    public $total_seat;
    public $share_seat;
    public $status;

    public $action_url;
    public $action_validate_url;


    public function __construct(ShareSafari $shared_safari_model = null)
    {
        $this->shared_safari_model = Yii::createObject([
            'class' => ShareSafari::className()
        ]);
    }

    public function rules()
    {
        return [
            [['host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'start_date', 'end_date', 'safari_plan'], 'required'],
            [['host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'status'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['safari_plan'], 'string'],
        ];
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
            'estimate_price_min' => 'Estimate Price Min',
            'estimate_price_max' => 'Estimate Price Max',
            'safari_plan' => 'Safari Plan',
            'total_seat' => 'Total Seat',
            'share_seat' => 'Share Seat',
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
        $this->shared_safari_model->host_user_id = $this->host_user_id;
        $this->shared_safari_model->host_type = $this->host_type;
        $this->shared_safari_model->park_id = $this->park_id;
        $this->shared_safari_model->share_safari_agenda_id = $this->share_safari_agenda_id;
        $this->shared_safari_model->no_of_safari = $this->no_of_safari;
        $this->shared_safari_model->start_date = $this->start_date;
        $this->shared_safari_model->end_date = $this->end_date;
        $this->shared_safari_model->stay_category_id = $this->stay_category_id;
        $this->shared_safari_model->estimate_price_min = $this->estimate_price_min;
        $this->shared_safari_model->estimate_price_max = $this->estimate_price_max;
        $this->shared_safari_model->safari_plan = $this->safari_plan;
        $this->shared_safari_model->total_seat = $this->total_seat;
        $this->shared_safari_model->share_seat = $this->share_seat;
        $this->shared_safari_model->status = $this->status;
    }
}
