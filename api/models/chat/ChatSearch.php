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


    public function directchatcontcatsearch($params, $user_id, $pagination = true)
    {

        // $query = User::find()
        //     ->where("user.user_handle IS NOT NULL")
        //     ->andWhere(['!=', 'user.id', $user_id])
        //     ->joinWith(['chat' => function ($query) use ($user_id) {
        //         $query->andWhere([
        //             'chat.chat_type' => 1,
        //         ])->andWhere([
        //             'or',
        //             ['chat.user_id' => $user_id],
        //             ['chat.recipient_user_id' => $user_id],
        //         ]);
        //     }])
        //     ->addSelect([
        //         'user.*',
        //         'chat_last_message_at' => (new \yii\db\Query())
        //             ->select('MAX(chat.last_message_at)')
        //             ->from('chat')
        //             ->where('chat.user_id = user.id OR chat.recipient_user_id = user.id')
        //     ])
        //     ->orderBy(['chat_last_message_at' => SORT_DESC]);


        $query = Chat::find()->andWhere([
            'or',
            ['chat.user_id' => $user_id],
            ['chat.recipient_user_id' => $user_id],
        ])
            ->andWhere(['chat.chat_type' => 1])
            ->orderBy(['last_message_at' => SORT_DESC]);


        // $query = User::find()->where("user.user_handle IS NOT NULL")->andWhere(['!=', 'user.id', $user_id])
        //     ->joinWith(['chatsend' => function ($query) {
        //         $query->andWhere(['chat.chat_type' => 1]);
        //     }, 'chatrecive' => function ($query) {
        //         $query->andWhere(['chat.chat_type1' => 1]);
        //     }]);

        // add conditions that should always apply here
        // $query->distinct();
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


        $query->andFilterWhere(['like', 'user.name', $this->name]);
        return $dataProvider;
    }


    public function partnersearch($params, $user_id)
    {
        $query = Chat::find()->andWhere([
            'chat.recipient_user_id' => $user_id
        ]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'chat.chat_type' => $this->chat_type,
        ]);


        return $dataProvider;
    }
}
