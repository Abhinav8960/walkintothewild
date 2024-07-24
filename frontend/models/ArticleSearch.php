<?php

namespace frontend\models;

use common\models\cms\article\Article;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class ArticleSearch extends Article
{
    public $topic_slug;
    public $tag_slug;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'meta_description', 'meta_keywords', 'post_body'], 'string'],
            [['article_author_id', 'view', 'comment_allowed', 'approval_required', 'is_schedule', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['publish_date_time', 'article_date', 'topic_slug', 'tag_slug'], 'safe'],
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
        $query =  Article::find()->andWhere(['article.status' => [self::STATUS_ACTIVE]])->andWhere("is_schedule=0 OR DATE(publish_date_time)<='" . date('Y-m-d') . "'");


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 1000 : $pagination],
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
            'article.id' => $this->id,
            'article.status' => $this->status,
            'article.article_author_id' => $this->article_author_id,
            'article.created_by' => $this->created_by,
            'article.updated_by' => $this->updated_by,
            'article.created_at' => $this->created_at,
            'article.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'article.title', $this->title]);
        $query->andFilterWhere(['like', 'article.slug', $this->slug]);
        $query->andFilterWhere(['like', 'article.description', $this->description]);


        if ($this->topic_slug) {
            $query->joinwith(['articletopics' => function ($articletopics_query) {
                $articletopics_query->joinwith(['articlename' => function ($additional_query) {
                    $additional_query->andWhere(['like', 'master_article_topic.slug', $this->topic_slug]);
                }]);
            }]);
        }


        if ($this->tag_slug) {
            $query->joinwith(['articletags' => function ($articletags_query) {
                $articletags_query->joinwith(['articletag' => function ($additional_query) {
                    $additional_query->andWhere(['like', 'master_article_tag.slug', $this->tag_slug]);
                }]);
            }]);
        }
        return $dataProvider;
    }





    public static function recentpost($slug = null)
    {
        if ($slug) {
            return Article::find()
                ->joinWith(['articletopics' => function ($articletopics_query) use ($slug) {
                    $articletopics_query->joinWith(['articlename' => function ($additional_query) use ($slug) {
                        $additional_query->andWhere(['like', 'master_article_topic.slug', $slug]);
                    }]);
                }])
                // ->andWhere(['article.status' => self::STATUS_ACTIVE]) // Filters by active status
                ->andWhere("is_schedule = 0 OR DATE(publish_date_time) <= '" . date('Y-m-d') . "'") // Filters by publication date
                ->andWhere("article.status=1 AND (user_type=3 OR is_approved=1)")
                ->orderBy('RAND()') // Orders the results randomly
                ->limit(3) // Limits the number of results to 3
                ->all(); // Retrieves all matching records
        } else {
            return Article::find()
                // ->andWhere(['article.status' => [self::STATUS_ACTIVE]])
                ->andWhere("is_schedule=0 OR DATE(publish_date_time)<='" . date('Y-m-d') . "'")
                ->andWhere("status=1 AND (user_type=3 OR is_approved=1)")
                ->orderBy('RAND()') // Order by random
                ->limit(3)
                ->all();
        }
    }
}
