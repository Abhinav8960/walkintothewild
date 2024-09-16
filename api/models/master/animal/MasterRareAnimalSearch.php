<?php

namespace common\models\master\animal;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MasterRareAnimalSearch represents the model behind the search form of `common\models\master\animal\MasterRareAnimal`.
 */
class MasterRareAnimalSearch extends MasterRareAnimal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['animal_name', 'banner', 'feature_image', 'know_as'], 'string', 'max' => 255],
            [['short_description'], 'string', 'max' => 512],
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
        $query = MasterRareAnimal::find()->where(['status' => [1, 2]]);

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
            'know_as' => $this->know_as,
            'feature_image' => $this->feature_image,
            'banner' => $this->banner,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'animal_name', $this->animal_name]);

        return $dataProvider;
    }
}
