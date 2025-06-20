<?php

namespace api\models\leads;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\leads\LeadPartners;

/**
 * LeadPartnersSearch represents the model behind the search form of `api\models\leads\LeadPartners`.
 */
class LeadPartnersSearch extends LeadPartners
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lead_id', 'partner_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
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
        $query = LeadPartners::find();

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
            'lead_id' => $this->lead_id,
            'partner_id' => $this->partner_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
