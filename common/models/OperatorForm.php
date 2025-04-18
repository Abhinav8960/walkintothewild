<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_form".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone_no
 * @property string|null $whatsap_no
 * @property string|null $dob
 * @property string|null $gender
 * @property resource|null $kyc_detail
 * @property string|null $business_registration_name
 * @property string|null $business_brand_name
 * @property string|null $business_full_name
 * @property string|null $business_phone_no
 * @property string|null $business_whatsap_no
 * @property string|null $business_email_id
 * @property string|null $business_logo_upload
 * @property string|null $type_of_business
 * @property string|null $business_doc_reg_no
 * @property string|null $business_kyc_detail
 * @property string|null $business_operated_park
 * @property string|null $business_detail
 * @property string|null $gst
 * @property string|null $bank_name
 * @property string|null $account_holder_name
 * @property string|null $account_no
 * @property string|null $ifsc_code
 * @property string|null $cancle_check
 * @property string|null $upload_adhar_no
 * @property string|null $upload_aadhar_front
 * @property string|null $upload_aadhar_back
 * @property string|null $pan_no
 * @property string|null $pan_upload
 * @property string|null $upload_registration_number
 * @property string|null $upload_registration_cert
 * @property string|null $upload_document
 */
class OperatorForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'name',
                'email',
                'phone_no',
                'whatsap_no',
                'dob',
                'gender',
                'kyc_detail',
                'business_registration_name',
                'business_brand_name',
                'business_full_name',
                'business_phone_no',
                'business_whatsap_no',
                'business_email_id',
                'business_logo_upload',
                'type_of_business',
                'business_doc_reg_no',
                'business_kyc_detail',
                'business_operated_park',
                'business_detail',
                'gst',
                'bank_name',
                'account_holder_name',
                'account_no',
                'ifsc_code',
                'cancle_check',
                'upload_adhar_no',
                'upload_aadhar_front',
                'upload_aadhar_back',
                'pan_no',
                'pan_upload',
                'upload_registration_number',
                'upload_registration_cert',
                'upload_document'
            ], 'default', 'value' => null],
            [['dob'], 'safe'],
            [['kyc_detail', 'business_detail'], 'string'],
            [['name', 'email', 'type_of_business', 'business_doc_reg_no', 'bank_name', 'account_holder_name', 'upload_registration_number'], 'string', 'max' => 100],
            [['phone_no', 'whatsap_no'], 'string', 'max' => 15],
            [['gender'], 'string', 'max' => 10],
            [['business_registration_name', 'business_brand_name', 'business_full_name', 'business_email_id'], 'string', 'max' => 150],
            [['business_phone_no', 'business_whatsap_no', 'ifsc_code', 'upload_adhar_no', 'pan_no'], 'string', 'max' => 20],
            [[
                'business_logo_upload',
                'business_kyc_detail',
                'business_operated_park',
                'cancle_check',
                'upload_aadhar_front',
                'upload_aadhar_back',
                'pan_upload',
                'upload_registration_cert',
                'upload_document'
            ], 'string', 'max' => 255],
            [['gst'], 'string', 'max' => 30],
            [['account_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'whatsap_no' => 'Whatsap No',
            'dob' => 'Dob',
            'gender' => 'Gender',
            'kyc_detail' => 'Kyc Detail',
            'business_registration_name' => 'Registration Name',
            'business_brand_name' => 'Brand Name',
            'business_full_name' => 'Full Name',
            'business_phone_no' => 'Phone No',
            'business_whatsap_no' => 'Whatsap No',
            'business_email_id' => 'Email ID',
            'business_logo_upload' => 'Logo Upload',
            'type_of_business' => 'Type Of Business',
            'business_doc_reg_no' => 'Document Registration Number',
            'business_kyc_detail' => 'Kyc Detail',
            'business_operated_park' => 'Operated Park',
            'business_detail' => 'Detail',
            'gst' => 'Gst',
            'bank_name' => 'Bank Name',
            'account_holder_name' => 'Account Holder Name',
            'account_no' => 'Account Number',
            'ifsc_code' => 'IFSC Code',
            'cancle_check' => 'Cancle Check',
            'upload_adhar_no' => 'Aadhar Number',
            'upload_aadhar_front' => 'Aadhar Front Upload',
            'upload_aadhar_back' => 'Aadhar Back Upload',
            'pan_no' => 'Pan Number',
            'pan_upload' => 'Pan Upload',
            'upload_registration_number' => 'Registration Number',
            'upload_registration_cert' => 'Registration Certificate Upload',
            'upload_document' => 'Document Upload',
        ];
    }


    public function saveUploads()
    {
        $path = Yii::$app->params['datapath'] . '/Uploads';
    
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    
        $path .= '/' . $this->id;
    
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    
        foreach ([
            'business_logo_upload', 'business_kyc_detail', 'cancle_check', 'upload_aadhar_front',
            'upload_aadhar_back', 'pan_upload', 'upload_registration_number',
            'upload_registration_cert', 'upload_document'
        ] as $field) {
            if ($this->$field) {
                $fileName = $this->$field->baseName . '.' . $this->$field->extension;
                $filePath = $path . '/' . $fileName;
    
                $this->$field->saveAs($filePath);
                $this->$field = $filePath; 
            }
        }
    }
    
}
