<?php

namespace common\models\cms\blog;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 */
class BlogCommentSearch extends BlogComment
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_id', 'user_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'string'],
            [['comment_datetime', 'flaged'], 'safe'],
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
        $query =  BlogComment::find()->andWhere(['is_deleted' => 0]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 20 : $pagination],
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
            'blog_id' => $this->blog_id,
            'user_id' => $this->user_id,
            'flaged' => $this->flaged,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);
        return $dataProvider;
    }

    public static function getBloglist()
    {
        return ArrayHelper::map(Blog::find()->where(['status' => [1, 2]])->andWhere("id IN (SELECT Distinct blog_id FROM blog_comment)")->all(), 'id', 'title');
    }
}
