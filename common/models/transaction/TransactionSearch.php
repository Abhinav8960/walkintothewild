<?php

namespace common\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\transaction\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `common\models\transaction\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lead_partner_quotes_id', 'lead_partner_quote_installments_id', 'lead_partner_id', 'lead_id', 'partner_id', 'park_id', 'safaris', 'travelers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'is_payment_received', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['reference_id', 'order_id', 'currency', 'addional_notes', 'name', 'email', 'phone', 'start_date', 'end_date', 'validity_date', 'permit_booking_date', 'addtional_data', 'datetime_of_approval_by_admin', 'quotation_filepath', 'transaction_datetime', 'billing_name', 'billing_address', 'billing_city', 'billing_state', 'billing_zip', 'billing_country', 'billing_tel', 'billing_email', 'param1', 'param2', 'param3', 'param4', 'param5'], 'safe'],
            [['partner_selling_price', 'plateform_partner_fees', 'partner_net_selling_price', 'plateform_customer_discount', 'net_payment_price', 'received_amount'], 'number'],
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
        $query = Transaction::find();

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
            'lead_partner_quotes_id' => $this->lead_partner_quotes_id,
            'lead_partner_quote_installments_id' => $this->lead_partner_quote_installments_id,
            'lead_partner_id' => $this->lead_partner_id,
            'lead_id' => $this->lead_id,
            'partner_id' => $this->partner_id,
            'park_id' => $this->park_id,
            'safaris' => $this->safaris,
            'travelers' => $this->travelers,
            'stay_category_id' => $this->stay_category_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'validity_date' => $this->validity_date,
            'permit_booking_date' => $this->permit_booking_date,
            'partner_selling_price' => $this->partner_selling_price,
            'plateform_partner_fees_percentage' => $this->plateform_partner_fees_percentage,
            'plateform_partner_fees' => $this->plateform_partner_fees,
            'partner_net_selling_price' => $this->partner_net_selling_price,
            'plateform_customer_discount' => $this->plateform_customer_discount,
            'net_payment_price' => $this->net_payment_price,
            'installment' => $this->installment,
            'received_amount' => $this->received_amount,
            'datetime_of_approval_by_admin' => $this->datetime_of_approval_by_admin,
            'is_payment_received' => $this->is_payment_received,
            'transaction_datetime' => $this->transaction_datetime,
            'payment_gateway' => $this->payment_gateway,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'reference_id', $this->reference_id])
            ->andFilterWhere(['like', 'order_id', $this->order_id])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'addional_notes', $this->addional_notes])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'addtional_data', $this->addtional_data])
            ->andFilterWhere(['like', 'quotation_filepath', $this->quotation_filepath])
            ->andFilterWhere(['like', 'billing_name', $this->billing_name])
            ->andFilterWhere(['like', 'billing_address', $this->billing_address])
            ->andFilterWhere(['like', 'billing_city', $this->billing_city])
            ->andFilterWhere(['like', 'billing_state', $this->billing_state])
            ->andFilterWhere(['like', 'billing_zip', $this->billing_zip])
            ->andFilterWhere(['like', 'billing_country', $this->billing_country])
            ->andFilterWhere(['like', 'billing_tel', $this->billing_tel])
            ->andFilterWhere(['like', 'billing_email', $this->billing_email])
            ->andFilterWhere(['like', 'param1', $this->param1])
            ->andFilterWhere(['like', 'param2', $this->param2])
            ->andFilterWhere(['like', 'param3', $this->param3])
            ->andFilterWhere(['like', 'param4', $this->param4])
            ->andFilterWhere(['like', 'param5', $this->param5]);

        return $dataProvider;
    }
}