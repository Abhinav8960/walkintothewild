<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\park\SafariPark;

/**
 * SafariParkSearch represents the model behind the search form of `common\models\park\SafariPark`.
 */
class SafariParkSearch extends SafariPark
{
    public $month_id;
    public $master_animal_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_description', 'long_description', 'meta_description', 'meta_keywords'], 'string'],
            [['master_location_id', 'country_id', 'state_id', 'city_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'slug', 'official_website', 'country_name', 'state_name', 'city_name', 'avg_safari_price_min', 'avg_safari_price_max', 'nearest_railway_station', 'nearest_airport', 'nearest_bus_station', 'meta_title'], 'string', 'max' => 255],
            [['latitude', 'longitude'], 'string', 'max' => 50],
            [['month_id', 'master_animal_id'], 'safe']
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
        $query = SafariPark::find()->where(['status' => 1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 1000 : $pagination],
            'sort' => ['defaultOrder' => ['title' => SORT_ASC]],

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
