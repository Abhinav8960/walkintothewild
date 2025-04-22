<?php

namespace common\models\operatorregistration;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user_form".
 */
class OperatorRegistration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operator_registration_form';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone_no', 'whatsap_no', 'dob', 'gender', 'kyc_detail', 'business_registration_name', 'business_brand_name', 'business_full_name', 'business_phone_no', 'business_whatsap_no', 'business_email_id', 'business_logo_upload', 'type_of_business', 'business_doc_reg_no', 'business_kyc_detail', 'business_operated_park', 'business_detail', 'gst', 'bank_name', 'account_holder_name', 'account_no', 'ifsc_code', 'cancle_check', 'upload_adhar_no', 'upload_aadhar_front', 'upload_aadhar_back', 'pan_no', 'pan_upload', 'upload_registration_number', 'upload_registration_cert', 'upload_document', 'updated_time_step_1', 'updated_time_step_2', 'updated_time_step_3', 'updated_time_step_4', 'updated_time_step_5', 'final', 'updated_time_final', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['current_step'], 'default', 'value' => 1],
            [['step_5'], 'default', 'value' => 0],
            [['dob'], 'safe'],
            [['kyc_detail', 'business_detail'], 'string'],
            [['current_step', 'step_1', 'step_2', 'step_3', 'step_4', 'step_5', 'updated_time_step_1', 'updated_time_step_2', 'updated_time_step_3', 'updated_time_step_4', 'updated_time_step_5', 'final', 'updated_time_final', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'email', 'type_of_business', 'business_doc_reg_no', 'bank_name', 'account_holder_name', 'upload_registration_number'], 'string', 'max' => 100],
            [['phone_no', 'whatsap_no'], 'string', 'max' => 15],
            [['gender'], 'string', 'max' => 10],
            [['business_registration_name', 'business_brand_name', 'business_full_name', 'business_email_id'], 'string', 'max' => 150],
            [['business_phone_no', 'business_whatsap_no', 'ifsc_code', 'upload_adhar_no', 'pan_no'], 'string', 'max' => 20],
            [['business_logo_upload', 'business_kyc_detail', 'business_operated_park', 'cancle_check', 'upload_aadhar_front', 'upload_aadhar_back', 'pan_upload', 'upload_registration_cert', 'upload_document'], 'string', 'max' => 255],
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
            'business_registration_name' => 'Business Registration Name',
            'business_brand_name' => 'Business Brand Name',
            'business_full_name' => 'Business Full Name',
            'business_phone_no' => 'Business Phone No',
            'business_whatsap_no' => 'Business Whatsap No',
            'business_email_id' => 'Business Email ID',
            'business_logo_upload' => 'Business Logo Upload',
            'type_of_business' => 'Type Of Business',
            'business_doc_reg_no' => 'Business Doc Reg No',
            'business_kyc_detail' => 'Business Kyc Detail',
            'business_operated_park' => 'Business Operated Park',
            'business_detail' => 'Business Detail',
            'gst' => 'Gst',
            'bank_name' => 'Bank Name',
            'account_holder_name' => 'Account Holder Name',
            'account_no' => 'Account No',
            'ifsc_code' => 'Ifsc Code',
            'cancle_check' => 'Cancle Check',
            'upload_adhar_no' => 'Upload Adhar No',
            'upload_aadhar_front' => 'Upload Aadhar Front',
            'upload_aadhar_back' => 'Upload Aadhar Back',
            'pan_no' => 'Pan No',
            'pan_upload' => 'Pan Upload',
            'upload_registration_number' => 'Upload Registration Number',
            'upload_registration_cert' => 'Upload Registration Cert',
            'upload_document' => 'Upload Document',
            'current_step' => 'Current Step',
            'step_1' => 'Step 1',
            'step_2' => 'Step 2',
            'step_3' => 'Step 3',
            'step_4' => 'Step 4',
            'step_5' => 'Step 5',
            'updated_time_step_1' => 'Updated Time Step 1',
            'updated_time_step_2' => 'Updated Time Step 2',
            'updated_time_step_3' => 'Updated Time Step 3',
            'updated_time_step_4' => 'Updated Time Step 4',
            'updated_time_step_5' => 'Updated Time Step 5',
            'final' => 'Final',
            'updated_time_final' => 'Updated Time Final',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
