<?php

namespace common\models\park;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\park\SafariParkFloraFauna;

/**
 * SafariParkFloraFaunaSearch represents the model behind the search form of `common\models\park\SafariParkFloraFauna`.
 */
class SafariParkFloraFaunaSearch extends SafariParkFloraFauna
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_park_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
        $query = SafariParkFloraFauna::find()->where(['status' => [SafariParkFloraFauna::STATUS_ACTIVE, SafariParkFloraFauna::STATUS_SUSPEND]]);

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
            'safari_park_id' => $this->safari_park_id,
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
