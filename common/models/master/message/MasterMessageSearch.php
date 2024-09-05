<?php

namespace common\models\master\message;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\message\MasterMessage;

/**
 * MasterMessageSearch represents the model behind the search form of `common\models\master\message\MasterMessage`.
 */
class MasterMessageSearch extends MasterMessage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'type_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['message'], 'string'],
            [['module'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 4],
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
        $query = MasterMessage::find()->where(['status' => [1, 2]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'module' => $this->module,
            'page_id' => $this->page_id,
            'type_id' => $this->type_id,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
