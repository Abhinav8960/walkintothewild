<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OperatorForm;

/**
 * OperatorFormSearch represents the model behind the search form of `common\models\OperatorForm`.
 */
class OperatorFormSearch extends OperatorForm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'email', 'phone_no', 'whatsap_no', 'dob', 'gender', 'kyc_detail', 'business_registration_name', 'business_brand_name', 'business_full_name', 'business_phone_no', 'business_whatsap_no', 'business_email_id', 'business_logo_upload', 'type_of_business', 'business_doc_reg_no', 'business_kyc_detail', 'business_operated_park', 'business_detail', 'gst', 'bank_name', 'account_holder_name', 'account_no', 'ifsc_code', 'cancle_check', 'upload_adhar_no', 'upload_aadhar_front', 'upload_aadhar_back', 'pan_no', 'pan_upload', 'upload_registration_number', 'upload_registration_cert', 'upload_document'], 'safe'],
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
        $query = OperatorForm::find();

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
            'dob' => $this->dob,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone_no', $this->phone_no])
            ->andFilterWhere(['like', 'whatsap_no', $this->whatsap_no])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'kyc_detail', $this->kyc_detail])
            ->andFilterWhere(['like', 'business_registration_name', $this->business_registration_name])
            ->andFilterWhere(['like', 'business_brand_name', $this->business_brand_name])
            ->andFilterWhere(['like', 'business_full_name', $this->business_full_name])
            ->andFilterWhere(['like', 'business_phone_no', $this->business_phone_no])
            ->andFilterWhere(['like', 'business_whatsap_no', $this->business_whatsap_no])
            ->andFilterWhere(['like', 'business_email_id', $this->business_email_id])
            ->andFilterWhere(['like', 'business_logo_upload', $this->business_logo_upload])
            ->andFilterWhere(['like', 'type_of_business', $this->type_of_business])
            ->andFilterWhere(['like', 'business_doc_reg_no', $this->business_doc_reg_no])
            ->andFilterWhere(['like', 'business_kyc_detail', $this->business_kyc_detail])
            ->andFilterWhere(['like', 'business_operated_park', $this->business_operated_park])
            ->andFilterWhere(['like', 'business_detail', $this->business_detail])
            ->andFilterWhere(['like', 'gst', $this->gst])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'account_holder_name', $this->account_holder_name])
            ->andFilterWhere(['like', 'account_no', $this->account_no])
            ->andFilterWhere(['like', 'ifsc_code', $this->ifsc_code])
            ->andFilterWhere(['like', 'cancle_check', $this->cancle_check])
            ->andFilterWhere(['like', 'upload_adhar_no', $this->upload_adhar_no])
            ->andFilterWhere(['like', 'upload_aadhar_front', $this->upload_aadhar_front])
            ->andFilterWhere(['like', 'upload_aadhar_back', $this->upload_aadhar_back])
            ->andFilterWhere(['like', 'pan_no', $this->pan_no])
            ->andFilterWhere(['like', 'pan_upload', $this->pan_upload])
            ->andFilterWhere(['like', 'upload_registration_number', $this->upload_registration_number])
            ->andFilterWhere(['like', 'upload_registration_cert', $this->upload_registration_cert])
            ->andFilterWhere(['like', 'upload_document', $this->upload_document]);

        return $dataProvider;
    }
}
