<?php

namespace common\models\trierror;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\trierror\SitePages;

/**
 * SearchSitePages represents the model behind the search form of `common\models\trierror\SitePages`.
 */
class SearchSitePages extends SitePages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content_id', 'counter', 'status'], 'integer'],
            [['content_type', 'category', 'url', 'slug', 'last_update_at', 'updated_at', 'created_at'], 'safe'],
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
        $query = SitePages::find();
        $query->where(['status' => true]);
        $query->orderBy('id DESC');
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
            'content_id' => $this->content_id,
            'last_update_at' => $this->last_update_at,
            'counter' => $this->counter,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        if ($this->category != 'select_all') {
            //print_r($params);
            //die();
            $query->andFilterWhere(['category' => $this->category]);
        }

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
