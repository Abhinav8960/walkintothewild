<?php

namespace common\models\article\article;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\article\article\Article;

/**
 * DeploymentPhaseSearch represents the model behind the search form of `common\models\deployment`.
 */
class ArticleSearch extends Article
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_title', 'writer','link','video','image'], 'string', 'max' => 255],
            ['post_date', 'date', 'format' => 'php:Y-m-d'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by','source'], 'integer'],
            [['tag_id'], 'safe'],
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
    public function search($params, $pagination = true)
    {
        $query = Article::find()->where(['status' => [1, 2]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
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
            'article_title' => $this->article_title,
            'writer' => $this->writer,
            'link' => $this->link,
            'tag_id' => $this->tag_id,
            'video' => $this->video,
            'image' => $this->image,
            'source' => $this->source,
            'post_date' => $this->post_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'article_title', $this->article_title]);
        $query->andFilterWhere(['like', 'source', $this->source]);
        $query->andFilterWhere(['like', 'writer', $this->writer]);
        $query->andFilterWhere(['=', 'post_date', $this->post_date]);
        $query->andFilterWhere(['in', 'tag_id', $this->tag_id]);
        

        return $dataProvider;
    }
}
