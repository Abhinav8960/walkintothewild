<?php

namespace api\models\sharesafari\form;

use common\models\GeneralModel;
use yii\base\Model;

class SharedSafariVersionForm extends \frontend\models\form\SharedSafariVersionForm
{
    public function rules()
    {
        return [

            [['share_safari_title', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'start_date', 'end_date', 'safari_plan'], 'required', 'message' => '{attribute} : Required'],
            [['host_user_id',  'host_type', 'park_id', 'share_safari_agenda_id', 'tour_duration', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'status', 'type'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['share_safari_title'], 'string', 'max' => 255],
            [['safari_plan'], 'string'],
            [['shared_safari_image'], 'image', 'extensions' => ['png', 'jpeg', 'jpg'],],
            ['estimate_price_max', 'compare', 'compareAttribute' => 'estimate_price_min', 'operator' => '>='],
            ['total_seat', 'compare', 'compareAttribute' => 'share_seat', 'operator' => '>'],
            [['safari_plan'], 'validateContent'],
            [['estimate_price_min', 'estimate_price_max'], 'integer', 'max' => 1000000],
            [['total_seat'], 'integer', 'max' => 6],
            [['no_of_safari'], 'integer', 'max' => 10],

            ['start_date', 'compare', 'compareValue' => date("Y-m-d"), 'operator' => '>='],
            ['start_date', 'compare', 'compareValue' => date("Y-m-d", strtotime('+1 year')), 'operator' => '<='],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>'],
            ['end_date', 'compare', 'compareValue' => date("Y-m-d", strtotime('+2 year')), 'operator' => '<='],


            [['version'], 'integer'],
            [['image_filepath'], 'string'],
            [['safari_operator_id', 'user_id'], 'integer'],

            ['share_safari_agenda_id', 'in', 'range' => GeneralModel::share_safari_agenda()]

        ];
    }
}
