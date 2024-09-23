<?php

namespace common\models\cms\blog;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 */
class BlogAuthorSearch extends BlogAuthor
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_id', 'created_at', 'created_by', 'updated_by', 'updated_at', 'status'], 'safe'],
            [['author_name', 'author_image'], 'safe'],
            [['slug'], 'safe'],
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
        $query =  BlogAuthor::find()->andWhere(['status' => [self::STATUS_ACTIVE, self::STATUS_SUSPEND]]);


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
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'author_name', $this->author_name]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);
        $query->andFilterWhere(['like', 'author_image', $this->author_image]);
        return $dataProvider;
    }
}
