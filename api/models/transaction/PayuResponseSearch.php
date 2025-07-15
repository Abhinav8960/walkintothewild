<?php

namespace api\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\transaction\PayuResponse;

/**
 * PayuResponseSearch represents the model behind the search form of `common\models\transaction\PayuResponse`.
 */
class PayuResponseSearch extends PayuResponse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['transaction_id', 'mihpayid', 'mode', 'status', 'unmappedstatus', 'key', 'txnid', 'amount', 'card_category', 'discount', 'net_amount_debit', 'addedon', 'productinfo', 'firstname', 'lastname', 'address1', 'address2', 'city', 'state', 'country', 'zipcode', 'email', 'phone', 'udf1', 'udf2', 'udf3', 'udf4', 'udf5', 'udf6', 'udf7', 'udf8', 'udf9', 'udf10', 'hash', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9', 'payment_source', 'pa_name', 'pg_type', 'bank_ref_num', 'bankcode', 'error', 'error_Message', 'cardnum', 'cardhash', 'response'], 'safe'],
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
        $query = PayuResponse::find();

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
            'addedon' => $this->addedon,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['like', 'mihpayid', $this->mihpayid])
            ->andFilterWhere(['like', 'mode', $this->mode])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'unmappedstatus', $this->unmappedstatus])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'txnid', $this->txnid])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'card_category', $this->card_category])
            ->andFilterWhere(['like', 'discount', $this->discount])
            ->andFilterWhere(['like', 'net_amount_debit', $this->net_amount_debit])
            ->andFilterWhere(['like', 'productinfo', $this->productinfo])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'address2', $this->address2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'zipcode', $this->zipcode])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'udf1', $this->udf1])
            ->andFilterWhere(['like', 'udf2', $this->udf2])
            ->andFilterWhere(['like', 'udf3', $this->udf3])
            ->andFilterWhere(['like', 'udf4', $this->udf4])
            ->andFilterWhere(['like', 'udf5', $this->udf5])
            ->andFilterWhere(['like', 'udf6', $this->udf6])
            ->andFilterWhere(['like', 'udf7', $this->udf7])
            ->andFilterWhere(['like', 'udf8', $this->udf8])
            ->andFilterWhere(['like', 'udf9', $this->udf9])
            ->andFilterWhere(['like', 'udf10', $this->udf10])
            ->andFilterWhere(['like', 'hash', $this->hash])
            ->andFilterWhere(['like', 'field1', $this->field1])
            ->andFilterWhere(['like', 'field2', $this->field2])
            ->andFilterWhere(['like', 'field3', $this->field3])
            ->andFilterWhere(['like', 'field4', $this->field4])
            ->andFilterWhere(['like', 'field5', $this->field5])
            ->andFilterWhere(['like', 'field6', $this->field6])
            ->andFilterWhere(['like', 'field7', $this->field7])
            ->andFilterWhere(['like', 'field8', $this->field8])
            ->andFilterWhere(['like', 'field9', $this->field9])
            ->andFilterWhere(['like', 'payment_source', $this->payment_source])
            ->andFilterWhere(['like', 'pa_name', $this->pa_name])
            ->andFilterWhere(['like', 'pg_type', $this->pg_type])
            ->andFilterWhere(['like', 'bank_ref_num', $this->bank_ref_num])
            ->andFilterWhere(['like', 'bankcode', $this->bankcode])
            ->andFilterWhere(['like', 'error', $this->error])
            ->andFilterWhere(['like', 'error_Message', $this->error_Message])
            ->andFilterWhere(['like', 'cardnum', $this->cardnum])
            ->andFilterWhere(['like', 'cardhash', $this->cardhash])
            ->andFilterWhere(['like', 'response', $this->response]);

        return $dataProvider;
    }
}