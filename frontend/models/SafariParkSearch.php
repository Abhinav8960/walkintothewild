<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\park\SafariPark;
//use common\models\master\animal\MasterRareAnimal;
use common\models\master\animal\MasterAnimal;

/**
 * SafariParkSearch represents the model behind the search form of `common\models\park\SafariPark`.
 */
class SafariParkSearch extends SafariPark
{
    public $month_id;
    public $master_animal_id;
    public $master_rare_animal_id;
    public $master_vehicle_id;
    public $accomodation_id;
    public $session_id;
    public $bonus_experience_id;
    public $custom_sort_by;
    public $safari_park_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_description', 'long_description', 'meta_description', 'meta_keywords', 'safari_park_id'], 'safe'],
            [['master_location_id', 'country_id', 'state_id', 'city_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_most_demanding', 'is_shared_safari'], 'safe'],
            [['title', 'slug', 'official_website', 'country_name', 'state_name', 'city_name', 'avg_safari_price_min', 'avg_safari_price_max', 'nearest_railway_station', 'nearest_airport', 'nearest_bus_station', 'meta_title'], 'safe'],
            [['latitude', 'longitude', 'custom_sort_by'], 'safe'],
            [['month_id', 'master_animal_id', 'master_rare_animal_id', 'master_vehicle_id', 'accomodation_id', 'session_id', 'bonus_experience_id'], 'safe']
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
        $query = SafariPark::find()->where(['safari_park.status' => 1]);

        // add conditions that should always apply here




        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Sorting based on custom_sort_by attribute
        if ($this->custom_sort_by == 2) {
            $dataProvider->sort = [
                'defaultOrder' => ['title' => SORT_ASC]
            ];
        } else if ($this->custom_sort_by == 3) {
            $dataProvider->sort = [
                'defaultOrder' => ['title' => SORT_DESC]
            ];
        } else {
            $dataProvider->sort = [
                'defaultOrder' => ['is_most_demanding' => SORT_DESC, 'title' => SORT_ASC]
            ];
        }



        if ($this->month_id && $this->month_id != 0) {
            $query->joinwith(['months' => function ($query) {
                $query->andFilterWhere(['safari_park_month.month_id' => $this->month_id]);
            }]);
        }

        if ($this->master_animal_id && $this->master_animal_id != 0) {
            $query->joinwith(['animals' => function ($query) {
                $query->andFilterWhere(['safari_parks_animal.master_animal_id' => $this->master_animal_id]);
            }]);
        }

        if (isset($params['slug']) && !empty($params['slug'])) {
            $is_exist = MasterAnimal::find()->where(['slug' => $params['slug']])->andWhere(['status' => true])->one();
            if (!empty($is_exist)) {
                $query->joinwith(['animals' => function ($query) {
                    //$query->andFilterWhere(['safari_parks_animal.master_animal_id' => $is_exist->id]);
                }]);
            }
        }

        if ($this->master_rare_animal_id && $this->master_rare_animal_id != 0) {
            $query->joinwith(['animals' => function ($query) {
                $query->andFilterWhere(['safari_parks_animal.master_animal_id' => $this->master_rare_animal_id]);
            }]);
        }

        if ($this->master_vehicle_id && $this->master_vehicle_id != 0) {
            $query->joinwith(['vehicles' => function ($query) {
                $query->andFilterWhere(['safari_parks_vehicle.vehicle_id' => $this->master_vehicle_id]);
            }]);
        }



        if ($this->accomodation_id && $this->accomodation_id != 0) {
            $query->joinwith(['accomodations' => function ($query) {
                $query->andFilterWhere(['safari_park_accomodation.master_accomodation_id' => $this->accomodation_id]);
            }]);
        }

        if ($this->session_id && $this->session_id != 0) {
            $query->joinwith(['sessions' => function ($query) {
                $query->andFilterWhere(['safari_park_session.session_id' => $this->session_id]);
            }]);
        }


        if ($this->bonus_experience_id && $this->bonus_experience_id != 0) {
            $query->joinwith(['bonusexperience' => function ($query) {
                $query->andFilterWhere(['safari_park_bonus_experience.master_bonus_experience_id' => $this->bonus_experience_id]);
            }]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'safari_park.id' => $this->id,
            'safari_park.slug' => $this->slug,
            'safari_park.created_at' => $this->created_at,
            'safari_park.created_by' => $this->created_by,
            'safari_park.updated_at' => $this->updated_at,
            'safari_park.updated_by' => $this->updated_by,
            'safari_park.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        if ($this->master_location_id && $this->master_location_id != 0) {
            $query->andFilterWhere(['safari_park.master_location_id' => $this->master_location_id]);
        }

        if ($this->safari_park_id && $this->safari_park_id != 0) {
            $query->andFilterWhere(['safari_park.id' => $this->safari_park_id]);
        }



        // If Rare EXOTIC ANIMAL Selected
        if ($this->master_rare_animal_id == '') {
            $query->andWhere("safari_park.id IN (SELECT distinct safari_park_id from safari_parks_animal WHERE status=1)");
            // $query->andFilterWhere(['like', 'title', 'Tiger Reserve']);
            $query->andWhere(['show_in_filter' => 1]);
        }
        //$rawSql = $query->createCommand()->getRawSql();
        //dd($rawSql);
        return $dataProvider;
    }
}
