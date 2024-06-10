<?php

namespace frontend\models;

use common\models\operator\SafariOperator;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SafariOperatorSearch represents the model behind the search form of `common\models\operator\SafariOperator`.
 */
class SafariOperatorSearch extends SafariOperator
{
    public $park_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_request_id', 'category_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_wildlife_trekking', 'is_wildlife_non_safari_drive', 'is_bird_watching', 'is_camping', 'is_approved', 'user_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['google_rating', 'starting_price'], 'number'],
            [['about_business'], 'string'],
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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'safari_operator.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'register_comapany_name', $this->register_comapany_name]);

        return $dataProvider;
    }
}
