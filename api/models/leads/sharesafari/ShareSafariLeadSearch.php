<?php

namespace common\models\leads\sharesafari;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\leads\sharesafari\ShareSafariLead;

/**
 * ShareSafariLeadSearch represents the model behind the search form of `common\models\leads\sharesafari\ShareSafariLead`.
 */
class ShareSafariLeadSearch extends ShareSafariLead
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'share_safari_id', 'share_safari_user_id', 'share_safari_partner_id', 'version', 'type', 'quantity', 'notes', 'user_id', 'name', 'email', 'phone', 'installment', 'is_payment_received', 'payment_gateway', 'is_payment_expired', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'end_date', 'payment_receipt', 'transaction_datetime', 'collection'], 'safe'],
            [['cost_per_quantity', 'gross_price', 'discount', 'net_price', 'received_amount'], 'number'],
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
        $query = ShareSafariLead::find();

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
            'share_safari_id' => $this->share_safari_id,
            'share_safari_user_id' => $this->share_safari_user_id,
            'share_safari_partner_id' => $this->share_safari_partner_id,
            'version' => $this->version,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'notes' => $this->notes,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'cost_per_quantity' => $this->cost_per_quantity,
            'gross_price' => $this->gross_price,
            'discount' => $this->discount,
            'net_price' => $this->net_price,
            'installment' => $this->installment,
            'received_amount' => $this->received_amount,
            'is_payment_received' => $this->is_payment_received,
            'transaction_datetime' => $this->transaction_datetime,
            'payment_gateway' => $this->payment_gateway,
            'is_payment_expired' => $this->is_payment_expired,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'payment_receipt', $this->payment_receipt])
            ->andFilterWhere(['like', 'collection', $this->collection]);

        return $dataProvider;
    }
}