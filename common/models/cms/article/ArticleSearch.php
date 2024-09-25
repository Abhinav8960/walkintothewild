<?php

namespace common\models\cms\article;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class ArticleSearch extends Article
{

    public $article_tags;
    public $article_topics;
    public $report_days;
    public $is_approved;
    public $user_name;


    public $report_days_option = [
        'all' => 'All',
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'tw' => 'This Week',
        'tm' => 'This Month',
        'lm' => 'Last Month',
        'tfy' => 'This Financial Year',
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'user_name'], 'string'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['article_date', 'article_tags', 'article_topics', 'report_days'], 'safe'],
            [['title', 'banner_image'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 300],
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
        $query =  Article::find()->where(['article.status' => [Article::STATUS_ACTIVE, Article::STATUS_SUSPEND]]);


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
            'article_date' => $this->article_date,
            'article.is_approved' => $this->is_approved,
            'article.status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'article.title', $this->title]);


        if ($this->article_tags) {
            $query->joinwith(['articletags' => function ($tag_query) {
                $tag_query->andFilterWhere(['master_tag_id' => $this->article_tags]);
            }]);
        }

        if ($this->article_topics) {
            $query->joinwith(['articletopics' => function ($topic_query) {
                $topic_query->andFilterWhere(['master_topic_id' => $this->article_topics]);
            }]);
        }

        if ($this->user_name) {
            $query->joinwith(['user' => function ($user_query) {
                $user_query->andFilterWhere(['like', 'user.name', $this->user_name]);
            }]);
        }

        return $dataProvider;
    }


    
}
