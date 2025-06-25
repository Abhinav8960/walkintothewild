<?php

namespace common\models\firebasenotification;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FirebaseNotificationLogSearch represents the model behind the search form of common\models\firebasenotification\FirebaseNotificationLog.
 */
class FirebaseNotificationLogSearch extends FirebaseNotificationLog
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'created_at', 'status', 'created_at', 'is_system_notification'], 'integer'],
            [['message', 'image_url'], 'string'],
            [['master_notification_template_id', 'sent_data'], 'safe'],
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
    public function search($params)
    {
        $query = FirebaseNotificationLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => array('pageSize' => 20),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // $query->andFilterWhere([
        //     'created_by' => \Yii::$app->user->id
        // ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'message' => $this->message,
            'action' => $this->action,
            'status' => $this->status,
            'is_system_notification' => $this->is_system_notification,
            'created_by' => $this->created_by,
        ]);
        // echo $this->created_at;
        // exit;
        // die('hi');
        $query
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'master_notification_template_id', $this->master_notification_template_id])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
