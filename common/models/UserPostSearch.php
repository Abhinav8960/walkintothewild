<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class UserPostSearch extends UserPosts
{
    public $user_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption','user_name'], 'string'],
            [['file'], 'string', 'max' => 512],
            [['safari_session_id', 'location', 'master_animal_id', 'status'], 'safe'],
            [['safari_operator_id'], 'integer']

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
        $query = UserPosts::find()->where(['user_posts.status' => [UserPosts::STATUS_ACTIVE, UserPosts::STATUS_SUSPEND]]);

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
            'user_posts.id' => $this->id,
            'user_posts.safari_operator_id' => $this->safari_operator_id,
            'user_posts.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_posts.caption', $this->caption]);

        if(!empty($this->user_name))
        {
            $query->joinwith(['user' => function ($query) {
                $query->andFilterWhere(['like', 'user.name', $this->user_name]);
            }]);
        }


        return $dataProvider;
    }
}
