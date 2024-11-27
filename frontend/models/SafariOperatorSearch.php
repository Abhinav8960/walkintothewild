<?php

namespace frontend\models;

use common\models\operator\SafariOperator;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * SafariOperatorSearch represents the model behind the search form of `common\models\operator\SafariOperator`.
 */
class SafariOperatorSearch extends SafariOperator
{
    public $budget_segment;
    public $credibility;
    public $custom_sort_by;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_request_id', 'category_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_wildlife_trekking', 'is_wildlife_non_safari_drive', 'is_bird_watching', 'is_camping', 'is_approved', 'user_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['starting_price'], 'number'],
            [['google_rating', 'custom_sort_by'], 'safe'],
            [['about_business'], 'string'],
            [['budget_segment', 'credibility'], 'safe'],
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
    public function search($params, $park_id = null)
    {
        $query = SafariOperator::find()->where(['safari_operator.status' => 1]);


        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }
        if ($session->get('lastSort') === 'random') {
            $currentSort = 'google_rating';
            $query->orderBy(['google_rating' => SORT_DESC]);
        } else {
            $currentSort = 'random';
            $query->orderBy(new Expression('RAND()'));
        }
        $session->set('lastSort', $currentSort);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => $query,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if ($this->custom_sort_by) {
            if ($this->custom_sort_by == 1) {
                $dataProvider->sort = [
                    'defaultOrder' => ['google_rating' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == 2) {
                $dataProvider->sort = [
                    'defaultOrder' => ['google_rating' => SORT_ASC]
                ];
            } else if ($this->custom_sort_by == 3) {
                $dataProvider->sort = [
                    'defaultOrder' => ['business_name' => SORT_ASC]
                ];
            } else if ($this->custom_sort_by == 4) {
                $dataProvider->sort = [
                    'defaultOrder' => ['business_name' => SORT_DESC]
                ];
            }
        }

        if ($park_id) {
            $query->joinwith(['park' => function ($query) use ($park_id) {
                $query->andFilterWhere(['safari_operator_park.park_id' => $park_id]);
            }]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'safari_operator_request_id' => $this->safari_operator_request_id,
            // 'google_rating' => $this->google_rating,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'safari_operator.status' => $this->status,
        ]);

        if ($this->google_rating) {
            $rating_query = "";
            foreach ((array)$this->google_rating as $google_rating) {
                if ($google_rating == 1) {
                    $rating_query .= "google_rating between 0 and 1 OR ";
                } else if ($google_rating == 2) {
                    $rating_query .= "google_rating between 2 and 2.99 OR ";
                } else if ($google_rating == 3) {
                    $rating_query .= "google_rating between 3 and 3.99 OR ";
                } else if ($google_rating == 4) {
                    $rating_query .= "google_rating between 4 and 4.99 OR ";
                } else if ($google_rating == 5) {
                    $rating_query .= "google_rating between 5 and 5.99 OR ";
                }
            }
            if ($rating_query <> '') {
                $rating_query = substr($rating_query, 0, -3);
                $query->andWhere($rating_query);
            }
        }

        if ($this->budget_segment) {
            foreach ($this->budget_segment as $segment) {
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
            foreach ($this->credibility as $data) {
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

        return $dataProvider;
    }
}
