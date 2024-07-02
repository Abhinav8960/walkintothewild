<?php

namespace common\models\operator;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SafariOperatorFollowSearch represents the model behind the search form of `common\models\operator\SafariOperatorFollow`.
 */
class SafariOperatorFollowSearch extends SafariOperatorFollow
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_id', 'user_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['user_device', 'user_platform', 'user_browser'], 'string', 'max' => 50],
            [['user_agent'], 'string', 'max' => 512],
            [['user_browser_version', 'user_ip_address'], 'string', 'max' => 20],
            [['safari_operator_id', 'user_id'], 'unique', 'targetAttribute' => ['safari_operator_id', 'user_id']],
            [['follow_datetime', 'unfollow_datetime', 'user_platform_version'], 'safe'],
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
        $query = SafariOperatorFollow::find()->where(['safari_operator_follow.status' => [1, 0]]);

        // add conditions that should always apply here




        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'user_id' => $this->user_id,
            'follow_datetime' => $this->follow_datetime,
            'unfollow_datetime' => $this->unfollow_datetime,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'safari_operator_follow.status' => $this->status,
        ]);



        return $dataProvider;
    }
}
