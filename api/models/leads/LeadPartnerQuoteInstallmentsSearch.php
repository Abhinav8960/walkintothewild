<?php

namespace api\models\leads;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\leads\LeadPartnerQuoteInstallments;

/**
 * LeadPartnerQuoteInstallmentsSearch represents the model behind the search form of `common\models\leads\LeadPartnerQuoteInstallments`.
 */
class LeadPartnerQuoteInstallmentsSearch extends LeadPartnerQuoteInstallments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lead_partner_quote_id', 'lead_id', 'partner_id', 'status', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['payment_link', 'payment_hash', 'qr_code_file', 'before_datetime', 'transaction_id', 'transaction_datetime'], 'safe'],
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
        $query = LeadPartnerQuoteInstallments::find();

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
            'lead_partner_quote_id' => $this->lead_partner_quote_id,
            'lead_id' => $this->lead_id,
            'partner_id' => $this->partner_id,
            'amount' => $this->amount,
            'before_datetime' => $this->before_datetime,
            'status' => $this->status,
            'payment_gateway' => $this->payment_gateway,
            'transaction_datetime' => $this->transaction_datetime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'payment_link', $this->payment_link])
            ->andFilterWhere(['like', 'payment_hash', $this->payment_hash])
            ->andFilterWhere(['like', 'qr_code_file', $this->qr_code_file])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id]);

        return $dataProvider;
    }
}
