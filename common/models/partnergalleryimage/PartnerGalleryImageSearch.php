<?php

namespace common\models\partnergalleryimage;

use common\models\partnergalleryimage\PartnerGalleryImage;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PartnerGalleryImageSearch represents the model behind the search form of PartnerGalleryImage.
 */
class PartnerGalleryImageSearch extends PartnerGalleryImage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner_gallery_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['caption'], 'string'],
            [['title'], 'string', 'max' => 255],
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
        $query = PartnerGalleryImage::find()->where(['status' => [PartnerGalleryImage::STATUS_ACTIVE, PartnerGalleryImage::STATUS_SUSPEND]]);

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
            'partner_gallery_id' => $this->partner_gallery_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
