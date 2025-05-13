<?php

namespace common\models\payments;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\payments\Payments;

/**
 * PaymentsSearch represents the model behind the search form of `common\models\payments\Payments`.
 */
class PaymentsSearch extends Payments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_hash', 'lead_id', 'partner_id', 'lead_partner_quote_id', 'gateway', 'status', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
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
        $query = Payments::find();

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
            'payment_hash' => $this->payment_hash,
            'lead_id' => $this->lead_id,
            'partner_id' => $this->partner_id,
            'amount' => $this->amount,
            'lead_partner_quote_id' => $this->lead_partner_quote_id,
            'gateway' => $this->gateway,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}