<?php

namespace common\models\paymentgateway\payu;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\paymentgateway\payu\PaymentLinks;

/**
 * PaymentLinksSearch represents the model behind the search form of `common\models\paymentgateway\payu\PaymentLinks`.
 */
class PaymentLinksSearch extends PaymentLinks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service', 'collection', 'collection_id',  'phone_no', 'user_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['customer_name', 'email', 'link_hash', 'link', 'objective', 'purpose', 'link_expiry_datetime', 'link_generated_datetime', 'payment_initiated_datetime'], 'safe'],
            [['gross_amount', 'discount_amount', 'total_amount', 'gst_amount', 'net_amount'], 'number'],
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
        $query = PaymentLinks::find();

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
            'service' => $this->service,
            'collection' => $this->collection,
            'collection_id' => $this->collection_id,
            'customer_name' => $this->customer_name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'user_id' => $this->user_id,
            'link_expiry_datetime' => $this->link_expiry_datetime,
            'gross_amount' => $this->gross_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'gst_amount' => $this->gst_amount,
            'net_amount' => $this->net_amount,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'link_generated_datetime' => $this->link_generated_datetime,
            'payment_initiated_datetime' => $this->payment_initiated_datetime,
        ]);

        $query->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'link_hash', $this->link_hash])
            ->andFilterWhere(['like', 'objective', $this->objective])
            ->andFilterWhere(['like', 'purpose', $this->purpose]);

        return $dataProvider;
    }
}
