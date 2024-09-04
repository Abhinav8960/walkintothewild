<?php

namespace common\models\sharesafari;

use common\models\park\SafariPark;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ShareSafariCommentSearch represents the model behind the search form of `common\models\sharesafari\ShareSafariCommentSearch`.
 */
class ShareSafariCommentSearch extends ShareSafariComment
{
    public $share_safari_id;
    public $flaged;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['share_safari_id', 'flaged'], 'integer'],
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
        $query = ShareSafariComment::find()->where(['flaged' => 1, 'is_deleted' => 0]);

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 200 : $pagination],
            'sort' => ['defaultOrder' => ['updated_at' => SORT_ASC]],

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
            'park_id' => $this->share_safari_id,
            'flaged' => $this->flaged,
        ]);

        //        $rawSql = $query->createCommand()->getRawSql();
        //        dd($rawSql);

        return $dataProvider;
    }


    public static function getSafarilist()
    {
        return ArrayHelper::map(SafariPark::find()->where(['status' => 1, 'is_shared_safari' => 1])->andWhere("id IN (SELECT Distinct park_id FROM share_safari_comment)")->all(), 'id', 'title');
    }
}
