<?php

namespace common\models\package;

use common\models\package\PackageQuote;
use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PackageQuoteSearch represents the model behind the search form of `common\models\package\PackageQuote`.
 */
class PackageQuoteSearch extends PackageQuote
{
    public $report_days;
    public $name;



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
            [['package_id', 'travelers', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['start_date', 'user_agent', 'os', 'browser', 'device_type','name'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 45],
            [['report_days'], 'safe']
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
        $query = PackageQuote::find()->where(['package_quote.status' => [PackageQuote::STATUS_ACTIVE, PackageQuote::STATUS_SUSPEND]]);

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
            'package_quote.id' => $this->id,
            'package_quote.package_id' => $this->package_id,
            'package_quote.start_date' => $this->start_date,
            'package_quote.created_at' => $this->created_at,
            'package_quote.created_by' => $this->created_by,
            'package_quote.updated_at' => $this->updated_at,
            'package_quote.updated_by' => $this->updated_by,
            'package_quote.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'package_quote.travelers', $this->travelers]);

        if ($this->report_days) {
            // 
            $query->andWhere($this->rawdatequery);
        }


        if ($this->name) {
            $query->joinwith(['package' => function ($query) {
                $query->andWhere(['like', 'package.package_name', $this->name]);
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
