<?php

namespace api\models\posts;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserPostSearch represents the model behind the search form of `api\models\posts\UserPosts`.
 */
class UserPostSearch extends UserPosts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'type_of_post',
                'user_id',
                'height',
                'width',
                'like_count',
                'status',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by',
            ], 'integer'],
            [['caption', 'description'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['file'], 'string', 'max' => 512],
            [['safari_session_id', 'location','master_animal_id'],'safe']
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
        $query = UserPosts::find()->where(['status' => [UserPosts::STATUS_ACTIVE]]);

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
            'type_of_post' => $this->type_of_post,
            'location' => $this->location,
            'master_animal_id' => $this->master_animal_id,
            'safari_session_id' => $this->safari_session_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        

        return $dataProvider;
    }
}
