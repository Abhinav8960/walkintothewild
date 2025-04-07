<?php

namespace common\models\business\businessrequest;

use common\models\business\businessrequest\BusinessRequest;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class BusinessRequestSearch extends BusinessRequest
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'is_approved'], 'integer'],
            [['business_name',], 'string', 'max' => 255],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],

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
    public function search($params, $pagination = true)
    {
        $query =  BusinessRequest::find();


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
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
            'is_approved' => $this->is_approved,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'business_name', $this->business_name]);

        return $dataProvider;
    }
}
