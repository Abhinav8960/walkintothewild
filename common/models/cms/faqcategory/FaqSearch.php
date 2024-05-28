<?php

namespace common\models\cms\faqcategory;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\cms\faqcategory\Faq;

class FaqSearch extends Model
{
    public $id;
    public $name;
    public $status; // Add status property

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'], // Add 'id' and 'status' to the integer validator
            [['name'], 'safe'], // Add 'slug' and 'description' to the safe validator
            [['name'], 'string', 'max' => 251], // Max length validation for 'type'
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
        $query = Faq::find()->where(['status' => [1, 2]]);

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
