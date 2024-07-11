<?php

namespace common\models\package;

use common\models\package\Package;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PackageSearch represents the model behind the search form of `common\models\package\Package`.
 */
class PackageSearch extends Package
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_of_day', 'no_of_night', 'no_of_safari', 'start_location', 'end_location', 'stay_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['cost_per_person'], 'number'],
            [['package_description', 'package_inclusion', 'package_exclusion', 'package_terms_condtition'], 'string'],
            [['package_name'], 'string', 'max' => 512],
            [['package_slug'], 'string', 'max' => 720],
            [['package_image'], 'string', 'max' => 255],
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
        $query = Package::find()->where(['status' => [1, 2]]);

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
            'no_of_day' => $this->no_of_day,
            'no_of_night' => $this->no_of_night,
            'no_of_safari' => $this->no_of_safari,
            'start_location' => $this->start_location,
            'end_location' => $this->end_location,
            'stay_category_id' => $this->stay_category_id,
            'package_inclusion' => $this->package_inclusion,
            'package_description' => $this->package_description,
            'cost_per_person' => $this->cost_per_person,
            'package_exclusion' => $this->package_exclusion,
            'package_terms_condtition' => $this->package_terms_condtition,
            'package_slug' => $this->package_slug,
            'package_image' => $this->package_image,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'package_name', $this->package_name]);

        return $dataProvider;
    }
}
