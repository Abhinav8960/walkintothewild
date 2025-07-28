<?php

namespace frontend\models\form;

use Yii;
use common\interfaces\StatusInterface;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariVersion;

class SharedSafariVersionForm extends \yii\base\Model
{
    public $share_safari_version_model;

    public $share_safari_title;
    public $host_user_id;
    public $share_safari_request_id;
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
    public $shared_safari_image;
    public $website_url;
    public $type;
    public $tour_duration;

    public $action_url;
    public $action_validate_url;

    public $created_at;

    public $share_safari_id;
    public $version;


    public function __construct(?ShareSafariVersion $share_safari_version_model = null)
    {
        $this->share_safari_version_model = Yii::createObject([
            'class' => ShareSafariVersion::class
        ]);

        $this->version = '1';
        if ($share_safari_version_model  != '') {
            $this->share_safari_version_model = $share_safari_version_model;

            $this->share_safari_id = $this->share_safari_version_model->share_safari_id;
            $this->version = $this->share_safari_version_model->version;

            $this->share_safari_title =  $this->share_safari_version_model->share_safari_title;
            $this->host_user_id =  $this->share_safari_version_model->host_user_id;
            $this->host_type =  $this->share_safari_version_model->host_type;
            $this->type =  $this->share_safari_version_model->type;
            $this->share_safari_request_id =  $this->share_safari_version_model->share_safari_request_id;
            $this->park_id =  $this->share_safari_version_model->park_id;
            $this->share_safari_agenda_id =  $this->share_safari_version_model->share_safari_agenda_id;
            $this->no_of_safari =  $this->share_safari_version_model->no_of_safari;
            $this->start_date =  $this->share_safari_version_model->start_date;
            $this->end_date =  $this->share_safari_version_model->end_date;
            $this->stay_category_id =  $this->share_safari_version_model->stay_category_id;
            $this->estimate_price_min =  $this->share_safari_version_model->estimate_price_min;
            $this->estimate_price_max =  $this->share_safari_version_model->estimate_price_max;
            $this->safari_plan =  $this->share_safari_version_model->safari_plan;
            $this->total_seat =  $this->share_safari_version_model->total_seat;
            $this->share_seat =  $this->share_safari_version_model->share_seat;
            $this->website_url =  $this->share_safari_version_model->website_url;
            $this->tour_duration =  $this->share_safari_version_model->tour_duration;
            $this->status =  $this->share_safari_version_model->status;
            $this->created_at =  $this->share_safari_version_model->created_at;
        }
    }

    public function rules()
    {
        return [

            [['share_safari_title', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'start_date', 'end_date', 'safari_plan'], 'required', 'message' => '{attribute} : Required'],
            [['host_user_id', 'share_safari_request_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'tour_duration', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'status', 'type'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['share_safari_title'], 'string', 'max' => 255],
            // [
            //     ['website_url'], 'required', 'when' => function ($model) {
            //         return $model->host_type != 4;
            //     }
            // ],
            [['safari_plan'], 'string'],
            [['shared_safari_image'], 'image', 'extensions' => ['png', 'jpeg', 'jpg'],],
            ['estimate_price_max', 'compare', 'compareAttribute' => 'estimate_price_min', 'operator' => '>='],
            ['total_seat', 'compare', 'compareAttribute' => 'share_seat', 'operator' => '>='],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>'],
            [['safari_plan'], 'validateContent'],
            [['estimate_price_min', 'estimate_price_max'], 'integer', 'max' => 1000000],
            // [['safari_plan'], 'validateMaxWords', 'params' => ['max' => 200]],
            [['created_at'], 'safe'],
            [['share_safari_id', 'version'], 'integer'],


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
            'id' => 'ID',
            'host_user_id' => 'Host User ID',
            'host_type' => 'Host Type',
            'park_id' => 'Park ID',
            'share_safari_agenda_id' => 'Share Safari Agenda ID',
            'no_of_safari' => 'No Of Safari',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'stay_category_id' => 'Stay Category ID',
            'estimate_price_min' => 'Price Min',
            'estimate_price_max' => 'Price Max',
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

        $this->share_safari_version_model->host_user_id = $this->host_user_id;
        $this->share_safari_version_model->share_safari_title = $this->share_safari_title;
        $this->share_safari_version_model->host_type = $this->host_type;
        $this->share_safari_version_model->type = $this->type;
        $this->share_safari_version_model->share_safari_request_id = $this->share_safari_request_id;
        $this->share_safari_version_model->park_id = $this->park_id;
        $this->share_safari_version_model->share_safari_agenda_id = $this->share_safari_agenda_id;
        $this->share_safari_version_model->no_of_safari = $this->no_of_safari;
        $this->share_safari_version_model->start_date = $this->start_date;
        $this->share_safari_version_model->end_date = $this->end_date;
        $this->share_safari_version_model->stay_category_id = $this->stay_category_id;
        $this->share_safari_version_model->estimate_price_min = $this->estimate_price_min;
        $this->share_safari_version_model->estimate_price_max = $this->estimate_price_max;
        $this->share_safari_version_model->safari_plan = $this->safari_plan;
        $this->share_safari_version_model->total_seat = $this->total_seat;

        if ($this->status == ShareSafari::STATUS_FULL_SEAT) {
            $this->share_safari_version_model->share_seat = 0;
        } else {
            $this->share_safari_version_model->share_seat = $this->share_seat;
        }

        $this->share_safari_version_model->website_url = $this->website_url;


        $this->share_safari_version_model->tour_duration = abs((round(strtotime($this->end_date) - strtotime($this->start_date)) / (60 * 60 * 24))) + 1;
        $this->share_safari_version_model->status = $this->status;
        if ($this->share_safari_id == null) {
            $this->share_safari_id = $this->getShareSafariId();
        }

        $this->share_safari_version_model->share_safari_id = $this->share_safari_id;
        $this->share_safari_version_model->version = $this->version;
    }



    public function UploadFiles($id)
    {


        if ($this->shared_safari_image) {
            $storagePath = 'share_safari' . '/' . date('ym', $this->created_at);
            $fileName =  $this->share_safari_version_model->id . '_' . time() . '.' . $this->shared_safari_image->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                if ($etag =  \common\Helper\FsHelper::saveUploadedFile($this->shared_safari_image, $filePath, $fileName, true)) {
                    $this->share_safari_version_model->image = $fileName;
                    $this->share_safari_version_model->filepath = $filePath;
                    $this->share_safari_version_model->save(false);
                }
            }
        }
    }

    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 1000) {
            $this->addError($attribute, 'Please provide content within 1000 words.');
        }
    }

    public function getSharedseat()
    {
        if ($this->total_seat == 2) {
            return [1 => '1', '2' => 2];
        } elseif ($this->total_seat == 3) {
            return [1 => '1', '2' => 2, '3' => 3];
        } elseif ($this->total_seat == 4) {
            return [1 => '1', '2' => 2, '3' => 3, '4' => 4];
        } elseif ($this->total_seat == 5) {
            return  [1 => '1', '2' => 2, '3' => 3, '4' => 4, '5' => 5];
        } elseif ($this->total_seat == 6) {
            return [1 => '1', '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6];
        } else {
            return [];
        }
    }

    private function getShareSafariId()
    {
        $m = new ShareSafari();
        $m->share_safari_title = $this->share_safari_title;
        $m->slug = ShareSafari::generateUnqiueSlug($this->share_safari_title);
        $m->host_user_id = $this->host_user_id;
        $m->status = 0;
        $m->save(false);
        return $m->id;
    }
}
