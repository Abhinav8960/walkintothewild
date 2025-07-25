<?php

namespace common\models\sharesafari\form;

use common\models\partnergallery\PartnerGallery;
use Yii;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariParklist;
use common\models\sharesafari\ShareSafariVersion;

class ShareSeatForm extends \yii\base\Model
{
    public $share_seat;
    public $total_seat;
    public $share_seat_form_model;

    public function __construct(?ShareSafariVersion $share_seat_form_model = null)
    {
        $this->share_seat_form_model = Yii::createObject([
            'class' => ShareSafariVersion::class
        ]);

        if ($share_seat_form_model  != '') {
            $this->share_seat_form_model = $share_seat_form_model;
            $this->total_seat =  $this->share_seat_form_model->total_seat;
            $this->share_seat =  $this->share_seat_form_model->share_seat;
        }
    }

    public function rules()
    {
        return [
            [['share_seat'], 'required'],
            [['total_seat', 'share_seat'], 'integer'],
            ['share_seat', 'compare', 'compareAttribute' => 'total_seat', 'operator' => '<=', 'message' => "Available Seat must be less than or equal to Total Seat"],
        ];
    }


    /**
     * Initialize Form Model
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->share_seat_form_model->share_seat = $this->share_seat;
    }
}
