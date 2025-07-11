<?php

namespace common\models\chat;

use common\models\operator\SafariOperator;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use Yii;

/**
 * ChatSearch represents the model behind the search form of `common\models\Chat`.
 */
class ChatDisplaySearch extends Chat
{
   
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','lead_id','user_id','recipient_user_id','last_message','park_id','package_id','quote_id','call_id','chat_type' ],'safe'],
            ['status', 'integer'],
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
        $query = Chat::find();

        $query->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination ? ['pageSize' => 10] : false,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['lead_id' => $this->lead_id]);
        $query->andFilterWhere(['user_id' => $this->user_id]);
        $query->andFilterWhere(['recipient_user_id' => $this->recipient_user_id]);
        $query->andFilterWhere(['park_id' => $this->park_id]);
        $query->andFilterWhere(['package_id' => $this->package_id]);
        $query->andFilterWhere(['quote_id' => $this->quote_id]);
        $query->andFilterWhere(['call_id' => $this->call_id]);
        $query->andFilterWhere(['chat_type' => $this->chat_type]);
        $query->andFilterWhere(['status' => $this->status]);

        $query->andFilterWhere(['like', 'last_message', $this->last_message]);


        if (!empty($this->name)) {
            $query->leftJoin(['user' => User::tableName()], 'chat.user_id = user.id');
            $query->leftJoin(['recipient' => User::tableName()], 'chat.recipient_user_id = recipient.id');
            $query->leftJoin(['safari_operator' => SafariOperator::tableName()], 'chat.recipient_user_id = safari_operator.user_id');
        
            $query->andWhere([
                'or',
                ['like', 'user.name', $this->name],
                ['like', 'recipient.name', $this->name],
                ['like', 'safari_operator.business_name', $this->name],
            ]);
        }

        return $dataProvider;
    }
}