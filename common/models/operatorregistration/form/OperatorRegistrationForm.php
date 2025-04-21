<?php

namespace common\models\operatorregistration\form;


use Yii;
use yii\base\Model;
use common\models\operatorregistration\OperatorRegistration;
use yii\web\UploadedFile;


class OperatorRegistrationForm extends Model
{
    public $operator_model;
    public $name;
    public $email;
    public $phone_no;
    public $whatsap_no;
    public $dob;
    public $gender;
    public $kyc_detail;
    public $business_registration_name;
    public $business_brand_name;
    public $business_full_name;
    public $business_phone_no;
    public $business_whatsap_no;
    public $business_email_id;
    public $type_of_business;
    public $business_doc_reg_no;
    public $business_operated_park;
    public $business_detail;
    public $gst;
    public $bank_name;
    public $account_holder_name;
    public $account_no;
    public $ifsc_code;
    public $upload_adhar_no;
    public $pan_no;
    public $upload_registration_number;

    public $business_logo_upload;
    public $business_kyc_detail;
    public $cancle_check;
    public $upload_aadhar_front;
    public $upload_aadhar_back;
    public $pan_upload;
    public $upload_registration_cert;
    public $upload_document;

    // public function __construct(OperatorRegistration $operator_model = null)
    // {
    //     $this->operator_model = Yii::createObject([
    //         'class' => OperatorRegistration::className()
    //     ]);

    //     if ($operator_model !== null) {
    //         $this->operator_model = $operator_model;

    //         foreach ($this->operator_model->attributes as $attr => $val) {
    //             if (property_exists($this, $attr)) {
    //                 $this->$attr = $val;
    //             }
    //         }
    //     }

    //     parent::__construct();
    // }


    public function __construct(OperatorRegistration $operator_model = null)
    {
        $this->operator_model = Yii::createObject([
            'class' => OperatorRegistration::className()
        ]);

        if ($operator_model !== null) {
            $this->operator_model = $operator_model;
            // $this->id = $this->operator_model->id;
            $this->name = $this->operator_model->name;
            $this->email = $this->operator_model->email;
            $this->phone_no = $this->operator_model->phone_no;
            $this->whatsap_no = $this->operator_model->whatsap_no;
            $this->dob = $this->operator_model->dob;
            $this->gender = $this->operator_model->gender;
            $this->kyc_detail = $this->operator_model->kyc_detail;
            $this->business_registration_name = $this->operator_model->business_registration_name;
            $this->business_brand_name = $this->operator_model->business_brand_name;
            $this->business_full_name = $this->operator_model->business_full_name;
            $this->business_phone_no = $this->operator_model->business_phone_no;
            $this->business_whatsap_no = $this->operator_model->business_whatsap_no;
            $this->business_email_id = $this->operator_model->business_email_id;
            $this->business_logo_upload = $this->operator_model->business_logo_upload;
            $this->type_of_business = $this->operator_model->type_of_business;
            $this->business_doc_reg_no = $this->operator_model->business_doc_reg_no;
            $this->business_kyc_detail = $this->operator_model->business_kyc_detail;
            $this->business_operated_park = $this->operator_model->business_operated_park;
            $this->business_detail = $this->operator_model->business_detail;
            $this->gst = $this->operator_model->gst;
            $this->bank_name = $this->operator_model->bank_name;
            $this->account_holder_name = $this->operator_model->account_holder_name;
            $this->account_no = $this->operator_model->account_no;
            $this->ifsc_code = $this->operator_model->ifsc_code;
            $this->cancle_check = $this->operator_model->cancle_check;
            $this->upload_adhar_no = $this->operator_model->upload_adhar_no;
            $this->upload_aadhar_front = $this->operator_model->upload_aadhar_front;
            $this->upload_aadhar_back = $this->operator_model->upload_aadhar_back;
            $this->pan_no = $this->operator_model->pan_no;
            $this->pan_upload = $this->operator_model->pan_upload;
            $this->upload_registration_number = $this->operator_model->upload_registration_number;
            $this->upload_registration_cert = $this->operator_model->upload_registration_cert;
            $this->upload_document = $this->operator_model->upload_document;
        }
    }


    public function rules()
    {
        return [
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
            ], 'required'],

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

            [['dob'], 'safe'],

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

