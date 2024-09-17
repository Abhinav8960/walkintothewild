<?php

namespace common\models\park;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\park\SafariParkZone;

/**
 * SafariParkZoneSearch represents the model behind the search form of `common\models\park\SafariParkZone`.
 */
class SafariParkZoneSearch extends SafariParkZone
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_park_id', 'master_zone_type_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['zone_name', 'entry_gate_name'], 'string', 'max' => 255],
            [['entry_gate_latitude', 'entry_gate_longitude'], 'string', 'max' => 50],
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
        $query = SafariParkZone::find()->where(['status' => [SafariParkZone::STATUS_ACTIVE, SafariParkZone::STATUS_SUSPEND]]);

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
            'safari_park_id' => $this->safari_park_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'zone_name', $this->zone_name]);

        return $dataProvider;
    }
}
