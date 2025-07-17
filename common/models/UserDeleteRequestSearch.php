<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class UserDeleteRequestSearch extends UserDeleteRequest
{
    /**
     * {@inheritdoc}
     */

    public $status;
    
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at','email'],'safe'],
            [['email'], 'string', 'max' => 255],
            [['user_id'],'integer'],
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

        $query = UserDeleteRequest::find(); 

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20, 
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->created_at)) {
            $start = strtotime($this->created_at . ' 00:00:00');
            $end = strtotime($this->created_at . ' 23:59:59');
    
            $query->andFilterWhere(['between', 'user_delete_request.created_at', $start, $end]);
        }
         

        $query->andFilterWhere([
            'user_delete_request.id' => $this->id,
            'user_delete_request.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'user_delete_request.email', $this->email]);

        if(!empty($this->status))
        {
            $query->joinwith(['user' => function ($query) {
                $query->andFilterWhere(['like', 'user.status', $this->status]);
            }]);
        }


        return $dataProvider;
    }
}
