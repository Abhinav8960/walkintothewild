<?php

namespace common\models\cms\termscondition;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\termscondition\Termscondition;

class TermsconditionSearch extends Model
{
    public $id;
    public $type;
    public $description;
    public $status; // Add status property

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'], // Add 'id' and 'status' to the integer validator
            [['type', 'description'], 'safe'], // Add 'slug' and 'description' to the safe validator
            [['type'], 'string', 'max' => 251], // Max length validation for 'type'
            [['description'], 'string'],
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
        $query = Termscondition::find()->where(['status' => [1, 2]]);

        // Add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
