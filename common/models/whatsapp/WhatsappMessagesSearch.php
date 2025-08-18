<?php

namespace common\models\whatsapp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\whatsapp\WhatsappMessages;

/**
 * WhatsappMessagesSearch represents the model behind the search form of `common\models\whatsapp\WhatsappMessages`.
 */
class WhatsappMessagesSearch extends WhatsappMessages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'partner_id', 'conversation_id', 'contact_id'], 'integer'],
            [['wamid', 'direction', 'message_type', 'content', 'media_url', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = WhatsappMessages::find();

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
            'user_id' => $this->user_id,
            'partner_id' => $this->partner_id,
            'conversation_id' => $this->conversation_id,
            'contact_id' => $this->contact_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'wamid', $this->wamid])
            ->andFilterWhere(['like', 'direction', $this->direction])
            ->andFilterWhere(['like', 'message_type', $this->message_type])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'media_url', $this->media_url])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}