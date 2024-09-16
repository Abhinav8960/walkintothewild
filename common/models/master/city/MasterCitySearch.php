<?php

namespace common\models\master\city;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\city\MasterCity;

/**
 * MasterCitySearch represents the model behind the search form of `common\models\master\city\MasterCity`.
 */
class MasterCitySearch extends MasterCity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'state_id', 'country_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['city_name'], 'string', 'max' => 125],
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
        $query = MasterCity::find()->where(['status' => [MasterCity::STATUS_ACTIVE, MasterCity::STATUS_SUSPEND]]);

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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'city_name', $this->city_name]);

        return $dataProvider;
    }
}
