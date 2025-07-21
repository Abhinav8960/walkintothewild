<?php

namespace common\models\package;

use common\models\package\PackageFaq;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PackageFaqSearch represents the model behind the search form of `common\models\package\PackageFaq`.
 */
class PackageFaqSearch extends PackageFaq
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'position', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['answer'], 'string'],
            [['question','version'], 'string', 'max' => 512],
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
        $query = PackageFaq::find()->where(['status' => [PackageFaq::STATUS_ACTIVE, PackageFaq::STATUS_SUSPEND]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]],
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
            'package_id' => $this->package_id,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'question', $this->question]);
        $query->andFilterWhere(['like', 'version', $this->version]);
        $query->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
