<?php

namespace common\models\partnerregistration;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "partner_registration".
 *
 * @property int $id 
 * @property int $user_id
 * @property string|null $legal_entity_type
 * @property string|null $legal_entity_name
 * @property string|null $brand_name
 * @property string|null $logo
 * @property string|null $legal_entity_phone
 * @property string|null $legal_entity_whatsapp
 * @property string|null $legal_entity_email
 * @property string|null $address

 * @property string|null $registration_number
 * @property string|null $registration_copy_upload
 * @property string|null $pan_number
 * @property string|null $pan_upload

 * @property string|null $operated_park
 * @property string|null $about_business
 * @property string|null $state
 * @property string|null $gst_number
 * @property string|null $gst_upload
 * @property string|null $billing_mail
 * @property string|null $billing_phone

 * @property string|null $bank_name
 * @property string|null $account_holder_name
 * @property string|null $account_number
 * @property string|null $ifsc_number
 * @property string|null $cancel_check_upload

 * @property string|null $owner_name
 * @property string|null $kyc_phone
 * @property string|null $kyc_whatsapp
 * @property string|null $kyc_email
 * @property string|null $kyc_pan
 * @property string|null $kyc_pan_upload
 * @property string|null $aadhar_number
 * @property string|null $aadhar_front_upload
 * @property string|null $aadhar_back_upload

 * @property int $form1_status 0 => empty,1=filled,2=>approved,3=>return
 * @property int $form2_status 0 => empty,1=filled,2=>approved,3=>return
 * @property int $form3_status 0 => empty,1=filled,2=>approved,3=>return
 * @property int $form4_status 0 => empty,1=filled,2=>approved,3=>return
 * @property int $form4_status 0 => empty,1=filled,2=>approved,3=>return

 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class PartnerRegistration extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_registration';
    }

    const PROP_WRITER = 1;
    const PVT_LTD = 2;
    const LLP = 3;




    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'value' => function () {
                    return Yii::$app->user->id ?? '';
                },
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
            [[
                'legal_entity_name',
                'legal_entity_type',
                'brand_name',
                'logo',
                'legal_entity_phone',
                'legal_entity_whatsapp',
                'legal_entity_email',
                'address',
                'registration_number',
                'registration_copy_upload',
                'pan_number',
                'pan_upload',
                'operated_park',
                'about_business',
                // 'state',
                // 'gst_number',
                // 'gst_upload',
                'gst_id',
                'billing_mail',
                'billing_phone',
                'bank_name',
                'account_holder_name',
                'account_number',
                'ifsc_number',
                'cancel_check_upload',
                'owner_name',
                'kyc_phone',
                'kyc_whatsapp',
                'kyc_email',
                'kyc_pan',
                'kyc_pan_upload',
                'aadhar_number',
                'aadhar_front_upload',
                'aadhar_back_upload',
            ], 'default', 'value' => null],


            [['form1_status', 'form2_status', 'form3_status', 'form4_status', 'form5_status'], 'default', 'value' => 0],
            [['gst_id','current_step', 'user_id', 'form1_status', 'form2_status', 'form3_status', 'form4_status', 'form5_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],

            [[
                'legal_entity_name',
                'brand_name',
                'logo',
                'legal_entity_email',
                'address',
                'registration_copy_upload',
                'pan_number',
                'pan_upload',
                'operated_park',
                'about_business',
                // 'gst_upload',
                'billing_mail',
                'bank_name',
                'account_holder_name',
                'ifsc_number',
                'cancel_check_upload',
                'owner_name',
                'kyc_email',
                'kyc_pan',
                'kyc_pan_upload',
                'aadhar_front_upload',
                'aadhar_back_upload',
            ], 'string', 'max' => 255],

            [['legal_entity_type', 'legal_entity_phone', 'legal_entity_whatsapp', 'registration_number','billing_phone', 'account_number', 'kyc_phone', 'kyc_whatsapp', 'aadhar_number'], 'integer'],


            [['current_step'], 'default', 'value' => 1],
            [['form1_status', 'form2_status', 'form3_status', 'form4_status', 'form5_status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User Id',

            //Legal Entity
            'legal_entity_name' => 'Legal Entity Name',
            'legal_entity_type' => 'Legal Entity Type',
            'brand_name' => 'Brand Name',
            'logo' => 'Logo',
            'legal_entity_phone' => 'Legal Entity Phone',
            'legal_entity_whatsapp' => 'Legal Entity Whatsapp',
            'legal_entity_email' => 'Legal Entity Email',
            'address' => 'Address',

            //Registration Proof
            'registration_number' => 'Registration Number',
            'registration_copy_upload' => 'Registration Copy Upload',
            'pan_number' => 'Pan Number',
            'pan_upload' => 'Pan Upload',

            //Business Details
            'operated_park' => 'Operated Park',
            'about_business' => 'About Business',
            'gst_id'=> 'GST ID',
            // 'gst_upload' => 'GST Upload',
            // 'state' => 'State',
            // 'gst_number' => 'GST Number',
            'billing_phone' => 'Billing Phone',
            'billing_mail' => 'Billing Mail',

            //Bank Details
            'bank_name' => 'Bank Name',
            'account_holder_name' => 'Account Holder Name',
            'account_number' => 'Account Number',
            'ifsc_number' => 'IFSC',
            'cancel_check_upload' => 'Cancel Check Upload',

            //User KYC 
            'owner_name' => 'Owner Name',
            'kyc_phone' => 'KYC Phone Number',
            'kyc_whatsapp' => 'KYC Whatsapp Number',
            'kyc_email' => 'KYC Email',
            'kyc_pan' => 'KYC PAN Number',
            'kyc_pan_upload' => 'KYC Pan Upload',
            'aadhar_number' => 'Aadhar',
            'aadhar_front_upload' => 'Aadhar Front Upload',
            'aadhar_back_upload' => 'Aadhar Back Upload',

            'current_step' => 'Current Step',
            'form1_status' => 'Form1 Status',
            'form2_status' => 'Form2 Status',
            'form3_status' => 'Form3 Status',
            'form4_status' => 'Form4 Status',
            'form5_status' => 'Form5 Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function entitytypeoption()
    {
        return [self::PROP_WRITER => "Prop Writer", self::PVT_LTD => "Pvt. Ltd", self::LLP => "LLP"];
    }
}
