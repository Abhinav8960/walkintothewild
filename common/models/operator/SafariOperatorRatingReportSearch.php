<?php

namespace common\models\operator;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SafariOperatorRatingReportSearch represents the model behind the search form of `common\models\operator\SafariOperatorRatingReport`.
 */
class SafariOperatorRatingReportSearch extends SafariOperatorRatingReport
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'safari_operator_id', 'park_id', 'safari_operator_rating_id', 'report_reason_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['report_detail', 'user_agent'], 'string', 'max' => 512],
            [['user_device', 'user_platform', 'user_browser'], 'string', 'max' => 50],
            [['user_ip_address'], 'string', 'max' => 20],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SafariOperatorRatingReport::find()->where(['safari_operator_rating_report.status' => [1, 2]]);

        // add conditions that should always apply here



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'safari_operator_id' => $this->safari_operator_id,
            'safari_operator_rating_id' => $this->safari_operator_rating_id,
            'report_reason_id' => $this->report_reason_id,
            'report_detail' => $this->report_detail,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'safari_operator_rating_report.status' => $this->status,
        ]);



        return $dataProvider;
    }
}
