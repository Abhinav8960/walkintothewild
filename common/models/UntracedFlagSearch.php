<?php

namespace common\models;

use common\models\cms\article\ArticleCommentReport;
use common\models\operator\SafariOperatorRatingReport;
use common\models\package\PackageCommentReport;
use common\models\sharesafari\ShareSafariCommentReport;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UntracedFlagSearch represents the model behind the search form of `common\models\UntracedFlag`.
 */
class UntracedFlagSearch extends Model
{
    public $type;
    public $comment;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['comment'], 'safe'],
        ];
    }

    public function search($params, $pagination = true)
    {

        $this->load($params);

        if ($this->type == 1) {
            // $query =  BlogCommentReport::find()->where(['status' => 3]);
        } else if ($this->type == 2) {
            $query =  SafariOperatorRatingReport::find()->where(['status' => 3]);
        } else if ($this->type == 3) {
            $query =  PackageCommentReport::find()->where(['status' => 3]);
        } else  if ($this->type == 4) {
            $query =  ShareSafariCommentReport::find()->where(['status' => 3]);
        } else  if ($this->type == 5) {
            $query =  ArticleCommentReport::find()->where(['status' => 3]);
        }

        if (isset($query)) {
            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 20 : $pagination],
                'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            ]);

            // $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            // if ($this->type == 1) {
            //     $query->andFilterWhere(['like', 'comment', $this->comment]);
            // }


            // $query->andFilterWhere(['like', 'comment', $this->comment]);
            return $dataProvider;
        }
    }
}
