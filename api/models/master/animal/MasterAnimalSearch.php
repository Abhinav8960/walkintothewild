<?php

namespace api\models\master\animal;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\master\animal\MasterAnimal;

/**
 * MasterAnimalSearch represents the model behind the search form of `api\models\master\animal\MasterAnimal`.
 */
class MasterAnimalSearch extends MasterAnimal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'is_filter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_filter_sequence'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 125],
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
        $query = MasterAnimal::find()->where(['status' => [MasterAnimal::STATUS_ACTIVE, MasterAnimal::STATUS_SUSPEND]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
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
            'slug' => $this->slug,
            'is_filter' => $this->is_filter,
            'is_filter_sequence' => $this->is_filter_sequence,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'animal_type' => $this->animal_type
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
