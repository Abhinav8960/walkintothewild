<?php

namespace api\models\master\suggetioncategory;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\master\suggetioncategory\MasterSuggestionCategory;

/**
 * MasterSuggestionCategorySearch represents the model behind the search form of `api\models\master\suggetioncategory\MasterSuggestionCategory`.
 */
class MasterSuggestionCategorySearch extends MasterSuggestionCategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 125],
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
        $query = MasterSuggestionCategory::find()->where(['status' => [MasterSuggestionCategory::STATUS_ACTIVE, MasterSuggestionCategory::STATUS_SUSPEND]]);

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['sequence' => SORT_ASC]],
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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
