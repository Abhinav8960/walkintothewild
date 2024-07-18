<?php

namespace common\models\cms\article;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class ArticleSearch extends Article
{

    public $article_tags;
    public $article_topics;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'meta_description', 'meta_keywords', 'post_body'], 'string'],
            [['article_author_id', 'view', 'comment_allowed', 'approval_required', 'is_schedule', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['publish_date_time', 'article_date', 'article_tags', 'article_topics'], 'safe'],
            [['title', 'banner_image', 'feature_image', 'author_name', 'meta_title'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 300],
            [['sub_title'], 'string', 'max' => 75],
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
        $query =  Article::find()->where(['article.status' => [self::STATUS_ACTIVE, self::STATUS_SUSPEND]]);


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
            'article_author_id' => $this->article_author_id,
            'article_date' => $this->article_date,
            'article.status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        $query->andFilterWhere(['like', 'description', $this->description]);


        if ($this->article_tags) {
            $query->joinwith(['articletags' => function ($tag_query) {
                $tag_query->andFilterWhere(['master_article_tag_id' => $this->article_tags]);
            }]);
        }

        if ($this->article_topics) {
            $query->joinwith(['articletopics' => function ($topic_query) {
                $topic_query->andFilterWhere(['master_article_topic_id' => $this->article_topics]);
            }]);
        }

        return $dataProvider;
    }



    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function usersearch($params, $pagination = true)
    {
        $query =  Article::find()->where(['article.status' => [self::STATUS_ACTIVE, self::STATUS_SUSPEND], 'article.is_approved' => 0])->andWhere(['IS NOT', 'article.user_id', null]);


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
            'article_author_id' => $this->article_author_id,
            'article_date' => $this->article_date,
            'article.status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        $query->andFilterWhere(['like', 'description', $this->description]);


        if ($this->article_tags) {
            $query->joinwith(['articletags' => function ($tag_query) {
                $tag_query->andFilterWhere(['master_article_tag_id' => $this->article_tags]);
            }]);
        }

        if ($this->article_topics) {
            $query->joinwith(['articletopics' => function ($topic_query) {
                $topic_query->andFilterWhere(['master_article_topic_id' => $this->article_topics]);
            }]);
        }

        return $dataProvider;
    }
}
