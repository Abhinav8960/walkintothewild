<?php

namespace common\models\operator;

use DateTime;
use InvalidArgumentException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SafariOperatorSearch represents the model behind the search form of `common\models\operator\SafariOperator`.
 */
class SafariOperatorSearch extends SafariOperator
{
    public $budget_segment;
    public $credibility;
    public $park_id;
    public $business_name;
    public $register_comapany_name;
    public $report_days;



    public $report_days_option = [
        'all' => 'All',
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'tw' => 'This Week',
        'tm' => 'This Month',
        'lm' => 'Last Month',
        'tfy' => 'This Financial Year',
    ];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_request_id', 'category_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_wildlife_trekking', 'is_wildlife_non_safari_drive', 'is_bird_watching', 'is_camping', 'is_approved', 'user_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['google_rating', 'starting_price'], 'number'],
            [['about_business'], 'string'],
            [['budget_segment', 'credibility', 'park_id', 'report_days'], 'safe'],
            [['business_name', 'register_comapany_name', 'address', 'gst', 'logo', 'google_business_url', 'google_business_name', 'facebook_url', 'instagram_url', 'youtube_link', 'email', 'website', 'operator_name', 'operator_phone_no', 'operator_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SafariOperator::find()->where(['safari_operator.status' => [1, 2]]);

        // add conditions that should always apply here




        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if ($this->park_id) {
            $query->joinwith(['park' => function ($query) {
                $query->andFilterWhere(['safari_operator_park.park_id' => $this->park_id]);
            }]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'safari_operator_request_id' => $this->safari_operator_request_id,
            'google_rating' => $this->google_rating,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'safari_operator.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'business_name', $this->business_name]);
        $query->andFilterWhere(['like', 'register_comapany_name', $this->register_comapany_name]);

        if ($this->budget_segment) {
            foreach ((array)$this->budget_segment as $segment) {
                switch ($segment) {
                    case 1:
                        // Apply filter for premium budget
                        $query->andFilterWhere(['safari_operator.is_offer_premium_budget' => 1]);
                        break;
                    case 2:
                        // Apply filter for standard budget
                        $query->andFilterWhere(['safari_operator.is_offer_standard_budget' => 1]);
                        break;
                    case 3:
                        // Apply filter for economical budget
                        $query->andFilterWhere(['safari_operator.is_offer_economical_budget' => 1]);
                        break;
                        // Add more cases if needed
                    default:
                        // Handle other cases if necessary
                        break;
                }
            }
        }

        if ($this->credibility) {
            foreach ((array)$this->credibility as $data) {
                switch ($data) {
                    case 1:
                        // Apply filter for premium budget
                        $query->andFilterWhere(['!=', 'register_company_name', '']);
                        break;
                    case 2:
                        // Apply filter for standard budget
                        $query->andFilterWhere(['!=', 'website', '']);
                        break;
                    case 3:
                        // Apply filter for economical budget
                        $query->andFilterWhere(['!=', 'website', '']);
                        break;
                        // Add more cases if needed
                    case 4:
                        // Apply filter for economical budget
                        $query->andFilterWhere(['has_cancellation_policy' => 1]);
                        break;
                        // Add more cases if needed
                    case 5:
                        // Apply filter for economical budget
                        $query->andFilterWhere(['category_id' => 2]);
                        break;
                        // Add more cases if needed
                    case 6:
                        // Apply filter for economical budget
                        $query->andFilterWhere(['category_id' => 3]);
                        break;
                        // Add more cases if needed
                    default:
                        // Handle other cases if necessary
                        break;
                }
            }
        }


        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }
        return $dataProvider;
    }



    /**
     * Raw Query
     */
    public function getRawdatequery()
    {
        $query = "1=1";

        // Create DateTime objects for current date and time
        $now = new DateTime();

        if ($this->report_days == 'today') { // Today
            $start = $now->setTime(0, 0, 0)->getTimestamp();
            $end = $now->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'yesterday') { // Yesterday
            $yesterday = (new DateTime('yesterday'));
            $start = $yesterday->setTime(0, 0, 0)->getTimestamp();
            $end = $yesterday->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tw') { // This Week
            $start = (new DateTime('monday this week'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('sunday this week'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tm') { // This Month
            $start = (new DateTime('first day of this month'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('last day of this month'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'lm') { // Last Month
            $start = (new DateTime('first day of last month'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('last day of last month'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tfy') { // This Financial Year
            $financialYearStart = new DateTime('April ' . $now->format('Y'));
            if ($now < $financialYearStart) {
                $financialYearStart = new DateTime('April ' . $now->format('Y', strtotime('-1 year')));
            }
            $start = $financialYearStart->setTime(0, 0, 0)->getTimestamp();
            $end = $now->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        }

        return $query;
    }
}
