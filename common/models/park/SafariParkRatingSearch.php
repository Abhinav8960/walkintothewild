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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'safari_park_id', 'flaged', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['rating'], 'number'],
            [['review', 'user_agent'], 'string', 'max' => 512],
            [['user_device', 'user_platform', 'user_platform_version', 'user_browser'], 'string', 'max' => 50],
            [['user_browser_version', 'user_ip_address'], 'string', 'max' => 20],
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
        $query = SafariParkRating::find()->where(['status' => [1, 2]]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'safari_park_id' => $this->safari_park_id,
            'rating' => $this->rating,
            'flaged' => $this->flaged,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'review', $this->review]);

        return $dataProvider;
    }
}
