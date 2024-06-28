<?php

namespace frontend\models;

use common\models\operator\SafariOperatorRating;
use Yii;


class SafariOperatorReviewForm extends \yii\base\Model
{
    public $rating_model;
    public $safari_operator_id;
    public $park_id;
    public $rating;
    public $review;
    public $action_url;
    public $action_validate_url;


    public function __construct(SafariOperatorRating $rating_model = null)
    {
        $this->rating_model = Yii::createObject([
            'class' => SafariOperatorRating::className()
        ]);
    }

    public function rules()
    {
        return [
            [['safari_operator_id', 'park_id', 'rating', 'review',], 'required'],
            [['safari_operator_id', 'park_id', 'rating'], 'integer'],
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
            'safari_operator_id' => 'Safari Operator ID',
            'user_id' => 'User ID',
            'park_id' => 'Park ID',
            'rating' => 'Rating',
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
        $this->rating_model->safari_operator_id = $this->safari_operator_id;
        $this->rating_model->park_id = $this->park_id;
        $this->rating_model->rating = $this->rating;
        $this->rating_model->review = $this->review;

        $this->rating_model->user_ip_address = Yii::$app->getRequest()->getUserIp();
        $this->rating_model->user_agent =  Yii::$app->request->userAgent;
        $this->rating_model->user_device  = $agent->device();
        $this->rating_model->user_platform = $agent->platform();
        $this->rating_model->user_platform_version = $agent->version($this->rating_model->user_platform);
        $this->rating_model->user_browser = $agent->browser();
        $this->rating_model->user_browser_version = $agent->version($this->rating_model->user_browser);
        $this->rating_model->status = 1;
    }
}
