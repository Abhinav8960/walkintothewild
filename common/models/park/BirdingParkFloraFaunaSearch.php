<?php

namespace common\models\park;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\park\BirdingParkFloraFauna;

/**
 * BirdingParkFloraFaunaSearch represents the model behind the search form of `common\models\park\BirdingParkFloraFauna`.
 */
class BirdingParkFloraFaunaSearch extends BirdingParkFloraFauna
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birding_park_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
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
        $query = BirdingParkFloraFauna::find()->where(['status' => [1, 2]]);

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
            'description' => $this->description,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
