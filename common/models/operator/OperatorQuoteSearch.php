<?php

namespace common\models\operator;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\operator\OperatorQuote;

/**
 * OperatorQuoteSearch represents the model behind the search form of `common\models\operator\OperatorQuote`.
 */
class OperatorQuoteSearch extends OperatorQuote
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_park_id', 'safaris', 'travelers', 'stay_category_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['full_name', 'email', 'start_date', 'end_date', 'user_agent'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 12],
            [['ip_address'], 'string', 'max' => 45],
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
        $query = OperatorQuote::find()->where(['status' => [1, 2]]);

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
            'phone_no' => $this->phone_no,
            'email' => $this->email,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'safaris' => $this->safaris,
            'travelers' => $this->travelers,
            'stay_category_id' => $this->stay_category_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'full_name', $this->full_name]);

        return $dataProvider;
    }
}
