<?php

namespace common\models\compliancedocuments;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ComplianceDocumentsVersionSearch represents the model behind the search form of `ComplianceDocumentsVersion`.
 */
class ComplianceDocumentsVersionSearch extends ComplianceDocumentsVersion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','compliance_documents_id', 'version', 'type', 'version_created_by','status'], 'integer'],
            [['content'], 'safe'],
            [['effective_date', 'version_datetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass parent scenarios()
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
        $query = ComplianceDocumentsVersion::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['version_datetime' => SORT_DESC]], 
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'compliance_documents_id' => $this->compliance_documents_id,
            'version' => $this->version,
            'type' => $this->type,
            'effective_date' => $this->effective_date,
            'status' => $this->status,
            'version_datetime' => $this->version_datetime,
            'version_created_by' => $this->version_created_by,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
