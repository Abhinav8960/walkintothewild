<?php

namespace common\models\quotations;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\quotations\Quotation;

/**
 * QuotationSearch represents the model behind the search form of `common\models\quotations\Quotation`.
 */
class QuotationSearch extends Quotation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'collection', 'collection_id', 'travelers', 'user_id', 'operator_id', 'stay_category_id', 'is_closed', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['objective', 'collection_uuid', 'start_date', 'name', 'phone', 'email', 'submit_datetime'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Quotation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'collection' => $this->collection,
            'collection_id' => $this->collection_id,
            'travelers' => $this->travelers,
            'start_date' => $this->start_date,
            'user_id' => $this->user_id,
            'submit_datetime' => $this->submit_datetime,
            'operator_id' => $this->operator_id,
            'stay_category_id' => $this->stay_category_id,
            'is_closed' => $this->is_closed,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'objective', $this->objective])
            ->andFilterWhere(['like', 'collection_uuid', $this->collection_uuid])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}