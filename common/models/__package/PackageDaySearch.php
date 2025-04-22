<?php

namespace common\models\__package;

use common\models\package\PackageDay;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PackageDaySearch represents the model behind the search form of `common\models\package\PackageDay`.
 */
class PackageDaySearch extends PackageDay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'day', 'meal_lunch', 'meal_breakfast', 'meal_dinner', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['day_description', 'day_activity', 'day_accommodation', 'day_note'], 'string'],
            [['day_title'], 'string', 'max' => 512],
            [['start_location', 'end_location', 'hotel_name', 'day_image'], 'string', 'max' => 255],
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
        $query = PackageDay::find()->where(['status' => [PackageDay::STATUS_ACTIVE, Package::STATUS_SUSPEND]]);

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
            'package_id' => $this->package_id,
            'day' => $this->day,
            'meal_lunch' => $this->meal_lunch,
            'meal_breakfast' => $this->meal_breakfast,
            'meal_dinner' => $this->meal_dinner,
            'start_location' => $this->start_location,
            'end_location' => $this->end_location,
            'hotel_name' => $this->hotel_name,
            'day_image' => $this->day_image,
            'day_activity' => $this->day_activity,
            'day_accommodation' => $this->day_accommodation,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'day_title', $this->day_title]);
        $query->andFilterWhere(['like', 'day_note', $this->day_note]);

        return $dataProvider;
    }
}
