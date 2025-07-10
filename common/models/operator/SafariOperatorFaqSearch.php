<?php

namespace common\models\operator;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SafariOperatorFaqSearch represents the model behind the search form of `common\models\operator\SafariOperatorFaq`.
 */
class SafariOperatorFaqSearch extends SafariOperatorFaq
{
    /**
     * {@inheritdoc}
     */

    public $id;
    public $status;
    public $share_safari_id;


    public function rules()
    {
        return [
            [['id','safari_operator_id','status', 'created_at'], 'integer'],
            // [['question', 'answer'], 'safe'],
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
        $query = SafariOperatorFaq::find();

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
            'status' => $this->status,
            'safari_operator_id'=>$this->safari_operator_id,
        ]);

       

        return $dataProvider;
    }
}
