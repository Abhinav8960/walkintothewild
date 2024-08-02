<?php

namespace frontend\models;

use common\models\park\SafariParkRating;
use Yii;
use yii\helpers\ArrayHelper;

class SafariParkReviewForm extends \yii\base\Model
{
    public $rating_model;
    public $safari_park_id;
    public $rating;
    public $status;
    public $review;
    public $action_url;
    public $action_validate_url;


    public function __construct(SafariParkRating $rating_model = null)
    {
        $this->rating_model = Yii::createObject([
            'class' => SafariParkRating::className()
        ]);

        if ($rating_model != null) {
            $this->rating_model = $rating_model;
            $this->safari_park_id = $this->rating_model->safari_park_id;
            $this->rating = $this->rating_model->rating;
            $this->review = $this->rating_model->review;
        }
    }

    public function rules()
    {
        return [
            [['safari_park_id', 'rating', 'review',], 'required'],
            [['safari_park_id', 'rating', 'status'], 'integer'],
            ['review', 'string', 'max' => 255],
        ];
    }




    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'safari_park_id' => 'Safari Park',
            'user_id' => 'User ID',
            'safari_park_id' => 'Park ID',
            'rating' => 'Rating',
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
        $agent = new \Jenssegers\Agent\Agent();
        $agent->setUserAgent(Yii::$app->request->userAgent);

        $this->rating_model->user_id = Yii::$app->user->identity->id;
        $this->rating_model->safari_park_id = $this->safari_park_id;
        $this->rating_model->rating = $this->rating;
        $this->rating_model->review = $this->review;
        $this->rating_model->status = $this->status;

        $this->rating_model->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $this->rating_model->user_agent =  Yii::$app->request->userAgent;
        $this->rating_model->user_device  = $agent->device();
        $this->rating_model->user_platform = $agent->platform();
        $this->rating_model->user_platform_version = $agent->version($this->rating_model->user_platform);
        $this->rating_model->user_browser = $agent->browser();
        $this->rating_model->user_browser_version = $agent->version($this->rating_model->user_browser);
    }

    /**
     * Update Rating into Table
     */
    public function updateRatingintoTable($safari_park)
    {
        $avg = SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $safari_park->id])->average('rating');
        $count = SafariParkRating::find()->select('rating')->where(['status' => 1, 'safari_park_id' => $safari_park->id])->count();
        $safari_park->google_rating = $avg;
        $safari_park->google_review_count = $count;
        $safari_park->save(false);
    }
}
