<?php

namespace common\models\leads;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\leads\LeadPartnerQuotes;

/**
 * LeadPartnerQuotesSearch represents the model behind the search form of `common\models\leads\LeadPartnerQuotes`.
 */
class LeadPartnerQuotesSearch extends LeadPartnerQuotes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lead_partner_id', 'lead_id', 'partner_id', 'park_id', 'safaris', 'travelers', 'stay_category_id', 'plateform_partner_fees_percentage', 'installment', 'is_approved_by_admin', 'status', 'created_at', 'is_payment_received', 'payment_gateway', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['addional_notes', 'name', 'email', 'phone', 'start_date', 'end_date', 'addtional_data', 'datetime_of_approval_by_admin', 'rejection_reason', 'quotation_filepath', 'transaction_id', 'transaction_datetime'], 'safe'],
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
        $query = LeadPartnerQuotes::find();

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
            'lead_partner_id' => $this->lead_partner_id,
            'lead_id' => $this->lead_id,
            'partner_id' => $this->partner_id,
            'park_id' => $this->park_id,
            'safaris' => $this->safaris,
            'travelers' => $this->travelers,
            'stay_category_id' => $this->stay_category_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'partner_selling_price' => $this->partner_selling_price,
            'plateform_partner_fees_percentage' => $this->plateform_partner_fees_percentage,
            'plateform_partner_fees' => $this->plateform_partner_fees,
            'partner_net_selling_price' => $this->partner_net_selling_price,
            'plateform_customer_discount' => $this->plateform_customer_discount,
            'net_payment_price' => $this->net_payment_price,
            'installment' => $this->installment,
            'received_amount' => $this->received_amount,
            'is_approved_by_admin' => $this->is_approved_by_admin,
            'datetime_of_approval_by_admin' => $this->datetime_of_approval_by_admin,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'is_payment_received' => $this->is_payment_received,
            'transaction_datetime' => $this->transaction_datetime,
            'payment_gateway' => $this->payment_gateway,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'addional_notes', $this->addional_notes])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'addtional_data', $this->addtional_data])
            ->andFilterWhere(['like', 'rejection_reason', $this->rejection_reason])
            ->andFilterWhere(['like', 'quotation_filepath', $this->quotation_filepath])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id]);

        return $dataProvider;
    }
}