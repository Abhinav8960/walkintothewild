<?php

namespace common\models\compliancedocuments;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ComplianceDocumentsVersionSearch represents the model behind the search form of `common\models\compliancedocuments`.
 */
class ComplianceDocumentsVersionSearch extends ComplianceDocumentsVersion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'compliance_documents_id'], 'safe'],
            [['version'], 'string', 'max' => 255],
            [['is_live', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
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
        $query = ComplianceDocuments::find();

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
            'compliance_documents_id' => $this->compliance_documents_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_live' => $this->is_live,
        ]);
        $query->andFilterWhere(['like', 'version', $this->version]);

        return $dataProvider;
    }
}
