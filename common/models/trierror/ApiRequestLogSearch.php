<?php

namespace common\models\trierror;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ApiRequestLogSearch represents the model behind the search form of `common\models\trierror\ApiRequestLog`.
 */
class ApiRequestLogSearch extends ApiRequestLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'request_code', 'is_server_error', 'is_client_error', 'is_count', 'is_reqeust_trace'], 'integer'],
            [['user_ip', 'request_group', 'slug', 'route', 'request_url', 'request_full_url', 'request_type', 'request_parameter', 'request_data', 'response_error', 'device', 'system', 'platform', 'browser', 'browser_version', 'created_at'], 'safe'],
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
        $query = ApiRequestLog::find();

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
            'request_code' => $this->request_code,
            'is_server_error' => $this->is_server_error,
            'is_client_error' => $this->is_client_error,
            'is_count' => $this->is_count,
            'is_reqeust_trace' => $this->is_reqeust_trace,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'user_ip', $this->user_ip])
            ->andFilterWhere(['like', 'request_group', $this->request_group])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'request_url', $this->request_url])
            ->andFilterWhere(['like', 'request_full_url', $this->request_full_url])
            ->andFilterWhere(['like', 'request_type', $this->request_type])
            ->andFilterWhere(['like', 'request_parameter', $this->request_parameter])
            ->andFilterWhere(['like', 'request_data', $this->request_data])
            ->andFilterWhere(['like', 'response_error', $this->response_error])
            ->andFilterWhere(['like', 'device', $this->device])
            ->andFilterWhere(['like', 'system', $this->system])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'browser', $this->browser])
            ->andFilterWhere(['like', 'browser_version', $this->browser_version]);

        return $dataProvider;
    }
}
