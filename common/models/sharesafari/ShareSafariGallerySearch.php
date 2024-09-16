<?php

namespace common\models\sharesafari;

use common\models\sharesafari\ShareSafariGallery;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ShareSafariGallerySearch represents the model behind the search form of `common\models\package\ShareSafariGallery`.
 */
class ShareSafariGallerySearch extends ShareSafariGallery
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_safari_id', 'sequence', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['image_caption'], 'string', 'max' => 512],
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
        $query = ShareSafariGallery::find()->where(['status' => [ShareSafariGallery::STATUS_ACTIVE, ShareSafariGallery::STATUS_SUSPEND]]);

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
