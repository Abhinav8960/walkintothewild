<?php

namespace common\models\compliancedocuments;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ComplianceDocumentsSearch represents the model behind the search form of `common\models\compliancedocuments`.
 */
class ComplianceDocumentsSearch extends ComplianceDocuments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['effective_from', 'description', 'title','policy_for'], 'safe'],
            // [['version'], 'string', 'max' => 255],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
        // $query = ComplianceDocuments::find()->where(['status'=>[0,1]]);
        $query = ComplianceDocuments::find()
        ->joinWith('versions') 
        ->where(['compliance_documents.status' => [0, 1]]) 
        ->andWhere(['compliance_documents_version.is_live' => 1]); 

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
            // 'uuid' => $this->uuid,
            'title' => $this->title,
            'policy_for' => $this->policy_for,
            'effective_from' => $this->effective_from,
            // 'description' => $this->description,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        // $query->andFilterWhere(['like', 'version', $this->version]);

        return $dataProvider;
    }
}
