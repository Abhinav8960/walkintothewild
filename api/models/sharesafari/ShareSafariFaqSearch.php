<?php

namespace api\models\sharesafari;


use yii\base\Model;
use yii\data\ActiveDataProvider;


class ShareSafariFaqSearch extends ShareSafariFaq
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_safari_id', 'position', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['answer'], 'string'],
            [['question'], 'string', 'max' => 512],
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
        $query = ShareSafariFaq::find()->where(['status' => [ShareSafariFaq::STATUS_ACTIVE, ShareSafariFaq::STATUS_SUSPEND]]);

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
            'share_safari_id' => $this->share_safari_id,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'question', $this->question]);
        $query->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
