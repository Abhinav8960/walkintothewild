<?php

namespace api\models\package;

use api\models\package\Package;
use api\models\package\PackageComment;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * PackageCommentSearch represents the model behind the search form of `common\models\package\PackageCommentSearch`.
 */
class PackageCommentSearch extends PackageComment
{
    public $package_id;
    public $flaged;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'flaged'], 'integer'],
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
        $query = PackageComment::find()->where(['parent_id' => null, 'deleted_by' => 0])->joinWith('user')->andWhere(['user.status' => 10]);

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
            'package_id' => $this->package_id,
            'flaged' => $this->flaged,
        ]);


        return $dataProvider;
    }


    public static function getPackagelist()
    {
        return ArrayHelper::map(Package::find()->where(['status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])->andWhere("id IN (SELECT Distinct package_id FROM package_comment)")->all(), 'id', 'package_name');
    }

    public function listingsearch($params, $pagination = true)
    {
        $query = PackageComment::find();

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
            'package_id' => $this->package_id,
            'flaged' => $this->flaged,
        ]);


        return $dataProvider;
    }
}
