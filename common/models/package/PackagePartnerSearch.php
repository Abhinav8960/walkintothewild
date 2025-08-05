<?php

namespace common\models\package;

use common\models\GeneralModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\package\Package;
use DateTime;

/**
 * PackageVersionSearch represents the model behind the search form of `common\models\package\Package`.
 */
class PackagePartnerSearch extends Package
{
    public $park_id;
    public $month_id;
    public $estimated_price_filter_min = 0;
    public $estimated_price_filter_max = 0;
    public $no_of_safari_min = 1;
    public $no_of_safari_max = 0;
    public $no_of_night_min = 0;
    public $no_of_night_max = 0;
    public $package_feature;
    public $package_include;
    public $custom_sort_by;
    public $package_name;
    public $report_days;
    public $package_start_date;
    public $package_end_date;
    public $cost_per_person_min;
    public $cost_per_person_max;


    public $business_name;

    public $custom_status;

    public $report_days_option = [
        'all' => 'All',
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'tw' => 'This Week',
        'tm' => 'This Month',
        'lm' => 'Last Month',
        'tfy' => 'This Financial Year',
    ];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_of_day', 'no_of_night', 'no_of_safari', 'start_location', 'end_location', 'stay_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'owned_by_id'], 'safe'],
            [['cost_per_person'], 'safe'],
            [['package_description', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'package_name'], 'safe'],
            [['package_name'], 'safe'],
            [['package_image', 'report_days'], 'safe'],
            [['park_id', 'month_id', 'estimated_price_filter_min', 'estimated_price_filter_max', 'no_of_safari_min', 'no_of_safari_max', 'no_of_night_min', 'no_of_night_max', 'package_feature', 'package_include', 'custom_sort_by', 'package_start_date', 'package_end_date'], 'safe'],
            [['is_published_on_web', 'is_published_on_api'], 'boolean'],
            [['is_published_on_web', 'is_published_on_api'], 'safe'],
            [['cost_per_person_min', 'cost_per_person_max'], 'safe'],
            [['business_name'], 'string'],
            [['custom_status'], 'safe'],

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



    public function getParkoption()
    {
        return GeneralModel::safariparklist();
    }






    public function search($params)
    {
        $query = Package::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filteringcost_per_person conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'no_of_day' => $this->no_of_day,
            // 'version' => $this->version,
            'start_location' => $this->start_location,
            'end_location' => $this->end_location,
            'stay_category_id' => $this->stay_category_id,
            'package_inclusion' => $this->package_inclusion,
            'package_description' => $this->package_description,
            'package_exclusion' => $this->package_exclusion,
            'package_terms_condtition' => $this->package_terms_condtition,
            'owned_by_id' => $this->owned_by_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_published_on_web' => $this->is_published_on_web,
            'is_published_on_api' => $this->is_published_on_api,
            Package::tableName() . '.status' => $this->status,
        ]);



        $query->andFilterWhere(['like', 'package_name', $this->package_name]);


        if ($this->cost_per_person_min && $this->cost_per_person_max) {
            $dataProvider->query->andFilterWhere(['between', 'cost_per_person', $this->cost_per_person_min, $this->cost_per_person_max]);
        }


        if ($this->no_of_night_min && $this->no_of_night_max) {
            if ($this->no_of_night_max >= 10) {
                $dataProvider->query->andWhere('no_of_night>=' . $this->no_of_night_min);
            } else {
                $dataProvider->query->andFilterWhere(['between', 'no_of_night', $this->no_of_night_min, $this->no_of_night_max]);
            }
        }

        if ($this->no_of_safari_min && $this->no_of_safari_max) {
            if ($this->no_of_safari_max >= 10) {
                $dataProvider->query->andWhere('no_of_safari>=' . $this->no_of_safari_min);
            } else {
                $dataProvider->query->andFilterWhere(['between', 'no_of_safari', $this->no_of_safari_min, $this->no_of_safari_max]);
            }
        }


        if ($this->month_id) {
            $query->andWhere("MONTH(start_date)=" . $this->month_id);
            // $query->andWhere("MONTH(start_date)=" . $this->month_id . " OR MONTH(end_date)=" . $this->month_id);
        }




        if ($this->park_id) {
            $query->joinwith(['packagepark' => function ($park_query) {
                $park_query->andFilterWhere(['park_id' => $this->park_id]);
            }]);
        }


        if ($this->package_include) {
            $query->joinwith(['packageincluded' => function ($package_include_query) {
                $package_include_query->andFilterWhere(['include_id' => $this->package_include]);
            }]);
        }

        if ($this->package_feature) {
            $query->joinwith(['packagefeatures' => function ($package_feature_query) {
                $package_feature_query->andFilterWhere(['feature_id' => $this->package_feature]);
            }]);
        }


        if ($this->custom_sort_by) {
            if ($this->custom_sort_by == '1') {
                $dataProvider->sort = [
                    'defaultOrder' => ['created_at' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == '2') {
                $dataProvider->sort = [
                    'defaultOrder' => ['no_of_safari' => SORT_ASC]
                ];
            } else if ($this->custom_sort_by == '3') {
                $dataProvider->sort = [
                    'defaultOrder' => ['no_of_safari' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == '4') {
                $dataProvider->sort = [
                    'defaultOrder' => ['cost_per_person' => SORT_ASC]
                ];
            } else if ($this->custom_sort_by == '5') {
                $dataProvider->sort = [
                    'defaultOrder' => ['popular_package' => SORT_DESC]
                ];
            }
        }

        if ($this->business_name) {
            $query->joinwith(['safarioperator' => function ($safari_operator_query) {
                $safari_operator_query->andFilterWhere(['like', 'safari_operator.business_name', $this->business_name]);
            }]);
        }

        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }

        // if ($this->custom_status != null) {
        //     switch ($this->custom_status) {
        //         // case 0:
        //         //     $query->andWhere(['status' => 0]);
        //         //     break;
        //         case 1:
        //             $query->andWhere(['IS NOT ', 'live_version' , null]);
        //             break;
        //         case 2:
        //             $query->andWhere(['IS NOT ', 'pending_for_approval_version' , null]);
        //             break;
        //         case 3:
        //             $query->andWhere(['IS NOT ', 'editable_version' , null]);
        //             break;

        //     };
        // }

        if ($this->custom_status != null) {
            switch ($this->custom_status) {
                // case 0:
                //     $query->andWhere(['status' => 0]);
                //     break;
                case 1:
                    $query->andWhere([Package::tableName() . '.status' => 1]);
                    break;
                case 2:
                    $query->andWhere([Package::tableName() . '.status' => 10]);
                    break;
                // case 3:
                //     $query->andWhere(['IS NOT ', 'editable_version', null]);
                //     break;
                case 4:
                    $query->andWhere(['IS NOT', Package::tableName() . '.status', -1]);
                    break;
            };
        }

        return $dataProvider;
    }
}
