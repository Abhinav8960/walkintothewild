<?php

namespace api\models\master\month;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\master\month\MasterMonth;

/**
 * MasterMonthSearch represents the model behind the search form of `api\models\master\month\MasterMonth`.
 */
class MasterMonthSearch extends MasterMonth
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month'], 'integer'],
            [['month_name', 'month_short_name'], 'safe'],
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
        $query = MasterMonth::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['month' => SORT_ASC]],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'month' => $this->month,
        ]);

        $query->andFilterWhere(['like', 'month_name', $this->month_name])
            ->andFilterWhere(['like', 'month_short_name', $this->month_short_name]);

        return $dataProvider;
    }
}