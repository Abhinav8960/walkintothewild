<?php

namespace common\models\userprivacypolicyacknowledgement;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserPrivacyPolicyAcknowledgementSearch extends UserPrivacyPolicyAcknowledgement
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'document_version','created_at'],'safe'],
            [['user_id', 'document_id', 'created_by','updated_at' ,'updated_by'], 'integer'],
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
        $query = UserPrivacyPolicyAcknowledgement::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20, 
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->created_at)) {
            $start = strtotime($this->created_at . ' 00:00:00');
            $end = strtotime($this->created_at . ' 23:59:59');
    
            $query->andFilterWhere(['between', 'user_privacy_policy_acknowledgement.created_at', $start, $end]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'document_version' => $this->document_version,
            'document_id' => $this->document_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
