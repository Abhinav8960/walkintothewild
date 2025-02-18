<?php

namespace api\models\package;


use yii\base\Model;
use yii\data\ActiveDataProvider;


class PackageGallerySearch extends PackageGallery
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'sequence', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['image'], 'safe'],
            [['image_caption'], 'safe'],
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
        $query = PackageGallery::find()->where(['status' => [PackageGallery::STATUS_ACTIVE, PackageGallery::STATUS_SUSPEND]]);

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
            'image' => $this->image,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'image_caption', $this->image_caption]);

        return $dataProvider;
    }
}
