<?php

namespace common\models\feeds;

use common\models\feeds\Feeds;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FeedsSearch represents the model behind the search form of `common\models\feeds`.
 */
class FeedsSearch extends Feeds
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['objctive','collection','collection_id'], 'safe'],
            [['objective'], 'string', 'max' => 255],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
        $query = Feeds::find()->where(['feeds.status' => [Feeds::STATUS_ACTIVE, Feeds::STATUS_SUSPEND]]);

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
            'id' => $this->id,
            'objective' => $this->objective,
            'collection' => $this->collection,
            'collectio_id' => $this->collection_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
