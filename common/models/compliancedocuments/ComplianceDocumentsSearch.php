<?php

namespace common\models\compliancedocuments;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ComplianceDocumentsVersionSearch represents the model behind the search form of `ComplianceDocumentsVersion`.
 */
class ComplianceDocumentsSearch extends ComplianceDocuments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'created_by','status'], 'integer'],
            [['content'], 'safe'],
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
        $query = ComplianceDocuments::find();

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
            'type' => $this->type,
            'effective_date' => $this->effective_date,
            'status' =>$this->status,
            'created_at' => $this->created_by,
            'created_at' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
