<?php

namespace api\models\sharesafari;

use yii\base\Model;
use common\models\GeneralModel;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\db\Expression;

class ShareSafariSearch extends ShareSafari
{
    public $month_id;
    public $custom_sort_by;
    public $estimated_price_filter;
    public $date_filter;
    public $title;
    public $no_of_safari_min = 1;
    public $no_of_safari_max = 10;
    public $estimate_price_min = 0;
    public $estimate_price_max = 50000;
    public $share_safari_title;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['host_user_id', 'host_type', 'park_id', 'share_safari_agenda_id', 'no_of_safari', 'stay_category_id', 'estimate_price_min', 'estimate_price_max', 'total_seat', 'share_seat', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'safe'],
            [['start_date', 'end_date', 'estimated_price_filter', 'title', 'share_safari_title'], 'safe'],
            [['safari_plan', 'month_id', 'custom_sort_by', 'no_of_safari', 'date_filter', 'no_of_safari_min', 'no_of_safari_max', 'type', 'is_published_on_api', 'is_published_on_web'], 'safe'],
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
        //$query = ShareSafari::find()->where(['share_safari.status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'start_date', date("Y-m-d")]);
        $query = ShareSafari::find()
            ->where(['share_safari.status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])
            ->andWhere(new Expression(
                "CASE 
            WHEN share_safari.type = " . ShareSafari::TYPE_SAFARI . " THEN user.status = " . User::STATUS_ACTIVE . " 
            WHEN share_safari.type = " . ShareSafari::TYPE_FIXED_DEPARTURE . " THEN safari_operator.status = 1 
        END"
            ))
            ->leftJoin('user', 'share_safari.type = ' . ShareSafari::TYPE_SAFARI . ' AND share_safari.host_user_id = user.id')
            ->leftJoin('safari_operator', 'share_safari.type = ' . ShareSafari::TYPE_FIXED_DEPARTURE . ' AND share_safari.host_user_id = safari_operator.id')
            ->andWhere(['>=', 'start_date', date("Y-m-d")]);


        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 200 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'share_safari.id' => $this->id,
            'share_safari.host_user_id' => $this->host_user_id,
            'share_safari.type' => $this->type,
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

        if ($this->estimate_price_min && $this->estimate_price_max) {
            if ($this->estimate_price_max >= 50000) {
                $dataProvider->query->andWhere([
                    'or',
                    ['or', ['>=', 'estimate_price_max', $this->estimate_price_min], ['>=', 'estimate_price_min', $this->estimate_price_max]],
                    ['>=', 'cost_per_person', $this->estimate_price_min]
                ]);
            } else {
                $dataProvider->query->andWhere([
                    'or',
                    ['and', ['>=', 'estimate_price_min', $this->estimate_price_min], ['<=', 'estimate_price_min', $this->estimate_price_max]],
                    ['and', ['>=', 'estimate_price_max', $this->estimate_price_min], ['<=', 'estimate_price_max', $this->estimate_price_max]],
                    ['between', 'cost_per_person', $this->estimate_price_min, $this->estimate_price_max]
                ]);
            }
        }




        if ($this->no_of_safari_min && $this->no_of_safari_max) {
            if ($this->no_of_safari_max >= 10) {
                $dataProvider->query->andWhere('no_of_safari>=' . $this->no_of_safari_min);
            } else {
                $dataProvider->query->andFilterWhere(['between', 'no_of_safari', $this->no_of_safari_min, $this->no_of_safari_max]);
            }
        }
        if ($this->custom_sort_by) {
            if ($this->custom_sort_by == '1') {
                $dataProvider->sort = [
                    'defaultOrder' => ['created_at' => SORT_DESC]
                ];
            } elseif ($this->custom_sort_by == '2') {
                $dataProvider->sort = [
                    'defaultOrder' => ['no_of_safari' => SORT_ASC]
                ];
            } elseif ($this->custom_sort_by == '3') {
                $dataProvider->sort = [
                    'defaultOrder' => ['no_of_safari' => SORT_DESC]
                ];
            } elseif ($this->custom_sort_by == '4') {
                $query->orderBy((new \yii\db\Expression('CASE WHEN type=1 THEN estimate_price_min WHEN type=2 THEN cost_per_person END ASC')));
            } elseif ($this->custom_sort_by == '5') {
                $dataProvider->sort = [
                    'defaultOrder' => ['start_date' => SORT_ASC]
                ];
            } elseif ($this->custom_sort_by == '6') {
                $dataProvider->sort = [
                    'defaultOrder' => ['start_date' => SORT_DESC]
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

        return $dataProvider;
    }

    public function getParkoption()
    {
        return GeneralModel::safariparklist();
    }

    public function managesearch($params, $safari_operator_id)
    {
        $query = ShareSafari::find()->where(['host_user_id' => $safari_operator_id, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_SUSPEND, ShareSafari::STATUS_FULL_SEAT], 'type' => 2]);


        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 200 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],

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
            'share_safari.host_user_id' => $this->host_user_id,
            'share_safari.park_id' => $this->park_id,
            'share_safari.host_type' => $this->host_type,
            'share_safari.status' => $this->status,
            'share_safari.is_published_on_api' => $this->is_published_on_api,
            'share_safari.is_published_on_web' => $this->is_published_on_web,
        ]);

        $query->andFilterWhere(['like', 'share_safari.share_safari_title', $this->share_safari_title]);

        return $dataProvider;
    }
}
