<?php

namespace common\models\operator;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * SafariOperatorRatingSearch represents the model behind the search form of `common\models\operator\SafariOperatorRating`.
 */
class SafariOperatorRatingSearch extends SafariOperatorRating
{
    public $custom_sort_by;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_id', 'user_id', 'park_id', 'flaged', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['rating'], 'number'],
            [['review', 'user_agent'], 'string', 'max' => 512],
            [['user_device', 'user_platform', 'user_platform_version', 'user_browser'], 'string', 'max' => 50],
            [['custom_sort_by'], 'safe']
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
        $query = SafariOperatorRating::find()->where(['safari_operator_rating.status' => [1, 2]]);

        // add conditions that should always apply here
        $query->andWhere(['parent_id' => 0]);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->custom_sort_by) {
            if ($this->custom_sort_by == 'newest') {
                $dataProvider->sort = [
                    'defaultOrder' => ['created_at' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == 'highest') {
                $dataProvider->sort = [
                    'defaultOrder' => ['rating' => SORT_DESC]
                ];
            } else if ($this->custom_sort_by == 'lowest') {
                $dataProvider->sort = [
                    'defaultOrder' => ['rating' => SORT_ASC]
                ];
            }
        } else {
            $dataProvider->sort = [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ];
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'safari_operator_id' => $this->safari_operator_id,
            'park_id' => $this->park_id,
            'rating' => $this->rating,
            'review' => $this->review,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'safari_operator_rating.status' => $this->status,
        ]);

        return $dataProvider;
    }

    public static function getOperatorlist()
    {
        return ArrayHelper::map(SafariOperator::find()->where(['status' => [1, 2]])->andWhere("id IN (SELECT Distinct safari_operator_id FROM safari_operator_rating)")->all(), 'id', 'business_name');
    }
}
