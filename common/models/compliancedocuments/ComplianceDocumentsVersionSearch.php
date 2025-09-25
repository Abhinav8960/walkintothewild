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
            [['id', 'compliance_documents_id', 'created_by', 'status'], 'integer'],
            [['content','title'], 'safe'],
            [['effective_date', 'created_at'], 'safe'],
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
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'compliance_documents_id' => $this->compliance_documents_id,
            'title' => $this->title,
            'effective_date' => $this->effective_date,
            'status' => $this->status,
            'created_at' => $this->created_by,
            'created_at' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);
        $query->andFilterWhere(['like', 'title', $this->title]);


        return $dataProvider;
    }
}
