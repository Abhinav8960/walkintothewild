<?php

namespace frontend\models;

use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorRating;
use common\models\park\SafariPark;
use Yii;
use yii\helpers\ArrayHelper;

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

        if ($rating_model != null) {
            $this->rating_model = $rating_model;
            $this->safari_operator_id = $this->rating_model->safari_operator_id;
            $this->park_id = $this->rating_model->park_id;
            $this->rating = $this->rating_model->rating;
            $this->review = $this->rating_model->review;
        }
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

    /**
     * Update Rating into Table
     */
    public function updateRatingintoTable($operator)
    {
        $avg = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id])->average('rating');
        $count = SafariOperatorRating::find()->select('rating')->where(['status' => 1, 'safari_operator_id' => $operator->id])->count();
        $operator->google_rating = $avg;
        $operator->google_review_count = $count;
        $operator->save(false);
    }

    public function getParklist()
    {
        if ($this->rating_model->id) {
            $user_park_id = SafariOperatorRating::find()->select('park_id')->where(['safari_operator_id' => $this->safari_operator_id, 'status' => 1])->andWhere("id <> " . $this->rating_model->id)->column();
        } else {
            $user_park_id = SafariOperatorRating::find()->select('park_id')->where(['safari_operator_id' => $this->safari_operator_id, 'status' => 1])->column();
        }
        $operator_safari_park = [];
        $operatorsafariparkData = SafariOperatorPark::find()->where(['safari_operator_id' =>  $this->safari_operator_id, 'status' => 1])->andWhere(['not in', 'park_id', $user_park_id])->all();
        if (count($operatorsafariparkData) >= 1) {

            foreach ($operatorsafariparkData as $operatorsafaripark) {
                $operator_safari_park[] = $operatorsafaripark->park_id;
            }
        }
        $safariparkList =  SafariPark::find()->where(['in', 'id', $operator_safari_park]);
        return ArrayHelper::map($safariparkList->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');
    }
}
