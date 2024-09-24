<?php

namespace common\models\cms\blog;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class BlogSearch extends Blog
{

    public $blog_tags;
    public $blog_topics;
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
            [['description', 'meta_description', 'meta_keywords', 'user_name'], 'string'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_approved'], 'integer'],
            [['blog_date', 'blog_tags', 'blog_topics', 'report_days'], 'safe'],
            [['title', 'banner_image', 'meta_title'], 'string', 'max' => 255],
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
        $query =  Blog::find()->where(['blog.status' => [Blog::STATUS_ACTIVE, Blog::STATUS_SUSPEND]]);


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
            'blog_date' => $this->blog_date,
            'blog.is_approved' => $this->is_approved,
            'blog.status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'blog.title', $this->title]);


        if ($this->blog_tags) {
            $query->joinwith(['blogtags' => function ($tag_query) {
                $tag_query->andFilterWhere(['master_tag_id' => $this->blog_tags]);
            }]);
        }

        if ($this->blog_topics) {
            $query->joinwith(['blogtopics' => function ($topic_query) {
                $topic_query->andFilterWhere(['master_topic_id' => $this->blog_topics]);
            }]);
        }

        if ($this->user_name) {
            $query->joinwith(['user' => function ($user_query) {
                $user_query->andFilterWhere(['like', 'user.name', $this->user_name]);
            }]);
        }

        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
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
        $query =  Blog::find()->where(['blog.status' => [Blog::STATUS_ACTIVE, Blog::STATUS_SUSPEND], 'blog.is_approved' => [0, 1]])->andWhere(['IS NOT', 'blog.user_id', null]);


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
            'blog_author_id' => $this->blog_author_id,
            'blog_date' => $this->blog_date,
            'blog.status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'blog.is_approved' => $this->is_approved,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        $query->andFilterWhere(['like', 'description', $this->description]);


        if ($this->blog_tags) {
            $query->joinwith(['blogtags' => function ($tag_query) {
                $tag_query->andFilterWhere(['master_tag_id' => $this->blog_tags]);
            }]);
        }

        if ($this->blog_topics) {
            $query->joinwith(['blogtopics' => function ($topic_query) {
                $topic_query->andFilterWhere(['master_topic_id' => $this->blog_topics]);
            }]);
        }

        return $dataProvider;
    }

    /**
     * Raw Query
     */
    public function getRawdatequery()
    {
        $query = "1=1";

        // Create DateTime objects for current date and time
        $now = new DateTime();

        if ($this->report_days == 'today') { // Today
            $start = $now->setTime(0, 0, 0)->getTimestamp();
            $end = $now->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'yesterday') { // Yesterday
            $yesterday = (new DateTime('yesterday'));
            $start = $yesterday->setTime(0, 0, 0)->getTimestamp();
            $end = $yesterday->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tw') { // This Week
            $start = (new DateTime('monday this week'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('sunday this week'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tm') { // This Month
            $start = (new DateTime('first day of this month'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('last day of this month'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'lm') { // Last Month
            $start = (new DateTime('first day of last month'))->setTime(0, 0, 0)->getTimestamp();
            $end = (new DateTime('last day of last month'))->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        } else if ($this->report_days == 'tfy') { // This Financial Year
            $financialYearStart = new DateTime('April ' . $now->format('Y'));
            if ($now < $financialYearStart) {
                $financialYearStart = new DateTime('April ' . $now->format('Y', strtotime('-1 year')));
            }
            $start = $financialYearStart->setTime(0, 0, 0)->getTimestamp();
            $end = $now->setTime(23, 59, 59)->getTimestamp();
            $query .= " AND created_at BETWEEN $start AND $end";
        }

        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function approvedsearch($params, $pagination = true)
    {
        $query =  Blog::find()->where(['blog.status' => Blog::STATUS_ACTIVE, 'blog.is_approved' => 1]);


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
            'blog_author_id' => $this->blog_author_id,
            'blog_date' => $this->blog_date,
            'blog.status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        $query->andFilterWhere(['like', 'description', $this->description]);


        if ($this->blog_tags) {
            $query->joinwith(['blogtags' => function ($tag_query) {
                $tag_query->andFilterWhere(['master_tag_id' => $this->blog_tags]);
            }]);
        }

        if ($this->blog_topics) {
            $query->joinwith(['blogtopics' => function ($topic_query) {
                $topic_query->andFilterWhere(['master_topic_id' => $this->blog_topics]);
            }]);
        }

        if ($this->report_days) {

            // 
            $query->andWhere($this->rawdatequery);
        }
        return $dataProvider;
    }
}
