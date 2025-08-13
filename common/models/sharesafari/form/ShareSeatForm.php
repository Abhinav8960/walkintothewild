<?php

namespace common\models\sharesafari\form;

use Yii;
use common\models\sharesafari\ShareSafariVersion;

class ShareSeatForm extends \yii\base\Model
{
    public $total_seat;
    public $self_occupied_seat;
    public $share_seat_form_model;

    public function __construct(?ShareSafariVersion $share_seat_form_model = null)
    {
        $this->share_seat_form_model = Yii::createObject([
            'class' => ShareSafariVersion::class
        ]);

        if ($share_seat_form_model  != '') {
            $this->share_seat_form_model = $share_seat_form_model;
            $this->total_seat =  $this->share_seat_form_model->total_seat;
            $this->self_occupied_seat =  $this->share_seat_form_model->self_occupied_seat;
        }
    }

    public function rules()
    {
        return [
            [['total_seat', 'self_occupied_seat'], 'integer'],
        ];
    }


    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->share_seat_form_model->total_seat = $this->total_seat;
        $this->share_seat_form_model->self_occupied_seat = $this->self_occupied_seat;
    }
}
