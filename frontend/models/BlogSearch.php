<?php

namespace frontend\models;

use common\models\cms\blog\Blog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class BlogSearch extends Blog
{
    public $topic_slug;
    public $tag_slug;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'meta_description', 'meta_keywords'], 'string'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['blog_date', 'topic_slug', 'tag_slug'], 'safe'],
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
        $query =  Blog::find()->andWhere(['blog.status' => Blog::STATUS_ACTIVE, 'is_approved' => 1]);


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
            'blog.id' => $this->id,
            'blog.status' => $this->status,
            'blog.created_by' => $this->created_by,
            'blog.updated_by' => $this->updated_by,
            'blog.created_at' => $this->created_at,
            'blog.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'blog.title', $this->title]);
        $query->andFilterWhere(['like', 'blog.slug', $this->slug]);
        $query->andFilterWhere(['like', 'blog.description', $this->description]);


        if ($this->topic_slug) {
            $query->joinwith(['blogtopics' => function ($blogtopics_query) {
                $blogtopics_query->joinwith(['blogname' => function ($additional_query) {
                    $additional_query->andWhere(['like', 'master_blog_topic.slug', $this->topic_slug]);
                }]);
            }]);
        }


        if ($this->tag_slug) {
            $query->joinwith(['blogtags' => function ($blogtags_query) {
                $blogtags_query->joinwith(['blogtag' => function ($additional_query) {
                    $additional_query->andWhere(['like', 'master_blog_tag.slug', $this->tag_slug]);
                }]);
            }]);
        }
        return $dataProvider;
    }



    public static function recentpost($slug = null)
    {
        if ($slug) {
            return Blog::find()
                ->joinWith(['blogtopics' => function ($blogtopics_query) use ($slug) {
                    $blogtopics_query->joinWith(['blogname' => function ($additional_query) use ($slug) {
                        $additional_query->andWhere(['like', 'master_blog_topic.slug', $slug]);
                    }]);
                }])
                ->andWhere(['blog.status' => Blog::STATUS_ACTIVE, 'is_approved' => 1])
                ->orderBy('RAND()')
                ->limit(3)
                ->all();
        } else {
            return Blog::find()
                ->andWhere(['blog.status' => Blog::STATUS_ACTIVE, 'is_approved' => 1])
                ->orderBy('RAND()')
                ->limit(3)
                ->all();
        }
    }
}
