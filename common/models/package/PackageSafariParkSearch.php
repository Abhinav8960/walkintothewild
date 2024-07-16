<?php

namespace common\models\package;

use common\models\package\PackageSafariPark;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PackageSafariParkSearch represents the model behind the search form of `common\models\package\PackageSafariPark`.
 */
class PackageSafariParkSearch extends PackageSafariPark
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'park_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['package_id', 'park_id'], 'unique', 'targetAttribute' => ['package_id', 'park_id']],
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
        $query = PackageSafariPark::find()->where(['status' => [1, 2]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'package_id' => $this->package_id,
            'park_id' => $this->park_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
