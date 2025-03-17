<?php

namespace common\models\sharesafari;

use common\models\park\SafariPark;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ShareSafariCommentSearch represents the model behind the search form of `common\models\sharesafari\ShareSafariCommentSearch`.
 */
class ShareSafariCommentSearch extends ShareSafariComment
{
    public $share_safari_id;
    public $flaged;
    public $share_safari_title;
    public $start_date;
    public $end_date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_safari_id', 'flaged', 'is_deleted'], 'integer'],
            [['share_safari_title'],'string'],
            [['start_date','end_date'],'safe'],
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
        $query = ShareSafariComment::find()->where(['flaged' => 1, 'is_deleted' => 0]);

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
            'share_safari_id' => $this->share_safari_id,
            'flaged' => $this->flaged,
        ]);

        //        $rawSql = $query->createCommand()->getRawSql();
        //        dd($rawSql);

        return $dataProvider;
    }

    public function listingsearch($params, $pagination = true)
    {
        $query = ShareSafariComment::find()->where(['is_deleted' => 0]);

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
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
            'share_safari_id' => $this->share_safari_id,
        ]);

        if ($this->share_safari_title) {
            $query->joinwith(['sharesafari' => function ($title_query) {
                $title_query->andWhere(['like', 'share_safari_title', $this->share_safari_title]);
            }]);
        }

        if ($this->start_date && $this->end_date) {
            $startTimestamp = strtotime($this->start_date . ' 00:00:00');
            $endTimestamp = strtotime($this->end_date . ' 23:59:59');
            $query->andWhere(['between', 'share_safari_comment.created_at', $startTimestamp, $endTimestamp]);
        }

        return $dataProvider;
    }


    public static function getSafarilist()
    {
        return ArrayHelper::map(SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'is_shared_safari' => 1])->andWhere("id IN (SELECT Distinct park_id FROM share_safari_comment)")->all(), 'id', 'title');
    }
}
