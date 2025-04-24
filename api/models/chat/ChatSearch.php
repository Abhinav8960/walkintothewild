<?php

namespace api\models\chat;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\User;
use Yii;

/**
 * ChatSearch represents the model behind the search form of `common\models\Chat`.
 */
class ChatSearch extends \Yii\base\Model
{
    public $name;
    public $chat_type;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'safe'],
            ['chat_type', 'safe'],
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
        $query = User::find()->where("user_handle IS NOT NULL");

        // add conditions that should always apply here
        $this->load($params);

        if ($this->name) {
            $pagination = false;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 15 : $pagination],
        ]);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinwith(['operator'])->andFilterWhere(['like', 'user.name', $this->name])
        ->orFilterWhere(['like', 'safari_operator.business_name', $this->name]);
        return $dataProvider;
    }
}
