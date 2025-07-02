<?php

namespace common\models\park;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\park\SafariParkRating;

/**
 * SafariParkRatingSearch represents the model behind the search form of `common\models\park\SafariParkRating`.
 */
class SafariParkRatingSearch extends SafariParkRating
{
    public $custom_sort_by;
    public $safari_park;
    public $park_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'safari_park_id', 'flaged', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'park_id'], 'integer'],
            [['rating'], 'number'],
            [['review', 'user_agent', 'safari_park'], 'string', 'max' => 512],
            [['user_device', 'user_platform', 'user_platform_version', 'user_browser'], 'string', 'max' => 50],
            [['user_browser_version', 'user_ip_address'], 'string', 'max' => 20],
            [['custom_sort_by'], 'safe']

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
        $query = SafariParkRating::find()->where(['safari_park_rating.status' => [SafariParkRating::STATUS_ACTIVE, SafariParkRating::STATUS_SUSPEND]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if ($this->custom_sort_by) {
            if ($this->custom_sort_by == 'newest') {
                $dataProvider->sort = [
                    'defaultOrder' => ['created_at' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == 'highest') {
                $dataProvider->sort = [
                    'defaultOrder' => ['rating' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == 'lowest') {
                $dataProvider->sort = [
                    'defaultOrder' => ['rating' => SORT_ASC]
                ];
            }
        } else {
            $dataProvider->sort = [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ];
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'safari_park_rating.id' => $this->id,
            'safari_park_rating.safari_park_id' => $this->safari_park_id,
            'safari_park_rating.rating' => $this->rating,
            'safari_park_rating.flaged' => $this->flaged,
            'safari_park_rating.created_at' => $this->created_at,
            'safari_park_rating.created_by' => $this->created_by,
            'safari_park_rating.updated_at' => $this->updated_at,
            'safari_park_rating.updated_by' => $this->updated_by,
            'safari_park_rating.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'review', $this->review]);


        if ($this->safari_park) {
            $query->joinwith(['park' => function ($query) {
                $query->andFilterWhere(['like', 'safari_park.title', $this->safari_park]);
            }]);
        }

        if ($this->park_id) {
            $query->joinwith(['park' => function ($query) {
                $query->andFilterWhere(['safari_park.id'=> $this->park_id]);
            }]);
        }

        return $dataProvider;
    }
}
