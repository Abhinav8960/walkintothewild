<?php

namespace api\models\master\airport;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\master\airport\MasterAirport;

/**
 * MasterAirportSearch represents the model behind the search form of `api\models\master\airport\MasterAirport`.
 */
class MasterAirportSearch extends MasterAirport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'state_id', 'country_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['status'], 'safe']
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
        $query = MasterAirport::find()->where(['status' => [MasterAirport::STATUS_ACTIVE, MasterAirport::STATUS_SUSPEND]]);

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
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
