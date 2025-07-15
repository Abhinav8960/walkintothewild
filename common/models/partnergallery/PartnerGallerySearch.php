<?php

namespace common\models\partnergallery;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PartnerGallerySearch represents the model behind the search form of PartnerGallery.
 */
class PartnerGallerySearch extends PartnerGallery
{
    public $custom_filter;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['safari_operator_id', 'title'], 'safe'],
            [['safari_operator_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'can_send_for_approval', 'is_approved', 'send_for_approval', 'in_draft', 'live_gallery_images_count', 'gallery_images_count','is_live'], 'integer'],
            [['custom_filter'], 'safe'],
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
        $query = PartnerGallery::find()->where(['status' => [PartnerGallery::STATUS_ACTIVE, PartnerGallery::STATUS_SUSPEND]]);

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
            'safari_operator_id' => $this->safari_operator_id,
            'in_draft' => $this->in_draft,
            'is_approved' => $this->is_approved,
            'is_live' => $this->is_live,
            'send_for_approval' => $this->send_for_approval,
            'can_send_for_approval' => $this->can_send_for_approval,
            // 'created_at' => $this->created_at,
            // 'created_by' => $this->created_by,
            // 'updated_at' => $this->updated_at,
            // 'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        if ($this->custom_filter) {
            switch ($this->custom_filter) {
                case 1:
                    $dataProvider->sort = [
                        'defaultOrder' => ['created_at' => SORT_DESC]
                    ];
                    break;
                case 2:
                    $dataProvider->sort = [
                        'defaultOrder' => ['gallery_images_count' => SORT_DESC]
                    ];

                    break;
                case 3:
                    $dataProvider->sort = [
                        'defaultOrder' => ['live_gallery_images_count' => SORT_DESC]
                    ];

                    break;
                default:
                    $dataProvider->sort = [
                        'defaultOrder' => ['created_at' => SORT_DESC]
                    ];
            };
        }

        return $dataProvider;
    }
}
