<?php

namespace common\models\article\articleSource;

//use common\models\article\article\ArticleSearch;
use common\models\article\articleSource\ArticleSource;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DeploymentPhaseSearch represents the model behind the search form of `common\models\deployment`.
 */
class ArticleSourceSearch extends ArticleSource
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_source','publisher','web_link'], 'string', 'max' => 255],

            [['category_id','frequency_id','status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $pagination = true)
    {
        $query = ArticleSource::find()->where(['status' => [1, 2]]);

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
            'article_source' => $this->article_source,
            'category_id' => $this->category_id,
            'publisher' => $this->publisher,
            'frequency_id' => $this->frequency_id,
            'web_link' => $this->web_link,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'article_source', $this->article_source]);
        $query->andFilterWhere(['like', 'category_id', $this->category_id]);
        $query->andFilterWhere(['like', 'frequency_id', $this->frequency_id]);

        return $dataProvider;
    }
}
