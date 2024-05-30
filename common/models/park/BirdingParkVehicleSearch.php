<?php

namespace common\models\park;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\park\BirdingParkVehicle;

/**
 * BirdingParkVehicleSearch represents the model behind the search form of `common\models\park\BirdingParkVehicle`.
 */
class BirdingParkVehicleSearch extends BirdingParkVehicle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birding_park_id', 'vehicle_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
        $query = BirdingParkVehicle::find()->where(['status' => [1, 2]]);

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
            'birding_park_id' => $this->birding_park_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'vehicle_id', $this->vehicle_id]);

        return $dataProvider;
    }
}
