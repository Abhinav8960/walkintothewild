<?php

namespace common\models\package;

use common\models\package\PackageEnquiry;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PackageEnquirySearch represents the model behind the search form of `common\models\package\PackageEnquiry`.
 */
class PackageEnquirySearch extends PackageEnquiry
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_id', 'package_id', 'user_id', 'no_of_travelers', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['name', 'email_address'], 'string', 'max' => 512],
            [['phone'], 'string', 'max' => 12],
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
        $query = PackageEnquiry::find()->where(['status' => [1, 2]]);

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
            'package_id' => $this->package_id,
            'safari_operator_id' => $this->safari_operator_id,
            'user_id' => $this->user_id,
            'no_of_travelers' => $this->no_of_travelers,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'email_address', $this->email_address]);

        return $dataProvider;
    }
}