    // public function attributeLabels()
    // {
    //     return $this->operator_model->attributeLabels();
    // }

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
            'upload_document' => 'Supporting Document',
        ];
    }

    // public function attributes()
    // {
    //     return [
    //         'name',
    //         'email',
    //         'phone_no',
    //         'whatsap_no',
    //         'dob',
    //         'gender',
    //         'kyc_detail',
    //         'business_registration_name',
    //         'business_brand_name',
    //         'business_full_name',
    //         'business_phone_no',
    //         'business_whatsap_no',
    //         'business_email_id',
    //         'type_of_business',
    //         'business_doc_reg_no',
    //         'business_operated_park',
    //         'business_detail',
    //         'gst',
    //         'bank_name',
    //         'account_holder_name',
    //         'account_no',
    //         'ifsc_code',
    //         'upload_adhar_no',
    //         'pan_no',
    //         'upload_registration_number',

    //         'business_logo_upload',
    //         'business_kyc_detail',
    //         'cancle_check',
    //         'upload_aadhar_front',
    //         'upload_aadhar_back',
    //         'pan_upload',
    //         'upload_registration_cert',
    //         'upload_document',
    //     ];
    // }

    // public function initializeForm()
    // {
    //     foreach ($this->attributes() as $attr) {
    //         if (property_exists($this->operator_model, $attr)) {
    //             $this->operator_model->$attr = $this->$attr;
    //         }
    //     }
    // }

    public function initializeForm()
    {
        // $this->operator_model->id = $this->id;
        $this->operator_model->name = $this->name;
        $this->operator_model->email = $this->email;
        $this->operator_model->phone_no = $this->phone_no;
        $this->operator_model->whatsap_no = $this->whatsap_no;
        $this->operator_model->dob = $this->dob;
        $this->operator_model->gender = $this->gender;
        $this->operator_model->kyc_detail = $this->kyc_detail;
        $this->operator_model->business_registration_name = $this->business_registration_name;
        $this->operator_model->business_brand_name = $this->business_brand_name;
        $this->operator_model->business_full_name = $this->business_full_name;
        $this->operator_model->business_phone_no = $this->business_phone_no;
        $this->operator_model->business_whatsap_no = $this->business_whatsap_no;
        $this->operator_model->business_email_id = $this->business_email_id;
        $this->operator_model->business_logo_upload = $this->business_logo_upload;
        $this->operator_model->type_of_business = $this->type_of_business;
        $this->operator_model->business_doc_reg_no = $this->business_doc_reg_no;
        $this->operator_model->business_kyc_detail = $this->business_kyc_detail;
        $this->operator_model->business_operated_park = $this->business_operated_park;
        $this->operator_model->business_detail = $this->business_detail;
        $this->operator_model->gst = $this->gst;
        $this->operator_model->bank_name = $this->bank_name;
        $this->operator_model->account_holder_name = $this->account_holder_name;
        $this->operator_model->account_no = $this->account_no;
        $this->operator_model->ifsc_code = $this->ifsc_code;
        $this->operator_model->cancle_check = $this->cancle_check;
        $this->operator_model->upload_adhar_no = $this->upload_adhar_no;
        $this->operator_model->upload_aadhar_front = $this->upload_aadhar_front;
        $this->operator_model->upload_aadhar_back = $this->upload_aadhar_back;
        $this->operator_model->pan_no = $this->pan_no;
        $this->operator_model->pan_upload = $this->pan_upload;
        $this->operator_model->upload_registration_number = $this->upload_registration_number;
        $this->operator_model->upload_registration_cert = $this->upload_registration_cert;
        $this->operator_model->upload_document = $this->upload_document;
    }



    // public function uploadFiles()
    // {
    //     $basePath = Yii::$app->params['datapath'] . '/Uploads';
    //     if (!file_exists($basePath)) {
    //         mkdir($basePath, 0777, true);
    //     }

    //     $userFolder = $basePath . '/' . $this->id;
    //     if (!file_exists($userFolder)) {
    //         mkdir($userFolder, 0777, true);
    //     }

    //     // Loop through file fields and upload
    //     foreach (
    //         [
    //             'business_logo_upload',
    //             'business_kyc_detail',
    //             'cancle_check',
    //             'upload_aadhar_front',
    //             'upload_aadhar_back',
    //             'pan_upload',
    //             'upload_registration_cert',
    //             'upload_document'
    //         ] as $field
    //     ) {
    //         $file = UploadedFile::getInstance($this, $field);
    //         if ($file) {
    //             $fileName = $field . '_' . time() . '.' . $file->extension;
    //             $filePath = $userFolder . '/' . $fileName;

    //             $file->saveAs($filePath);

    //             $this->$field = $filePath;

    //             $this->operator_model->$field = $filePath; 
    //         }
    //     }

    //     if (!$this->operator_model->save()) {
    //         Yii::error("Failed to save operator model with uploaded files.");
    //     }
    // }


    public function uploadFiles()
    {
        $basePath = Yii::$app->params['datapath'] . '/Uploads';
        if (!file_exists($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $userFolder = $basePath . '/' . $this->operator_model->id;
        if (!file_exists($userFolder)) {
            mkdir($userFolder, 0777, true);
        }

        $fileFields = [
            'business_logo_upload',
            'business_kyc_detail',
            'cancle_check',
            'upload_aadhar_front',
            'upload_aadhar_back',
            'pan_upload',
            'upload_registration_cert',
            'upload_document'
        ];

        foreach ($fileFields as $field) {
            $file = UploadedFile::getInstance($this, $field);

            if ($file) {
                $fileName = $field . '_' . time() . '.' . $file->extension;
                $filePath = $userFolder . '/' . $fileName;

                if ($file->saveAs($filePath)) {
                    $this->$field = $filePath;
                    $this->operator_model->$field = $filePath;
                } else {
                    Yii::error("Failed to save file: $fileName", __METHOD__);
                }
            }
        }

        if (!$this->operator_model->save(false)) {
            Yii::error("Failed to save operator model with uploaded file paths.", __METHOD__);
        }
    }
}
