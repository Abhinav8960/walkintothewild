<?php

namespace common\models\operatorregistration;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user_form".
 */
class OperatorRegistration extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'operator_registration_form';
    }

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
                'type_of_business',
                'business_doc_reg_no',
                'business_operated_park',
                'business_detail',
                'gst',
                'bank_name',
                'account_holder_name',
                'account_no',
                'ifsc_code',
                'upload_adhar_no',
                'pan_no',
                'upload_registration_number'
            ], 'string'],

            [[
                'name',
                'email',
                'phone_no',
                'business_whatsap_no',
                "business_registration_name",
                'business_brand_name',
                'business_brand_name',
                'business_email_id',
                'account_holder_name',
                'pan_no',
                'upload_adhar_no',
                'account_no',
                'gender'
            ], 'required', 'message' => 'This field is required.'],

            [['dob'], 'safe'],
            [['kyc_detail', 'business_detail'], 'string'],

            [[
                'phone_no',
                'whatsap_no',
                'business_phone_no',
                'business_whatsap_no'
            ], 'match', 'pattern' => '/^[5-9][0-9]{9}$/', 'message' => 'Phone number must be 10 digits and start with 5 or higher.'],

            [['email', 'business_email_id'], 'email'],

            [[
                'business_logo_upload',
                'business_kyc_detail',
                'cancle_check',
                'upload_aadhar_front',
                'upload_aadhar_back',
                'pan_upload',
                'upload_registration_cert',
                'upload_document'
            ], 'file', 'skipOnEmpty' => true],
        ];
    }



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone_no' => 'Phone Number',
            'whatsap_no' => 'WhatsApp Number',
            'dob' => 'Date of Birth',
            'gender' => 'Gender',
            'kyc_detail' => 'KYC Detail',
            'business_registration_name' => 'Business Registration Name',
            'business_brand_name' => 'Business Brand Name',
            'business_full_name' => 'Business Full Name',
            'business_phone_no' => 'Business Phone Number',
            'business_whatsap_no' => 'Business WhatsApp Number',
            'business_email_id' => 'Business Email ID',
            'business_logo_upload' => 'Business Logo',
            'type_of_business' => 'Type of Business',
            'business_doc_reg_no' => 'Business Reg No',
            'business_kyc_detail' => 'Business KYC Detail',
            'business_operated_park' => 'Operated Park',
            'business_detail' => 'Business Detail',
            'gst' => 'GST Number',
            'bank_name' => 'Bank Name',
            'account_holder_name' => 'Account Holder Name',
            'account_no' => 'Account Number',
            'ifsc_code' => 'IFSC Code',
            'cancle_check' => 'Cancelled Cheque',
            'upload_adhar_no' => 'Aadhar Number',
            'upload_aadhar_front' => 'Aadhar Front',
            'upload_aadhar_back' => 'Aadhar Back',
            'pan_no' => 'PAN Number',
            'pan_upload' => 'PAN Upload',
            'upload_registration_number' => 'Reg Number',
            'upload_registration_cert' => 'Reg Certificate',
            'upload_document' => 'Upload Document',
        ];
    }

    public function uploadFiles()
    {
        $basePath = Yii::$app->params['datapath'] . '/Uploads';
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $userFolder = $basePath . '/' . $this->id;
        if (!file_exists($userFolder)) {
            mkdir($userFolder, 0777, true);
        }

        foreach ([
            'business_logo_upload',
            'business_kyc_detail',
            'cancle_check',
            'upload_aadhar_front',
            'upload_aadhar_back',
            'pan_upload',
            'upload_registration_cert',
            'upload_document',
        ] as $field) {
            $file = UploadedFile::getInstance($this, $field);
            if ($file) {
                $fileName = $field . '_' . time() . '.' . $file->extension;
                $filePath = $userFolder . '/' . $fileName;

                if ($file->saveAs($filePath)) {
                    $this->$field = $fileName; 
                } else {
                    Yii::error("File upload failed for: $field", __METHOD__);
                }
            }
        }
    }
}
