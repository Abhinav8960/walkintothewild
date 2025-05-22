<?php

namespace common\models\partnerregistration;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PartnerRegistrationSearch represents the model behind the search form of `common\models\partnerregistration\PartnerRegistration`.
 */
class PartnerRegistrationSearch extends PartnerRegistration
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'form1_status', 'form2_status', 'form3_status', 'form4_status', 'form5_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'current_step', 'status','is_sendforapproval'], 'integer'],
            [['legal_entity_type', 'legal_entity_name', 'brand_name', 'logo', 'legal_entity_phone', 'legal_entity_whatsapp', 'legal_entity_email', 'address', 'registration_number', 'registration_copy_upload', 'pan_number', 'pan_upload', 'operated_park', 'about_business', 'gst_id', 'billing_mail', 'billing_phone', 'bank_name', 'account_holder_name', 'account_number', 'ifsc_number', 'cancel_check_upload', 'owner_name', 'kyc_phone', 'kyc_whatsapp', 'kyc_email', 'kyc_pan', 'kyc_pan_upload', 'aadhar_number', 'aadhar_front_upload', 'aadhar_back_upload'], 'safe'],
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
        $query = PartnerRegistration::find();

        // Add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Filter conditions

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'form1_status' => $this->form1_status,
            'form2_status' => $this->form2_status,
            'form3_status' => $this->form3_status,
            'form4_status' => $this->form4_status,
            'form5_status' => $this->form5_status,
            'current_step' => $this->current_step,
            'status'=>$this->status,
            'is_sendforapproval' => $this->is_sendforapproval,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'legal_entity_type', $this->legal_entity_type])
            ->andFilterWhere(['like', 'legal_entity_name', $this->legal_entity_name])
            ->andFilterWhere(['like', 'brand_name', $this->brand_name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'legal_entity_phone', $this->legal_entity_phone])
            ->andFilterWhere(['like', 'legal_entity_whatsapp', $this->legal_entity_whatsapp])
            ->andFilterWhere(['like', 'legal_entity_email', $this->legal_entity_email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'registration_number', $this->registration_number])
            ->andFilterWhere(['like', 'registration_copy_upload', $this->registration_copy_upload])
            ->andFilterWhere(['like', 'pan_number', $this->pan_number])
            ->andFilterWhere(['like', 'pan_upload', $this->pan_upload])
            ->andFilterWhere(['like', 'operated_park', $this->operated_park])
            ->andFilterWhere(['like', 'about_business', $this->about_business])
            ->andFilterWhere(['like', 'gst_id', $this->gst_id])
            ->andFilterWhere(['like', 'billing_mail', $this->billing_mail])
            ->andFilterWhere(['like', 'billing_phone', $this->billing_phone])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'account_holder_name', $this->account_holder_name])
            ->andFilterWhere(['like', 'account_number', $this->account_number])
            ->andFilterWhere(['like', 'ifsc_number', $this->ifsc_number])
            ->andFilterWhere(['like', 'cancel_check_upload', $this->cancel_check_upload])
            ->andFilterWhere(['like', 'owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'kyc_phone', $this->kyc_phone])
            ->andFilterWhere(['like', 'kyc_whatsapp', $this->kyc_whatsapp])
            ->andFilterWhere(['like', 'kyc_email', $this->kyc_email])
            ->andFilterWhere(['like', 'kyc_pan', $this->kyc_pan])
            ->andFilterWhere(['like', 'kyc_pan_upload', $this->kyc_pan_upload])
            ->andFilterWhere(['like', 'aadhar_number', $this->aadhar_number])
            ->andFilterWhere(['like', 'aadhar_front_upload', $this->aadhar_front_upload])
            ->andFilterWhere(['like', 'aadhar_back_upload', $this->aadhar_back_upload]);

        return $dataProvider;
    }
}
