<?php

namespace common\models\trackings;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\trackings\Footprints;

/**
 * FootprintsSearch represents the model behind the search form of `common\models\trackings\Footprints`.
 */
class FootprintsSearch extends Footprints
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'collection', 'collection_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['objective', 'action', 'date_time', 'device', 'platform', 'platform_version', 'browser', 'browser_version', 'application_version'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Footprints::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'collection' => $this->collection,
            'collection_id' => $this->collection_id,
            'date_time' => $this->date_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'objective', $this->objective])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'device', $this->device])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'platform_version', $this->platform_version])
            ->andFilterWhere(['like', 'browser', $this->browser])
            ->andFilterWhere(['like', 'browser_version', $this->browser_version])
            ->andFilterWhere(['like', 'application_version', $this->application_version]);

        return $dataProvider;
    }
}
