<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CallLog;

/**
 * CallLogSearch represents the model behind the search form of `common\models\CallLog`.
 */
class CallLogSearch extends CallLog
{
    /**
     * {@inheritdoc}
     */
    public $date_range;

    public function rules()
    {
        return [
            [['id', 'chat_id', 'lead_id', 'request_caller_1_user_id', 'request_caller_2_user_id', 'operator_user_id', 'call_initiated_user_id', 'status', 'created_at', 'updated_at','is_detail_fetched','call_initiated_partner_id'], 'integer'],
            [['reference_id', 'unique_id', 'request_vnm', 'request_caller_1_no', 'request_caller_2_no', 'caller_id', 'received_id', 'ivr_number', 'recording_url', 'rec_duration', 'call_type', 'call_status', 'datetime', 'duration', 'file_path', 'call_request_status', 'call_request_message','is_detail_fetched','dial_status','call_initiated_partner_id'], 'safe'],
            [['date_range'], 'safe'],
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
        $query = CallLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'chat_id' => $this->chat_id,
            'lead_id' => $this->lead_id,
            'request_caller_1_user_id' => $this->request_caller_1_user_id,
            'request_caller_2_user_id' => $this->request_caller_2_user_id,
            'operator_user_id' => $this->operator_user_id,
            'call_initiated_user_id' => $this->call_initiated_user_id,
            'call_initiated_partner_id' => $this->call_initiated_partner_id,
            'status' => $this->status,
            'is_detail_fetched'=> $this->is_detail_fetched,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'reference_id', $this->reference_id])
            ->andFilterWhere(['like', 'unique_id', $this->unique_id])
            ->andFilterWhere(['like', 'request_vnm', $this->request_vnm])
            ->andFilterWhere(['like', 'request_caller_1_no', $this->request_caller_1_no])
            ->andFilterWhere(['like', 'request_caller_2_no', $this->request_caller_2_no])
            ->andFilterWhere(['like', 'caller_id', $this->caller_id])
            ->andFilterWhere(['like', 'received_id', $this->received_id])
            ->andFilterWhere(['like', 'ivr_number', $this->ivr_number])
            ->andFilterWhere(['like', 'recording_url', $this->recording_url])
            ->andFilterWhere(['like', 'rec_duration', $this->rec_duration])
            ->andFilterWhere(['like', 'dial_status', $this->dial_status])            
            ->andFilterWhere(['like', 'call_type', $this->call_type])
            ->andFilterWhere(['like', 'call_status', $this->call_status])
            ->andFilterWhere(['like', 'datetime', $this->datetime])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'file_path', $this->file_path])
            ->andFilterWhere(['like', 'call_request_status', $this->call_request_status])
            ->andFilterWhere(['like', 'call_request_message', $this->call_request_message]);

            if (!is_null($this->date_range) && strpos($this->date_range, ' - ') !== false) {
                list($start_date, $end_date) = explode(' - ', $this->date_range);
                $query->andFilterWhere(['between', 'datetime', $start_date, $end_date]);
                $this->date_range = null;
            }

        return $dataProvider;
    }
}