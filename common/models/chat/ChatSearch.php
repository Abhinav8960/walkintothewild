<?php

namespace common\models\chat;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use Yii;

/**
 * ChatSearch represents the model behind the search form of `common\models\Chat`.
 */
class ChatSearch extends \Yii\base\Model
{
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'safe'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'user.name', $this->name]);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function chatsearch($params, $pagination = true)
    {
        $query = Chat::find()->where(['chat.status' => 1])->andwhere('chat.user_id =' . Yii::$app->user->identity->id . ' OR chat.recipient_user_id=' . Yii::$app->user->identity->id)->orderby(['chat.last_message_at' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->name) {
            $query->joinwith(['user' => function ($user_query) {
                $user_query->andFilterWhere(['like', 'user.name', $this->name]);
            }]);
        }

        return $dataProvider;
    }
}
