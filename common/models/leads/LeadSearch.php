<?php

namespace common\models\leads;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\leads\Lead;

/**
 * LeadSearch represents the model behind the search form of `common\models\leads\Lead`.
 */
class LeadSearch extends Lead
{
    public $user_name;
    public $safari_operator_id;
    public $lead_month;
    public $custom_status;




    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'source', 'package_id', 'park_id', 'operator_id', 'is_date_flexible', 'safaris', 'travelers', 'stay_category_id', 'user_id', 'is_booking_for_login_user', 'is_seen_by_admin', 'status', 'is_payment_received', 'booked_operator_id', 'payment_gateway', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['package_version', 'name', 'email', 'phone', 'destination', 'from_date', 'to_date', 'transport', 'meals', 'budget', 'addional_notes', 'transaction_id', 'transaction_datetime', 'quotation_count', 'is_chat_started'], 'safe'],
            [['user_name'], 'string'],
            [['safari_operator_id'], 'integer'],
            [['lead_month', 'custom_status','is_payment_link_send'], 'safe'],
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
        $query = Lead::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],

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
            'source' => $this->source,
            'package_id' => $this->package_id,
            'park_id' => $this->park_id,
            'operator_id' => $this->operator_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'is_date_flexible' => $this->is_date_flexible,
            'safaris' => $this->safaris,
            'travelers' => $this->travelers,
            'stay_category_id' => $this->stay_category_id,
            'user_id' => $this->user_id,
            'is_booking_for_login_user' => $this->is_booking_for_login_user,
            'is_seen_by_admin' => $this->is_seen_by_admin,
            Lead::getTableSchema()->fullName . '.status' => $this->status,
            'is_payment_received' => $this->is_payment_received,
            'booked_operator_id' => $this->booked_operator_id,
            'transaction_datetime' => $this->transaction_datetime,
            'payment_gateway' => $this->payment_gateway,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'quotation_count' => $this->quotation_count,
            'is_chat_started' => $this->is_chat_started,
            'is_payment_link_send' => $this->is_payment_link_send,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'package_version', $this->package_version])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'transport', $this->transport])
            ->andFilterWhere(['like', 'meals', $this->meals])
            ->andFilterWhere(['like', 'budget', $this->budget])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['like', 'addional_notes', $this->addional_notes]);

        if (!empty($this->user_name)) {
            $query->joinwith(['user' => function ($query) {
                $query->andFilterWhere(['like', 'user.name', $this->user_name]);
            }]);
        }
        if ($this->safari_operator_id) {
            $query->joinWith(['assignOperator' => function ($q) {
                $q->andFilterWhere([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, 'partner_id' => $this->safari_operator_id]);
            }]);
        }
        return $dataProvider;
    }

    public function partnersearch($params, $operator_id)
    {
        $query = Lead::find();

        // add conditions that should always apply here

        $query->joinWith(['assignOperator' => function ($q) use ($operator_id) {
            $q->where([LeadPartners::getTableSchema()->fullName . '.status' => LeadPartners::STATUS_ACTIVE, LeadPartners::getTableSchema()->fullName . '.partner_id' => $operator_id]);
        }]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],

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
            'source' => $this->source,
            'package_id' => $this->package_id,
            'park_id' => $this->park_id,
            'operator_id' => $this->operator_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'is_date_flexible' => $this->is_date_flexible,
            'safaris' => $this->safaris,
            'travelers' => $this->travelers,
            'stay_category_id' => $this->stay_category_id,
            'user_id' => $this->user_id,
            'is_booking_for_login_user' => $this->is_booking_for_login_user,
            'is_seen_by_admin' => $this->is_seen_by_admin,
            'lead.status' => $this->status,
            'is_payment_received' => $this->is_payment_received,
            'booked_operator_id' => $this->booked_operator_id,
            'transaction_datetime' => $this->transaction_datetime,
            'payment_gateway' => $this->payment_gateway,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'package_version', $this->package_version])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'transport', $this->transport])
            ->andFilterWhere(['like', 'meals', $this->meals])
            ->andFilterWhere(['like', 'budget', $this->budget])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id])
            ->andFilterWhere(['like', 'addional_notes', $this->addional_notes]);

        if ($this->lead_month) {
            $query->andWhere(['MONTH(FROM_UNIXTIME(lead.created_at))' => $this->lead_month]);
        }

        if ($this->custom_status) {
            switch ($this->custom_status) {
                case 1:
                    $query->andWhere(['>=', 'lead.from_date', date('Y-m-d')])->andWhere(['lead.status' => 1]);
                    break;
                case 2:
                    $query->andWhere([
                        'or',
                        ['<', 'lead.from_date', date('Y-m-d')],
                        ['lead.status' => 0],
                    ]);
                    break;
            };
        }

        return $dataProvider;
    }
}
