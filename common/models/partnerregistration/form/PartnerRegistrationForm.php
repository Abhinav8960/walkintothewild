<?php

namespace common\models\partnerregistration\form;

use common\models\partnerregistration\PartnerRegistration;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class PartnerRegistrationForm extends Model
{

    const SCENARIO_STEP1 = 'step1';
    const SCENARIO_STEP2 = 'step2';
    const SCENARIO_STEP3 = 'step3';
    const SCENARIO_STEP4 = 'step4';
    const SCENARIO_STEP5 = 'step5';


    public $id;
    public $user_id;

    public $legal_entity_name;
    public $legal_entity_type;
    public $brand_name;
    public $logo;
    public $legal_entity_phone;
    public $legal_entity_whatsapp;
    public $legal_entity_email;
    public $address;


    public $registration_number;
    public $registration_copy_upload;
    public $pan_number;
    public $pan_upload;

    public $operated_park;
    public $about_business;
    public $gst_id;
    // public $state;
    // public $gst_number;
    // public $gst_upload;
    public $billing_phone;
    public $billing_mail;


    public $bank_name;
    public $account_holder_name;
    public $account_number;
    public $ifsc_number;
    public $cancel_check_upload;


    public $owner_name;
    public $kyc_phone;
    public $kyc_whatsapp;
    public $kyc_email;
    public $kyc_pan;
    public $kyc_pan_upload;
    public $aadhar_number;
    public $aadhar_front_upload;
    public $aadhar_back_upload;


    public $current_step;
    public $form1_status;
    public $form2_status;
    public $form3_status;
    public $form4_status;
    public $form5_status;
    public $partner_model;

    public function __construct(PartnerRegistration $partner_model = null)
    {
        $this->partner_model = Yii::createObject([
            'class' => PartnerRegistration::className()
        ]);

        if ($partner_model !== null) {
            $this->partner_model = $partner_model;
            $this->id = $this->partner_model->id;
            $this->user_id = $this->partner_model->user_id;

            $this->legal_entity_name = $this->partner_model->legal_entity_name;
            $this->brand_name = $this->partner_model->brand_name;
            $this->logo = $this->partner_model->logo;
            $this->legal_entity_phone = $this->partner_model->legal_entity_phone;
            $this->legal_entity_whatsapp = $this->partner_model->legal_entity_whatsapp;
            $this->legal_entity_email = $this->partner_model->legal_entity_email;
            $this->address = $this->partner_model->address;

            $this->registration_number = $this->partner_model->registration_number;
            $this->registration_copy_upload = $this->partner_model->registration_copy_upload;
            $this->pan_number = $this->partner_model->pan_number;
            $this->pan_upload = $this->partner_model->pan_upload;

            $this->operated_park = $this->partner_model->operated_park;
            $this->about_business = $this->partner_model->about_business;
            $this->gst_id = $this->partner_model->gst_id;
            // $this->state = $this->partner_model->state;
            // $this->gst_number = $this->partner_model->gst_number;
            // $this->gst_upload = $this->partner_model->gst_upload;
            $this->billing_phone = $this->partner_model->billing_phone;
            $this->billing_mail = $this->partner_model->billing_mail;

            $this->bank_name = $this->partner_model->bank_name;
            $this->account_holder_name = $this->partner_model->account_holder_name;
            $this->account_number = $this->partner_model->account_number;
            $this->ifsc_number = $this->partner_model->ifsc_number;
            $this->cancel_check_upload = $this->partner_model->cancel_check_upload;
            
            $this->owner_name = $this->partner_model->owner_name;
            $this->kyc_phone = $this->partner_model->kyc_phone;
            $this->kyc_whatsapp = $this->partner_model->kyc_whatsapp;
            $this->kyc_email = $this->partner_model->kyc_email;
            $this->kyc_pan = $this->partner_model->kyc_pan;
            $this->kyc_pan_upload = $this->partner_model->kyc_pan_upload;
            $this->aadhar_number = $this->partner_model->aadhar_number;
            $this->aadhar_front_upload = $this->partner_model->aadhar_front_upload;
            $this->aadhar_back_upload = $this->partner_model->aadhar_back_upload;

            $this->current_step = $this->partner_model->current_step;
            $this->form1_status = $this->partner_model->form1_status;
            $this->form2_status = $this->partner_model->form2_status;
            $this->form3_status = $this->partner_model->form3_status;
            $this->form4_status = $this->partner_model->form4_status;
            $this->form5_status = $this->partner_model->form5_status;
        }
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_STEP1 => ['legal_entity_name', 'legal_entity_type', 'brand_name', 'logo', 'legal_entity_phone', 'legal_entity_whatsapp', 'legal_entity_email', 'address'],
            self::SCENARIO_STEP2 => ['registration_number', 'registration_copy_upload', 'pan_number', 'pan_upload'],
            // self::SCENARIO_STEP3 => ['operated_park', 'about_business', 'state', 'gst_number', 'gst_upload', 'billing_phone', 'billing_mail'],
            self::SCENARIO_STEP3 => ['operated_park', 'about_business','billing_phone', 'billing_mail'],
            self::SCENARIO_STEP4 => ['bank_name','account_holder_name','account_number','ifsc_number','cancel_check_upload'],
            self::SCENARIO_STEP5 => ['owner_name','kyc_phone','kyc_whatsapp','kyc_email','kyc_pan','kyc_pan_upload','aadhar_number','aadhar_front_upload','aadhar_back_upload'],
        ];
    }

    public function rules()
    {
        return [
            [['legal_entity_name', 'legal_entity_type', 'brand_name', 'logo', 'legal_entity_phone', 'legal_entity_whatsapp', 'legal_entity_email', 'address'], 'required', 'on' => self::SCENARIO_STEP1],
            ['legal_entity_email', 'email', 'on' => self::SCENARIO_STEP1],
            [['logo'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'webp'], 'maxSize' => 5 * 1024 * 1024, 'on' => self::SCENARIO_STEP1],

            [['registration_number', 'registration_copy_upload', 'pan_number', 'pan_upload'], 'required', 'on' => self::SCENARIO_STEP2],
            [['registration_copy_upload', 'pan_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'pdf', 'doc', 'png', 'webp'], 'maxSize' => 5 * 1024 * 1024, 'on' => self::SCENARIO_STEP2],

            [['operated_park', 'about_business','billing_phone', 'billing_mail'], 'required', 'on' => self::SCENARIO_STEP3],
            ['billing_mail', 'email', 'on' => self::SCENARIO_STEP3],
            // [['gst_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'pdf', 'doc', 'png', 'webp'], 'maxSize' => 5 * 1024 * 1024, 'on' => self::SCENARIO_STEP3],


            [['bank_name','account_holder_name','account_number','ifsc_number','cancel_check_upload'], 'required', 'on' => self::SCENARIO_STEP4],
            [['cancel_check_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'pdf', 'doc', 'png', 'webp'], 'maxSize' => 5 * 1024 * 1024, 'on' => self::SCENARIO_STEP4],


            [['owner_name','kyc_phone','kyc_whatsapp','kyc_whatsapp','kyc_email','kyc_pan','kyc_pan_upload','aadhar_number','aadhar_front_upload','aadhar_back_upload'], 'required', 'on' => self::SCENARIO_STEP5],
            ['kyc_email', 'email', 'on' => self::SCENARIO_STEP5],
            [['kyc_pan_upload','aadhar_front_upload','aadhar_back_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'webp'], 'maxSize' => 5 * 1024 * 1024, 'on' => self::SCENARIO_STEP5],

            [['form1_status', 'form2_status', 'form3_status', 'form4_status'], 'default', 'value' => 0],
            [['gst_id','user_id', 'current_step', 'form1_status', 'form2_status', 'form3_status', 'form4_status'], 'integer'],
            [['form1_status', 'form2_status', 'form3_status', 'form4_status'], 'safe'],

        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',

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
            'gst_id'=>'GST Id',
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
              'kyc_phone' => 'Phone Number',
              'kyc_whatsapp' => 'Whatsapp Number',
              'kyc_email' => 'Email',
              'kyc_pan' => 'PAN Number',
              'kyc_pan_upload' => 'Pan Upload',
              'aadhar_number' => 'Aadhar',
              'aadhar_front_upload' => 'Aadhar Front Upload',
              'aadhar_back_upload' => 'Aadhar Back Upload',
        ];
    }

    public function initializeForm()
    {
        $this->partner_model->user_id = $this->user_id;

        $this->partner_model->legal_entity_type = $this->legal_entity_type;
        $this->partner_model->legal_entity_name = $this->legal_entity_name;
        $this->partner_model->brand_name = $this->brand_name;
        $this->partner_model->logo = $this->logo;
        $this->partner_model->legal_entity_phone = $this->legal_entity_phone;
        $this->partner_model->legal_entity_whatsapp = $this->legal_entity_whatsapp;
        $this->partner_model->legal_entity_email = $this->legal_entity_email;
        $this->partner_model->address = $this->address;

        $this->partner_model->registration_number = $this->registration_number;
        $this->partner_model->registration_copy_upload = $this->registration_copy_upload;
        $this->partner_model->pan_number = $this->pan_number;
        $this->partner_model->pan_upload = $this->pan_upload;

        $this->partner_model->operated_park = $this->operated_park;
        $this->partner_model->about_business = $this->about_business;
        $this->partner_model->gst_id = $this->gst_id;
        // $this->partner_model->state = $this->state;
        // $this->partner_model->gst_number = $this->gst_number;
        $this->partner_model->billing_phone = $this->billing_phone;
        $this->partner_model->billing_mail = $this->billing_mail;
        // $this->partner_model->gst_upload = $this->gst_upload;

        $this->partner_model->bank_name = $this->bank_name;
        $this->partner_model->account_holder_name = $this->account_holder_name;
        $this->partner_model->account_number = $this->account_number;
        $this->partner_model->ifsc_number = $this->ifsc_number;
        $this->partner_model->cancel_check_upload = $this->cancel_check_upload;

        $this->partner_model->owner_name = $this->owner_name;
        $this->partner_model->kyc_phone = $this->kyc_phone;
        $this->partner_model->kyc_whatsapp = $this->kyc_whatsapp;
        $this->partner_model->kyc_email = $this->kyc_email;
        $this->partner_model->kyc_pan = $this->kyc_pan;
        $this->partner_model->kyc_pan_upload = $this->kyc_pan_upload;
        $this->partner_model->aadhar_number = $this->aadhar_number;
        $this->partner_model->aadhar_front_upload = $this->aadhar_front_upload;
        $this->partner_model->aadhar_back_upload = $this->aadhar_back_upload;

        $this->partner_model->current_step = $this->current_step;
        $this->partner_model->form1_status = $this->form1_status;
        $this->partner_model->form2_status = $this->form2_status;
        $this->partner_model->form3_status = $this->form3_status;
        $this->partner_model->form4_status = $this->form4_status;
        $this->partner_model->form5_status = $this->form5_status;
    }


    public function uploadFiles()
    {
        $basePath = Yii::$app->params['datapath'] . '/Uploads';
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $userFolder = $basePath . '/' . $this->partner_model->id;
        if (!file_exists($userFolder)) {
            mkdir($userFolder, 0777, true);
        }

        $fileFields = [
            'logo',
            'registration_copy_upload',
            'pan_upload',
            'cancel_check_upload',
            'kyc_pan_upload',
            'aadhar_front_upload',
            'aadhar_back_upload',
        ];

        foreach ($fileFields as $field) {
            $file = UploadedFile::getInstance($this, $field);

            if ($file) {
                $fileName = $field . '_' . time() . '.' . $file->extension;
                $filePath = $userFolder . '/' . $fileName;

                if ($file->saveAs($filePath)) {
                    $this->$field = $filePath;
                    $this->partner_model->$field = $filePath;
                } else {
                    Yii::error("Failed to save file: $fileName", __METHOD__);
                }
            }
        }

        if (!$this->partner_model->save(false)) {
            Yii::error("Failed to save operator model with uploaded file paths.", __METHOD__);
        }
    }
}
