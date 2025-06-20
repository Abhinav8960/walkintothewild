<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class UserSessionSearch extends UserSession
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'app_name','user_platform_version','application_version'], 'safe'],
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

        $query = UserSession::find(); // Do not Show Adminstrator Role User

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['last_activity' => SORT_DESC]]
        ]);

        $this->load($params);


        $query->andFilterWhere([
            'user_session.user_id' => $this->user_id,
            'app_name' => $this->app_name,

        ]);
        $query->andFilterWhere(['like', 'user_session.user_platform_version', $this->user_platform_version])
        ->andFilterWhere(['like', 'user_session.application_version', $this->application_version]);

        return $dataProvider;
    }
}
