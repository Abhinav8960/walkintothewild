<?php

namespace frontend\models;

use common\models\cms\article\Article;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class ArticleSearch extends Article
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'meta_description', 'meta_keywords', 'post_body'], 'string'],
            [['article_author_id', 'view', 'comment_allowed', 'approval_required', 'is_schedule', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['publish_date_time', 'article_date'], 'safe'],
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
            'id' => $this->id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}
