<?php

namespace common\models\cms\privacypolicy;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\privacypolicy\Privacypolicy;

class PrivacypolicySearch extends Model
{
    public $id;
    public $name;
    public $description;
    public $status; // Add status property

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'], // Add 'id' and 'status' to the integer validator
            [['name', 'description'], 'safe'], // Add 'slug' and 'description' to the safe validator
            [['name'], 'string', 'max' => 512], // Max length validation for 'name'
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
        $query = Privacypolicy::find()->where(['status' => [1, 2]]);

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

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
