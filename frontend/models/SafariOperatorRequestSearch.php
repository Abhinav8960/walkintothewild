<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\registration\SafariOperatorRequest;

/**
 * SafariOperatorRequestSearch represents the model behind the search form of `frontend\models\registration\SafariOperatorRequest`.
 */
class SafariOperatorRequestSearch extends SafariOperatorRequest
{
    public $budget_segment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'safari_operator_id', 'category_id', 'is_highlighted', 'google_review_count', 'phone_no', 'is_register_company', 'has_a_website', 'has_cancellation_policy', 'wildlife_photographer', 'wildlife_influencer', 'is_offer_premium_budget', 'is_offer_standard_budget', 'is_offer_economical_budget', 'is_wildlife_trekking', 'is_wildlife_non_safari_drive', 'is_bird_watching', 'is_camping', 'is_approved', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['business_name', 'register_comapany_name', 'address', 'gst', 'logo', 'google_business_url', 'google_business_name', 'about_business', 'facebook_url', 'instagram_url', 'youtube_link', 'email', 'website', 'operator_name', 'operator_phone_no', 'operator_email'], 'safe'],
            [['google_rating', 'starting_price'], 'number'],
            [['budget_segment'], 'safe']
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
    public function search($params, $pagination = true)
    {
        $query = SafariOperatorRequest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'safari_operator_id' => $this->safari_operator_id,
            'category_id' => $this->category_id,
            'is_highlighted' => $this->is_highlighted,
            'google_rating' => $this->google_rating,
            'google_review_count' => $this->google_review_count,
            'phone_no' => $this->phone_no,
            'is_register_company' => $this->is_register_company,
            'has_a_website' => $this->has_a_website,
            'has_cancellation_policy' => $this->has_cancellation_policy,
            'wildlife_photographer' => $this->wildlife_photographer,
            'wildlife_influencer' => $this->wildlife_influencer,
            'is_wildlife_trekking' => $this->is_wildlife_trekking,
            'is_wildlife_non_safari_drive' => $this->is_wildlife_non_safari_drive,
            'is_bird_watching' => $this->is_bird_watching,
            'is_camping' => $this->is_camping,
            'starting_price' => $this->starting_price,
            'is_approved' => $this->is_approved,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'business_name', $this->business_name])
            ->andFilterWhere(['like', 'register_comapany_name', $this->register_comapany_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'gst', $this->gst])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'google_business_url', $this->google_business_url])
            ->andFilterWhere(['like', 'google_business_name', $this->google_business_name])
            ->andFilterWhere(['like', 'about_business', $this->about_business])
            ->andFilterWhere(['like', 'facebook_url', $this->facebook_url])
            ->andFilterWhere(['like', 'instagram_url', $this->instagram_url])
            ->andFilterWhere(['like', 'youtube_link', $this->youtube_link])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'operator_name', $this->operator_name])
            ->andFilterWhere(['like', 'operator_phone_no', $this->operator_phone_no])
            ->andFilterWhere(['like', 'operator_email', $this->operator_email]);


        if ($this->budget_segment == 1) {
            $query->andFilterWhere(['is_offer_premium_budget' => 1]);
        } elseif ($this->budget_segment == 2) {
            $query->andFilterWhere(['is_offer_standard_budget' => 1]);
        } elseif ($this->budget_segment == 3) {
            $query->andFilterWhere(['is_offer_economical_budget' => 1]);
        }
        return $dataProvider;
    }
}
