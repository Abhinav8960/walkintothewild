<?php

namespace common\models\sharesafari;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ShareSafariSearch represents the model behind the search form of `common\models\sharesafari\ShareSafari`.
 */
class ShareSafariSearch extends ShareSafari
{
    public $month_id;
    public $custom_sort_by;
    public $estimated_price_filter;
    public $date_filter;
    public $title;
    public $report_days;
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
            [['host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'safe'],
            [['start_date', 'end_date', 'estimated_price_filter', 'title', 'report_days', 'type'], 'safe'],
            [['safari_plan', 'month_id', 'custom_sort_by', 'no_of_safari', 'date_filter', 'is_published_on_api', 'is_published_on_web'], 'safe'],
            [['is_published_on_api', 'is_published_on_web'], 'boolean'],
            ['custom_status', 'safe']
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
        $query = ShareSafari::find();

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 200 : $pagination],
            'sort' => ['defaultOrder' => ['updated_at' => SORT_ASC]],

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
            'share_safari.type' => $this->type,
            'share_safari.host_user_id' => $this->host_user_id,
            'share_safari.host_type' => $this->host_type,
            'share_safari.park_id' => $this->park_id,
            'share_safari.share_safari_agenda_id' => $this->share_safari_agenda_id,
            'share_safari.start_date' => $this->start_date,
            'share_safari.end_date' => $this->end_date,
            'share_safari.stay_category_id' => $this->stay_category_id,
            'share_safari.total_seat' => $this->total_seat,
            'share_safari.share_seat' => $this->share_seat,
            'share_safari.created_at' => $this->created_at,
            'share_safari.created_by' => $this->created_by,
            'share_safari.updated_at' => $this->updated_at,
            'share_safari.updated_by' => $this->updated_by,
            'share_safari.is_published_on_api' => $this->is_published_on_api,
            'share_safari.is_published_on_web' => $this->is_published_on_web,
            'share_safari.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'safari_plan', $this->safari_plan]);

        if ($this->month_id) {
            $query->andWhere("MONTH(start_date)=" . $this->month_id);
            // $query->andWhere("MONTH(start_date)=" . $this->month_id . " OR MONTH(end_date)=" . $this->month_id);
        }

        if ($this->estimated_price_filter) {
            $price_query = "";
            foreach ((array)$this->estimated_price_filter as $price_filter) {
                if ($price_filter == 1) {
                    $price_query .= "estimate_price_min >= 0 AND estimate_price_min <= 5000 OR estimate_price_max >= 0 AND estimate_price_max <= 5000 OR ";
                } else if ($price_filter == 2) {
                    $price_query .= "estimate_price_min >= 5000 AND estimate_price_min <= 10000 OR estimate_price_max >= 5000 AND estimate_price_max <= 10000 OR ";
                } else if ($price_filter == 3) {
                    $price_query .= "estimate_price_min >= 10000 AND estimate_price_min >= 15000 OR estimate_price_max >= 10000 AND estimate_price_max >= 15000 OR ";
                }
            }
            if ($price_query <> '') {
                $price_query = substr($price_query, 0, -3);
                $query->andWhere($price_query);
            }
        }

        if ($this->no_of_safari) {
            $safari_query = "";
            foreach ((array)$this->no_of_safari as $no_of_safari) {
                if ($no_of_safari == 1) {
                    $safari_query .= "no_of_safari between 1 and 2 OR ";
                } else if ($no_of_safari == 2) {
                    $safari_query .= "no_of_safari between 3 and 5 OR ";
                } else if ($no_of_safari == 3) {
                    $safari_query .= "no_of_safari between 6 and 8 OR ";
                } else {
                    $safari_query .= "no_of_safari >=8 OR ";
                }
            }
            if ($safari_query <> '') {
                $safari_query = substr($safari_query, 0, -3);
                $query->andWhere($safari_query);
            }
        }

        if ($this->custom_sort_by) {
            if ($this->custom_sort_by == '1') {
                $dataProvider->sort = [
                    'defaultOrder' => ['created_at' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == '2') {
                $dataProvider->sort = [
                    'defaultOrder' => ['no_of_safari' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == '3') {
                $dataProvider->sort = [
                    'defaultOrder' => ['no_of_safari' => SORT_ASC]
                ];
            } else if ($this->custom_sort_by == '4') {
                $dataProvider->sort = [
                    'defaultOrder' => ['estimate_price_min' => SORT_DESC]
                ];
            }
        }

        if ($this->date_filter) {
            $date_query = "start_date <= '" . $this->date_filter . "' AND end_date >= '" . $this->date_filter . "'";
            if ($date_query <> '') {
                $query->andWhere($date_query);
            }
        }

        if ($this->title) {
            $query->joinwith(['park' => function ($title_query) {
                $title_query->andWhere(['like', 'title', $this->title]);
            }]);
        }

        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }
        return $dataProvider;
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


    public function sharedsafarisearch($params, $pagination = true)
    {
        $query = ShareSafari::find()->where(['type' => ShareSafari::TYPE_SAFARI]);

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 200 : $pagination],
            'sort' => ['defaultOrder' => ['pined_safari' => SORT_DESC, 'updated_at' => SORT_DESC]],

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
            'share_safari.type' => $this->type,
            'share_safari.host_user_id' => $this->host_user_id,
            'share_safari.host_type' => $this->host_type,
            'share_safari.park_id' => $this->park_id,
            'share_safari.share_safari_agenda_id' => $this->share_safari_agenda_id,
            'share_safari.start_date' => $this->start_date,
            'share_safari.end_date' => $this->end_date,
            'share_safari.stay_category_id' => $this->stay_category_id,
            'share_safari.total_seat' => $this->total_seat,
            'share_safari.share_seat' => $this->share_seat,
            'share_safari.created_at' => $this->created_at,
            'share_safari.created_by' => $this->created_by,
            'share_safari.updated_at' => $this->updated_at,
            'share_safari.updated_by' => $this->updated_by,
            'share_safari.is_published_on_api' => $this->is_published_on_api,
            'share_safari.is_published_on_web' => $this->is_published_on_web,
            'share_safari.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'safari_plan', $this->safari_plan]);

        if ($this->title) {
            $query->joinwith(['park' => function ($title_query) {
                $title_query->andWhere(['like', 'title', $this->title]);
            }]);
        }

        if ($this->custom_status) {
            switch ($this->custom_status) {
                case -1:
                    $query->andWhere(['status' => -1]);
                    break;
                case 0:
                    $query->andWhere(['status' => 0]);
                    break;
                case 1:
                    $query->andWhere(['status' => 1]);
                    break;
                case 2:
                    $query->andWhere(['status' => 2]);
                    break;
                case 3:
                    $query->andWhere(['>=', 'start_date', date('Y-m-d')])->andWhere(['status' => -1]);
                    break;
            };
        }

        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }
        return $dataProvider;
    }

    public function fixeddeparturesearch($params, $pagination = true)
    {
        $query = ShareSafari::find()->where(['type' => ShareSafari::TYPE_FIXED_DEPARTURE])->andWhere("status <>" . ShareSafari::STATUS_DELETE);

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 200 : $pagination],
            'sort' => ['defaultOrder' => ['updated_at' => SORT_ASC]],

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
            'share_safari.type' => $this->type,
            'share_safari.host_user_id' => $this->host_user_id,
            'share_safari.host_type' => $this->host_type,
            'share_safari.park_id' => $this->park_id,
            'share_safari.share_safari_agenda_id' => $this->share_safari_agenda_id,
            'share_safari.start_date' => $this->start_date,
            'share_safari.end_date' => $this->end_date,
            'share_safari.stay_category_id' => $this->stay_category_id,
            'share_safari.total_seat' => $this->total_seat,
            'share_safari.share_seat' => $this->share_seat,
            'share_safari.created_at' => $this->created_at,
            'share_safari.created_by' => $this->created_by,
            'share_safari.updated_at' => $this->updated_at,
            'share_safari.updated_by' => $this->updated_by,
            'share_safari.is_published_on_api' => $this->is_published_on_api,
            'share_safari.is_published_on_web' => $this->is_published_on_web,
            'share_safari.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'safari_plan', $this->safari_plan]);

        if ($this->title) {
            $query->joinwith(['park' => function ($title_query) {
                $title_query->andWhere(['like', 'title', $this->title]);
            }]);
        }

        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }
        return $dataProvider;
    }


