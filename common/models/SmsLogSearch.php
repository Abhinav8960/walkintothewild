<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SmsLog;

/**
 * SmsLogSearch represents the model behind the search form of `common\models\SmsLog`.
 */
class SmsLogSearch extends SmsLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'sms_send_time', 'service_id', 'is_cron_run', 'is_ok', 'is_deliver', 'response_code', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['template_id', 'params', 'message_id'], 'safe'],
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
        $query = SmsLog::find();

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
            'user_id' => $this->user_id,
            'sms_send_time' => $this->sms_send_time,
            'service_id' => $this->service_id,
            'is_cron_run' => $this->is_cron_run,
            'is_ok' => $this->is_ok,
            'is_deliver' => $this->is_deliver,
            'status' => $this->status,
            'response_code' => $this->response_code,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'template_id', $this->template_id])
            ->andFilterWhere(['like', 'message_id', $this->message_id])
            ->andFilterWhere(['like', 'params', $this->params]);

        return $dataProvider;
    }
}
