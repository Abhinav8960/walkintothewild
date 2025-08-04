<?php

namespace common\models\leads\sharesafari;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\leads\sharesafari\ShareSafariInstallment;

/**
 * ShareSafariInstallmentSearch represents the model behind the search form of `common\models\leads\sharesafari\ShareSafariInstallment`.
 */
class ShareSafariInstallmentSearch extends ShareSafariInstallment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'share_safari_id', 'share_safari_user_id', 'share_safari_partner_id', 'version', 'type', 'user_id', 'transaction_id', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['notes', 'name', 'email', 'due_datetime', 'payment_link', 'payment_hash', 'transaction_datetime'], 'safe'],
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
        $query = ShareSafariInstallment::find();

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
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'due_datetime' => $this->due_datetime,
            'transaction_id' => $this->transaction_id,
            'payment_gateway' => $this->payment_gateway,
            'transaction_datetime' => $this->transaction_datetime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'payment_link', $this->payment_link])
            ->andFilterWhere(['like', 'payment_hash', $this->payment_hash]);

        return $dataProvider;
    }
}