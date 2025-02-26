<?php

namespace common\models\reportsection;

use common\models\sharesafari\ShareSafariIntrested;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReportSectionSearch extends Model
{
    public $id;
    public $start_date;
    public $end_date;
    public $park_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'park_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
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
        $query = ShareSafariIntrested::find()
            ->joinWith('sharesafari')
            ->where(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE])
            ->andWhere(['!=', 'share_safari.status', -1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'share_safari_intrested.id' => $this->id,
        ]);

        // grid filtering conditions
        if ($this->start_date && $this->end_date) {
            $startTimestamp = strtotime($this->start_date . ' 00:00:00');
            $endTimestamp = strtotime($this->end_date . ' 23:59:59');
            $query->andWhere(['between', 'share_safari_intrested.intrested_at', $startTimestamp, $endTimestamp]);
        }


        if ($this->park_id) {
            $query->joinwith(['sharesafari' => function ($query) {
                $query->joinwith(['park' => function ($query) {
                    $query->andWhere(['safari_park.id' => $this->park_id]);
                }]);
            }]);
        }

        return $dataProvider;
    }
}
