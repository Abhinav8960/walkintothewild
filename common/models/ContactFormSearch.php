<?php

namespace common\models;

use common\models\ContactForm;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContactFormSearch represents the model behind the search form of `common\models\ContactForm`.
 */
class ContactFormSearch extends ContactForm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'user_id'], 'integer'],
            [['name', 'message', 'user_ip_address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 215],
            [['phone'], 'string', 'max' => 10],
            [['user_device', 'user_platform', 'user_platform_version', 'user_browser', 'user_browser_version'], 'safe'],
            [['user_agent'], 'string', 'max' => 512],
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
        $query = ContactForm::find()->where(['status' => [1, 2]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
