<?php

namespace api\models\partnergallery;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PartnerGallerySearch represents the model behind the search form of PartnerGallery.
 */
class PartnerGallerySearch extends PartnerGallery
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_id', 'title'], 'safe'],
            // [['safari_operator_id', 'listing_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_approved', 'send_for_approval', 'in_draft', 'live_gallery_images_count', 'gallery_images_count', 'is_live'], 'integer'],
            [['safari_operator_id', 'listing_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'live_gallery_images_count', 'gallery_images_count'], 'integer'],
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
        $query = PartnerGallery::find()->where(['listing_status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ]
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
            'safari_operator_id' => $this->safari_operator_id,
            // 'in_draft' => $this->in_draft,
            // 'is_approved' => $this->is_approved,
            // 'is_live' => $this->is_live,
            // 'send_for_approval' => $this->send_for_approval,
            // 'created_at' => $this->created_at,
            // 'created_by' => $this->created_by,
            // 'updated_at' => $this->updated_at,
            // 'updated_by' => $this->updated_by,
            'listing_status' => $this->listing_status,
        ]);

        return $dataProvider;
    }
}
