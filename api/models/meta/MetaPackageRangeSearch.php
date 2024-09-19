<?php

namespace api\models\meta;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\meta\MetaPackageRange;

/**
 * MetaPackageRangeSearch represents the model behind the search form of `api\models\meta\MetaPackageRange`.
 */
class MetaPackageRangeSearch extends MetaPackageRange
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'min_range', 'max_range', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'safe'],
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
        $query = MetaPackageRange::find();

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
            'min_range' => $this->min_range,
            'max_range' => $this->max_range,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}