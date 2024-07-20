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
    public $park_id;
    public $month_id;
    public $estimated_price_filter;

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
            [['park_id', 'month_id', 'estimated_price_filter'], 'safe']
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
        $query = Package::find()->where(['package.status' => [1, 2]]);

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
            'package_exclusion' => $this->package_exclusion,
            'package_terms_condtition' => $this->package_terms_condtition,
            'package_slug' => $this->package_slug,
            'package_image' => $this->package_image,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'package.status' => $this->status,
        ]);



        $query->andFilterWhere(['like', 'package_name', $this->package_name]);


        if ($this->month_id) {
            $query->andWhere("MONTH(start_date)=" . $this->month_id);
            // $query->andWhere("MONTH(start_date)=" . $this->month_id . " OR MONTH(end_date)=" . $this->month_id);
        }

        if ($this->estimated_price_filter) {
            $price_query = "";
            foreach ((array)$this->estimated_price_filter as $price_filter) {
                if ($price_filter == 1) {
                    $price_query .= "cost_per_person >= 0 AND cost_per_person <= 5000 OR cost_per_person >= 0 AND cost_per_person <= 5000 OR ";
                } else if ($price_filter == 2) {
                    $price_query .= "cost_per_person >= 5000 AND cost_per_person <= 10000 OR cost_per_person >= 5000 AND cost_per_person <= 10000 OR ";
                } else if ($price_filter == 3) {
                    $price_query .= "cost_per_person >= 10000 AND cost_per_person >= 15000 OR cost_per_person >= 10000 AND cost_per_person >= 15000 OR ";
                }
            }
            if ($price_query <> '') {
                $price_query = substr($price_query, 0, -3);
                $query->andWhere($price_query);
            }
        }


        if ($this->park_id) {
            $query->joinwith(['packagepark' => function ($park_query) {
                $park_query->andFilterWhere(['park_id' => $this->park_id]);
            }]);
        }


        return $dataProvider;
    }
}
