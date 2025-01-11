<?php

namespace api\models\package;

use common\models\GeneralModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use DateTime;


class PackageSearch extends Package
{
    public $park_id;
    public $month_id;
    public $estimated_price_filter_min = 1000;
    public $estimated_price_filter_max = 50000;
    public $no_of_safari_min = 1;
    public $no_of_safari_max = 10;
    public $no_of_night_min = 0;
    public $no_of_night_max = 10;
    public $package_feature;
    public $package_include;
    public $custom_sort_by;
    public $package_name;
    public $report_days;
    public $owned_by_id;
    public $uuid;

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
            [['no_of_day', 'owned_by_id', 'no_of_night', 'no_of_safari', 'start_location', 'end_location', 'stay_category_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status','uuid'], 'safe'],
            [['cost_per_person'], 'safe'],
            [['package_description', 'package_inclusion', 'package_exclusion', 'package_terms_condtition', 'package_name'], 'safe'],
            [['package_name'], 'safe'],
            [['package_slug'], 'safe'],
            [['package_image', 'report_days'], 'safe'],
            [['park_id', 'month_id', 'estimated_price_filter_min', 'estimated_price_filter_max', 'no_of_safari_min', 'no_of_safari_max', 'no_of_night_min', 'no_of_night_max', 'package_feature', 'package_include', 'custom_sort_by'], 'safe']
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
        $query = Package::find()->where(['package.status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['popular_package' => SORT_DESC, 'created_at' => SORT_DESC]],
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
            'owned_by_id' => $this->owned_by_id,
        ]);
        if(!empty($this->uuid))
        {
            $query->andFilterWhere([
                'id' => convert_uudecode(base64_decode($this->uuid)),
              
            ]);
        }


        $query->andFilterWhere(['like', 'package_name', $this->package_name]);

        if ($this->estimated_price_filter_min && $this->estimated_price_filter_max) {
            if ($this->estimated_price_filter_max >= 50000) {
                $dataProvider->query->andWhere('cost_per_person>=' . $this->estimated_price_filter_min);
            } else {
                $dataProvider->query->andFilterWhere(['between', 'cost_per_person', $this->estimated_price_filter_min, $this->estimated_price_filter_max]);
            }
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
            $query->joinwith(['searchpackagepark' => function ($park_query) {
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

        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }

        return $dataProvider;
    }

    public function managesearch($params, $safari_operator_id)
    {
        $query =  Package::find()->where([
            'owned_by_id' => $safari_operator_id
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort' => ['defaultOrder' => ['popular_package' => SORT_DESC, 'created_at' => SORT_DESC]],
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
            'package.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'package.package_name', $this->package_name]);

        if ($this->park_id) {
            $query->joinwith(['packagepark' => function ($park_query) {
                $park_query->andFilterWhere(['park_id' => $this->park_id]);
            }]);
        }

        return $dataProvider;
    }

    public function getParkoption()
    {
        return GeneralModel::safariparklist();
    }



    /**
     * Raw Query
     */
    public function getRawdatequery()
    {
        $query = "1=1";

        // Create DateTime objects for current date and time
        $now = new DateTime();

        if ($this->report_days == 'today') { // Today
            $start = $now->setTime(0, 0, 0)->getTimestamp();
            $end = $now->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'yesterday') { // Yesterday
            $yesterday = (new DateTime('yesterday'));
            $start = $yesterday->setTime(0, 0, 0)->getTimestamp();
            $end = $yesterday->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tw') { // This Week
            $start = (new DateTime('monday this week'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('sunday this week'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tm') { // This Month
            $start = (new DateTime('first day of this month'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('last day of this month'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'lm') { // Last Month
            $start = (new DateTime('first day of last month'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('last day of last month'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tfy') { // This Financial Year
            $financialYearStart = new DateTime('April ' . $now->format('Y'));
            if ($now < $financialYearStart) {
                $financialYearStart = new DateTime('April ' . $now->format('Y', strtotime('-1 year')));
            }
            $start = $financialYearStart->setTime(0, 0, 0)->getTimestamp();
            $end = $now->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        }

        return $query;
    }
}
