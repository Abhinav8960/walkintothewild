<?php

namespace common\models\sharesafari\form;

use Yii;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariHistory;


class ShareSafariCreateForm extends \yii\base\Model
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
    public $shared_safari_image;
    public $website_url;

    public $action_url;
    public $action_validate_url;


    public function __construct(ShareSafari $shared_safari_model = null)
    {
        $this->shared_safari_model = Yii::createObject([
            'class' => ShareSafari::className()
        ]);
        if ($shared_safari_model  != '') {
            $this->shared_safari_model = $shared_safari_model;

            $this->host_user_id =  $this->shared_safari_model->host_user_id;
            $this->host_type =  $this->shared_safari_model->host_type;
            $this->park_id =  $this->shared_safari_model->park_id;
            $this->share_safari_agenda_id =  $this->shared_safari_model->share_safari_agenda_id;
            $this->no_of_safari =  $this->shared_safari_model->no_of_safari;
            $this->start_date =  $this->shared_safari_model->start_date;
            $this->end_date =  $this->shared_safari_model->end_date;
            $this->stay_category_id =  $this->shared_safari_model->stay_category_id;
            $this->estimate_price_min =  $this->shared_safari_model->estimate_price_min;
            $this->estimate_price_max =  $this->shared_safari_model->estimate_price_max;
            $this->safari_plan =  $this->shared_safari_model->safari_plan;
            $this->total_seat =  $this->shared_safari_model->total_seat;
            $this->share_seat =  $this->shared_safari_model->share_seat;
            $this->website_url =  $this->shared_safari_model->website_url;
            $this->status =  $this->shared_safari_model->status;
        }
    }

    public function rules()
    {
        return [
            [['host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'start_date', 'end_date', 'safari_plan'], 'required', 'message' => 'Required'],
            [['host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'status'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [
                ['website_url'], 'required', 'when' => function ($model) {
                    return $model->host_type != 4;
                }
            ],
            [['safari_plan'], 'string'],
            [['shared_safari_image'], 'image', 'extensions' => ['png', 'jpeg', 'jpg'],],
            ['estimate_price_max', 'compare', 'compareAttribute' => 'estimate_price_min', 'operator' => '>='],
            ['total_seat', 'compare', 'compareAttribute' => 'share_seat', 'operator' => '>='],
            ['end_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '>'],
            [['safari_plan'], 'validateContent'],
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
        $this->shared_safari_model->website_url = $this->website_url;
        $this->shared_safari_model->status = $this->status;

        if ($this->shared_safari_model->slug == '') {
            $without_space_string = str_replace(' ', '-', strtolower($this->shared_safari_model->user->name));
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $without_space_string);
            $slug =  $string . '-' . substr(sha1(mt_rand()), 17, 6) . '-' . $this->shared_safari_model->host_user_id . time() . '-shared-safari';
            $this->shared_safari_model->slug = $slug;
        }
    }


    /**
     * Safari History
     */
    public function safariHistory()
    {
        $history = new ShareSafariHistory();
        $history->setAttributes($this->shared_safari_model->attributes, false);
        $history->parent_id = $this->shared_safari_model->id;
        $history->id = NULL;
        $history->save(false);
    }

    public function UploadFiles($id)
    {
        if ($this->shared_safari_image) {
            $storagePath = Yii::$app->params['datapath'] . '/Shared_Image';

            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $storagePath = $storagePath . '/' . $this->shared_safari_model->id;
            if (!file_exists($storagePath)) {
                mkdir($storagePath);
                chmod($storagePath, 0777);
            }
            $fileName = 'shared_safari_image' . time() . '.' . $this->shared_safari_image->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($this->shared_safari_image->saveAs($filePath)) {
                $this->shared_safari_model->image = $fileName;
                $this->shared_safari_model->save(false);
            }
        }
    }

    public function validateContent($attribute, $params)
    {
        $wordCount = str_word_count($this->$attribute);
        if ($wordCount >= 100) {
            $this->addError($attribute, 'Please provide content within 100 words.');
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
}
