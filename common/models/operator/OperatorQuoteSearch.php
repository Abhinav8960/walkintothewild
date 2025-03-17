<?php

namespace common\models\operator;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\operator\OperatorQuote;
use DateTime;

/**
 * OperatorQuoteSearch represents the model behind the search form of `common\models\operator\OperatorQuote`.
 */
class OperatorQuoteSearch extends OperatorQuote
{
    public $report_days;
    public $operator_business_name;


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
            [['safari_park_id', 'operator_id', 'safaris', 'travelers', 'stay_category_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['full_name', 'email', 'start_date', 'end_date', 'user_agent', 'operator_business_name'], 'string', 'max' => 255],
            [['report_days'], 'safe'],
            [['phone_no'], 'string', 'max' => 12],
            [['ip_address'], 'string', 'max' => 45],
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
        $query = OperatorQuote::find()->where(['operator_quote.status' => [OperatorQuote::STATUS_ACTIVE, OperatorQuote::STATUS_SUSPEND]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'operator_quote.id' => $this->id,
            'operator_quote.safari_park_id' => $this->safari_park_id,
            'operator_quote.phone_no' => $this->phone_no,
            'operator_quote.operator_id' => $this->operator_id,
            'operator_quote.email' => $this->email,
            'operator_quote.start_date' => $this->start_date,
            'operator_quote.end_date' => $this->end_date,
            'operator_quote.safaris' => $this->safaris,
            'operator_quote.travelers' => $this->travelers,
            'operator_quote.stay_category_id' => $this->stay_category_id,
            'operator_quote.created_at' => $this->created_at,
            'operator_quote.created_by' => $this->created_by,
            'operator_quote.updated_at' => $this->updated_at,
            'operator_quote.updated_by' => $this->updated_by,
            'operator_quote.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'operator_quote.full_name', $this->full_name]);


        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }

        if ($this->operator_business_name) {
            $query->joinwith(['operator' => function ($query) {
                $query->andWhere(['like', 'safari_operator.business_name', $this->operator_business_name]);
            }]);
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
}
