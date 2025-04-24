<?php

namespace common\models\quotations\chat;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\quotations\chat\QuotationsChat;

/**
 * QuotationsChatSearch represents the model behind the search form of `common\models\quotations\chat\QuotationsChat`.
 */
class QuotationsChatSearch extends QuotationsChat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quotations_id', 'sender_id', 'receiver_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
            [['message', 'sent_at', 'read_at', 'attachment'], 'safe'],
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
        $query = QuotationsChat::find();

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
            'quotations_id' => $this->quotations_id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'sent_at' => $this->sent_at,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}