<?php

namespace common\models\leads;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\leads\Lead;

/**
 * LeadSearch represents the model behind the search form of `common\models\leads\Lead`.
 */
class LeadSearch extends Lead
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'source', 'package_id', 'park_id', 'operator_id', 'is_date_flexible', 'travelers', 'user_id', 'is_booking_for_login_user', 'is_seen_by_admin', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'package_version', 'email', 'phone', 'destination', 'from_date', 'to_date', 'accommodation', 'transport', 'meals', 'budget', 'addional_notes'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Lead::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'source' => $this->source,
            'package_id' => $this->package_id,
            'park_id' => $this->park_id,
            'operator_id' => $this->operator_id,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'is_date_flexible' => $this->is_date_flexible,
            'travelers' => $this->travelers,
            'user_id' => $this->user_id,
            'is_booking_for_login_user' => $this->is_booking_for_login_user,
            'is_seen_by_admin' => $this->is_seen_by_admin,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'package_version', $this->package_version])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'accommodation', $this->accommodation])
            ->andFilterWhere(['like', 'transport', $this->transport])
            ->andFilterWhere(['like', 'meals', $this->meals])
            ->andFilterWhere(['like', 'budget', $this->budget])
            ->andFilterWhere(['like', 'addional_notes', $this->addional_notes]);

        return $dataProvider;
    }
}