    public function reportsearch($params, $pagination = true)
    {
        $query = ShareSafari::find()->where(['type' => [ShareSafari::TYPE_SAFARI, ShareSafari::TYPE_FIXED_DEPARTURE]])->andWhere("status <>" . ShareSafari::STATUS_DELETE);

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 200 : $pagination],
            'sort' => ['defaultOrder' => ['pined_safari' => SORT_DESC, 'updated_at' => SORT_DESC]],

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
            'share_safari.type' => $this->type,
            'share_safari.host_user_id' => $this->host_user_id,
            'share_safari.host_type' => $this->host_type,
            'share_safari.park_id' => $this->park_id,
            'share_safari.share_safari_agenda_id' => $this->share_safari_agenda_id,
            'share_safari.start_date' => $this->start_date,
            'share_safari.end_date' => $this->end_date,
            'share_safari.stay_category_id' => $this->stay_category_id,
            'share_safari.total_seat' => $this->total_seat,
            'share_safari.share_seat' => $this->share_seat,
            'share_safari.created_at' => $this->created_at,
            'share_safari.created_by' => $this->created_by,
            'share_safari.updated_at' => $this->updated_at,
            'share_safari.updated_by' => $this->updated_by,
            'share_safari.is_published_on_api' => $this->is_published_on_api,
            'share_safari.is_published_on_web' => $this->is_published_on_web,
            'share_safari.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'safari_plan', $this->safari_plan]);

        if ($this->title) {
            $query->joinwith(['park' => function ($title_query) {
                $title_query->andWhere(['like', 'title', $this->title]);
            }]);
        }

        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }
        return $dataProvider;
    }
}
