<?php

namespace common\models\sighting;

use common\models\sighting\Sighting;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class SightingSearch extends Sighting
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['safari_session_id', 'location', 'master_animal_id'], 'safe']
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
        $query = Sighting::find()->where(['status' => [Sighting::STATUS_ACTIVE]]);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'location' => $this->location,
            'master_animal_id' => $this->master_animal_id,
            'safari_session_id' => $this->safari_session_id,
            'status' => $this->status,
        ]);


        return $dataProvider;
    }
}
