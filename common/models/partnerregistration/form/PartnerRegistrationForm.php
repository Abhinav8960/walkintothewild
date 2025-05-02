<?php

namespace common\models\partnerregistration\form;

use common\Helper\FsHelper;
use common\models\partnerregistration\PartnerRegistration;
use Yii;
use yii\base\Model;
use yii\web\JsExpression;
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
    public $logo_file_upload;
    public $legal_entity_phone;
    public $legal_entity_whatsapp;
    public $legal_entity_email;
    public $address;


    public $registration_number;
    public $registration_copy_upload;
    public $registration_copy_file_upload;

    public $pan_number;
    public $pan_upload;
    public $pan_file_upload;



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
    public $cancel_check_file_upload;



    public $owner_name;
    public $kyc_phone;
    public $kyc_whatsapp;
    public $kyc_email;
    public $kyc_pan;
    public $kyc_pan_upload;
    public $kyc_pan_file_upload;
    public $aadhar_number;
    public $aadhar_front_upload;
    public $aadhar_back_upload;
    public $aadhar_front_file_upload;
    public $aadhar_back_file_upload;

    public $current_step;
    public $form1_status = 0;
    public $form2_status = 0;
    public $form3_status = 0;
    public $form4_status = 0;
    public $form5_status = 0;
    public $is_sendforapproval;
    public $status = 0;
    public $final;
    public $updated_time_final;
    public $partner_model;

    public $action_url;
    public $action_validate_url;
    public $isNewRecord = true;

    public $skiponemptystep1 = true;
    public $skiponemptystep2 = true;
    public $skiponemptystep3 = true;
    public $skiponemptystep4 = true;
    public $skiponemptystep5 = true;

    public function __construct(PartnerRegistration $partner_model = null)
    {
        $this->partner_model = Yii::createObject([
            'class' => PartnerRegistration::className()
        ]);

        if ($partner_model !== null) {
            $this->isNewRecord = false;

            $this->partner_model = $partner_model;
            $this->id = $this->partner_model->id;
            $this->user_id = $this->partner_model->user_id;

            $this->legal_entity_name = $this->partner_model->legal_entity_name;
            $this->legal_entity_type = $this->partner_model->legal_entity_type;
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
            $this->is_sendforapproval = $this->partner_model->is_sendforapproval;
            $this->status = $this->partner_model->status;
            $this->final = $this->partner_model->final;
            $this->updated_time_final = $this->partner_model->updated_time_final;
        }

        $this->skiponemptystep1 = !$this->isNewRecord;
        $this->skiponemptystep2 = $this->form2_status == 0 ? false : true;
        $this->skiponemptystep3 = $this->form3_status == 0 ? false : true;;
        $this->skiponemptystep4 = $this->form4_status == 0 ? false : true;;
        $this->skiponemptystep5 = $this->form5_status == 0 ? false : true;;
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_STEP1 => ['legal_entity_name', 'legal_entity_type', 'brand_name', 'logo_file_upload', 'legal_entity_phone', 'legal_entity_whatsapp', 'legal_entity_email', 'address'],
            self::SCENARIO_STEP2 => ['registration_number', 'pan_number', 'registration_copy_file_upload', 'pan_file_upload'],
            self::SCENARIO_STEP3 => ['operated_park', 'about_business', 'billing_phone', 'billing_mail'],
            self::SCENARIO_STEP4 => ['bank_name', 'account_holder_name', 'account_number', 'ifsc_number', 'cancel_check_file_upload'],
            self::SCENARIO_STEP5 => ['owner_name', 'kyc_phone', 'kyc_whatsapp', 'kyc_email', 'kyc_pan', 'kyc_pan_file_upload', 'aadhar_number', 'aadhar_front_file_upload', 'aadhar_back_file_upload'],

        ];
    }

    public function rules()
    {
        return [
            [['legal_entity_name', 'legal_entity_type', 'brand_name', 'legal_entity_phone', 'legal_entity_whatsapp', 'legal_entity_email', 'address'], 'required', 'on' => self::SCENARIO_STEP1],
            // [
            //     'logo_file_upload',
            //     'required',
            //     'on' => self::SCENARIO_STEP1,
            //     'when' => function ($model) {
            //         return empty($model->logo);
            //     },
            // ],
            ['legal_entity_email', 'email', 'on' => self::SCENARIO_STEP1],
            [['logo_file_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'webp'], 'maxSize' => 1 * 1024 * 1024, 'on' => self::SCENARIO_STEP1, 'skipOnEmpty' => $this->skiponemptystep1],


            [['registration_number', 'pan_number'], 'required', 'on' => self::SCENARIO_STEP2],
            // [
            //     'registration_copy_file_upload',
            //     'required',
            //     'on' => self::SCENARIO_STEP2,
            //     'when' => function ($model) {
            //         return empty($model->registration_copy_upload);
            //     },
            //     'whenClient' => 'function (attribute, value) {
            //     return $(\'#registration_copy_upload\').val() === \'\';
            // }'
            // ],
            // [
            //     'pan_file_upload',
            //     'required',
            //     'on' => self::SCENARIO_STEP2,
            //     'when' => function ($model) {
            //         return empty($model->pan_upload);
            //     },
            //     'whenClient' => 'function (attribute, value) {
            //     return $(\'#pan_upload\').val() === \'\';
            // }'
            // ],
            [['registration_copy_file_upload', 'pan_file_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'pdf', 'doc', 'png', 'webp'], 'maxSize' => 1 * 1024 * 1024, 'on' => self::SCENARIO_STEP2, 'skipOnEmpty' => $this->skiponemptystep2],

            [['operated_park', 'about_business', 'billing_phone', 'billing_mail'], 'required', 'on' => self::SCENARIO_STEP3],
            ['billing_mail', 'email', 'on' => self::SCENARIO_STEP3],

            [['bank_name', 'account_holder_name', 'account_number', 'ifsc_number'], 'required', 'on' => self::SCENARIO_STEP4],
            // [
            //     'cancel_check_file_upload',
            //     'required',
            //     'on' => self::SCENARIO_STEP4,
            //     'when' => function ($model) {
            //         return empty($model->cancel_check_upload);
            //     },
            //     'whenClient' => 'function (attribute, value) {
            //         return $(\'#cancel_check_upload\').val() === \'\';
            //     }',
            // ],
            [['cancel_check_file_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'pdf', 'doc', 'png', 'webp'], 'maxSize' => 1 * 1024 * 1024, 'on' => self::SCENARIO_STEP4, 'skipOnEmpty' => $this->skiponemptystep4],


            [['owner_name', 'kyc_phone', 'kyc_whatsapp', 'kyc_email', 'kyc_pan', 'aadhar_number'], 'required', 'on' => self::SCENARIO_STEP5],
            ['kyc_email', 'email', 'on' => self::SCENARIO_STEP5],
            // [
            //     'kyc_pan_file_upload',
            //     'required',
            //     'on' => self::SCENARIO_STEP5,
            //     'when' => function ($model) {
            //         return empty($model->kyc_pan_upload);
            //     },
            //     'whenClient' => 'function (attribute, value) {
            //         return $(\'#kyc_pan_upload\').val() === \'\';
            //     }',
            // ],
            // [
            //     'aadhar_front_file_upload',
            //     'required',
            //     'on' => self::SCENARIO_STEP5,
            //     'when' => function ($model) {
            //         return empty($model->aadhar_front_upload);
            //     },
            //     'whenClient' => 'function (attribute, value) {
            //         return $(\'#aadhar_front_upload\').val() === \'\';
            //     }',
            // ],
            // [
            //     'aadhar_back_file_upload',
            //     'required',
            //     'on' => self::SCENARIO_STEP5,
            //     'when' => function ($model) {
            //         return empty($model->aadhar_back_upload);
            //     },
            //     'whenClient' => 'function (attribute, value) {
            //         return $(\'#aadhar_back_upload\').val() === \'\';
            //     }',
            // ],
            [['kyc_pan_file_upload', 'aadhar_front_file_upload', 'aadhar_back_file_upload'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'webp'], 'maxSize' => 1 * 1024 * 1024, 'on' => self::SCENARIO_STEP5, 'skipOnEmpty' => $this->skiponemptystep5],

            [['form1_status', 'form2_status', 'form3_status', 'form4_status', 'is_sendforapproval'], 'default', 'value' => 0],
            [['gst_id', 'user_id', 'current_step', 'form1_status', 'form2_status', 'form3_status', 'form4_status'], 'integer'],
            [['form1_status', 'form2_status', 'form3_status', 'form4_status', 'is_sendforapproval'], 'safe'],
            [['legal_entity_phone', 'legal_entity_whatsapp','billing_phone','kyc_phone', 'kyc_whatsapp'],'match', 'pattern' =>'/^\d{10}$/', 'message' => 'Contact Number should have 10 digits.'],

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
            'gst_id' => 'GST Id',
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
        $this->partner_model->is_sendforapproval = $this->is_sendforapproval;
        $this->partner_model->status = $this->status;
        $this->partner_model->final = $this->final;
        $this->partner_model->updated_time_final = $this->updated_time_final;
    }

    public function uploadFiles()
    {
        // $basePath = Yii::$app->params['datapath'] . '/Uploads';
        // if (!file_exists($basePath)) {
        //     mkdir($basePath, 0777, true);
        // }

        // $userFolder = $basePath . '/' . $this->partner_model->id;
        // if (!file_exists($userFolder)) {
        //     mkdir($userFolder, 0777, true);
        // }

        // if ($this->logo_file_upload) {
        //     $fileName = 'logo_file_upload' . '_' . time() . '.' . $this->logo_file_upload->extension;
        //     $filePath = $userFolder . '/' . $fileName;

        //     if ($this->logo_file_upload->saveAs($filePath)) {
        //         $this->logo_file_upload = $filePath;
        //         $this->partner_model->logo = $filePath;
        //     } else {
        //         Yii::error("Failed to save file: $fileName", __METHOD__);
        //     }
        // }

        if ($this->logo_file_upload) {
            $storagePath = 'operator-registration';
            $userPath = $storagePath . '/' . $this->partner_model->user_id . '/logo';

            $fileName = $this->partner_model->user_id . '_logo_' . time() . '.' . $this->logo_file_upload->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::saveUploadedFile($this->logo_file_upload, $filePath, $fileName, true)) {
                        $this->partner_model->logo = $filePath;
                        // $this->partner_model->filepath = $filePath;
                        // $this->partner_model->etag = $etag;

                        $extension = $this->logo_file_upload->extension;
                        if ($extension === 'svg') {
                            $width = 0;
                            $height = 0;
                        } else {
                            list($width, $height) = getimagesize($this->logo_file_upload->tempName);
                        }
                        // $this->partner_model->height =  $height;
                        // $this->partner_model->width = $width;
                        $this->partner_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        // if ($this->registration_copy_file_upload) {
        //     $fileName = 'registration_copy_file_upload' . '_' . time() . '.' . $this->registration_copy_file_upload->extension;
        //     $filePath = $userFolder . '/' . $fileName;

        //     if ($this->registration_copy_file_upload->saveAs($filePath)) {
        //         $this->registration_copy_file_upload = $filePath;
        //         $this->partner_model->registration_copy_upload = $filePath;
        //     } else {
        //         Yii::error("Failed to save file: $fileName", __METHOD__);
        //     }
        // }

        if ($this->registration_copy_file_upload) {
            $storagePath = 'operator-registration';
            $userPath = $storagePath . '/' . $this->partner_model->user_id . '/registrationcopy';

            $fileName = $this->partner_model->user_id . '_registrationcopy_' . time() . '.' . $this->registration_copy_file_upload->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::saveUploadedFile($this->registration_copy_file_upload, $filePath, $fileName, true)) {
                        $this->partner_model->registration_copy_upload = $filePath;
                        // $this->partner_model->filepath = $filePath;
                        // $this->partner_model->etag = $etag;

                        $extension = $this->registration_copy_file_upload->extension;
                        if ($extension === 'svg') {
                            $width = 0;
                            $height = 0;
                        } else {
                            list($width, $height) = getimagesize($this->registration_copy_file_upload->tempName);
                        }
                        // $this->partner_model->height =  $height;
                        // $this->partner_model->width = $width;
                        $this->partner_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        // if ($this->pan_file_upload) {
        //     $fileName = 'pan_file_upload' . '_' . time() . '.' . $this->pan_file_upload->extension;
        //     $filePath = $userFolder . '/' . $fileName;

        //     if ($this->pan_file_upload->saveAs($filePath)) {
        //         $this->pan_file_upload = $filePath;
        //         $this->partner_model->pan_upload = $filePath;
        //     } else {
        //         Yii::error("Failed to save file: $fileName", __METHOD__);
        //     }
        // }

        if ($this->pan_file_upload) {
            $storagePath = 'operator-registration';
            $userPath = $storagePath . '/' . $this->partner_model->user_id . '/pancard';

            $fileName = $this->partner_model->user_id . '_pancard_' . time() . '.' . $this->pan_file_upload->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::saveUploadedFile($this->pan_file_upload, $filePath, $fileName, true)) {
                        $this->partner_model->pan_upload = $filePath;
                        // $this->partner_model->filepath = $filePath;
                        // // $this->partner_model->etag = $etag;

                        $extension = $this->pan_file_upload->extension;
                        if ($extension === 'svg') {
                            $width = 0;
                            $height = 0;
                        } else {
                            list($width, $height) = getimagesize($this->pan_file_upload->tempName);
                        }
                        // $this->partner_model->height =  $height;
                        // $this->partner_model->width = $width;
                        $this->partner_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        // if ($this->cancel_check_file_upload) {
        //     $fileName = 'cancel_check_file_upload' . '_' . time() . '.' . $this->cancel_check_file_upload->extension;
        //     $filePath = $userFolder . '/' . $fileName;

        //     if ($this->cancel_check_file_upload->saveAs($filePath)) {
        //         $this->cancel_check_file_upload = $filePath;
        //         $this->partner_model->cancel_check_upload = $filePath;
        //     } else {
        //         Yii::error("Failed to save file: $fileName", __METHOD__);
        //     }
        // }

        if ($this->cancel_check_file_upload) {
            $storagePath = 'operator-registration';
            $userPath = $storagePath . '/' . $this->partner_model->user_id . '/cancelcheck';

            $fileName = $this->partner_model->user_id . '_cancelcheck_' . time() . '.' . $this->cancel_check_file_upload->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::saveUploadedFile($this->cancel_check_file_upload, $filePath, $fileName, true)) {
                        $this->partner_model->cancel_check_upload = $filePath;
                        // $this->partner_model->filepath = $filePath;
                        // $this->partner_model->etag = $etag;

                        $extension = $this->cancel_check_file_upload->extension;
                        if ($extension === 'svg') {
                            $width = 0;
                            $height = 0;
                        } else {
                            list($width, $height) = getimagesize($this->cancel_check_file_upload->tempName);
                        }
                        // $this->partner_model->height =  $height;
                        // $this->partner_model->width = $width;
                        $this->partner_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }
        // if ($this->kyc_pan_file_upload) {
        //     $fileName = 'kyc_pan_file_upload' . '_' . time() . '.' . $this->kyc_pan_file_upload->extension;
        //     $filePath = $userFolder . '/' . $fileName;

        //     if ($this->kyc_pan_file_upload->saveAs($filePath)) {
        //         $this->kyc_pan_file_upload = $filePath;
        //         $this->partner_model->kyc_pan_upload = $filePath;
        //     } else {
        //         Yii::error("Failed to save file: $fileName", __METHOD__);
        //     }
        // }

        if ($this->kyc_pan_file_upload) {
            $storagePath = 'operator-registration';
            $userPath = $storagePath . '/' . $this->partner_model->user_id . '/kycpan';

            $fileName = $this->partner_model->user_id . '_kycpan_' . time() . '.' . $this->kyc_pan_file_upload->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::saveUploadedFile($this->kyc_pan_file_upload, $filePath, $fileName, true)) {
                        $this->partner_model->kyc_pan_upload = $filePath;
                        // $this->partner_model->filepath = $filePath;
                        // $this->partner_model->etag = $etag;

                        $extension = $this->kyc_pan_file_upload->extension;
                        if ($extension === 'svg') {
                            $width = 0;
                            $height = 0;
                        } else {
                            list($width, $height) = getimagesize($this->kyc_pan_file_upload->tempName);
                        }
                        // $this->partner_model->height =  $height;
                        // $this->partner_model->width = $width;
                        $this->partner_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        // if ($this->aadhar_front_file_upload) {
        //     $fileName = 'aadhar_front_file_upload' . '_' . time() . '.' . $this->aadhar_front_file_upload->extension;
        //     $filePath = $userFolder . '/' . $fileName;

        //     if ($this->aadhar_front_file_upload->saveAs($filePath)) {
        //         $this->aadhar_front_file_upload = $filePath;
        //         $this->partner_model->aadhar_front_upload = $filePath;
        //     } else {
        //         Yii::error("Failed to save file: $fileName", __METHOD__);
        //     }
        // }

        if ($this->aadhar_front_file_upload) {
            $storagePath = 'operator-registration';
            $userPath = $storagePath . '/' . $this->partner_model->user_id . '/aadharfront';

            $fileName = $this->partner_model->user_id . '_aadharfront_' . time() . '.' . $this->aadhar_front_file_upload->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                // try {
                if ($etag =  FsHelper::saveUploadedFile($this->aadhar_front_file_upload, $filePath, $fileName, true)) {
                    $this->partner_model->aadhar_front_upload = $filePath;
                    // $this->aadhar_front_file_upload = $filePath;
                    // $this->partner_model->etag = $etag;

                    $extension = $this->aadhar_front_file_upload->extension;
                    if ($extension === 'svg') {
                        $width = 0;
                        $height = 0;
                    } else {
                        list($width, $height) = getimagesize($this->aadhar_front_file_upload->tempName);
                    }
                    // $this->partner_model->height =  $height;
                    // $this->partner_model->width = $width;
                    $this->partner_model->save(false);
                }
                // } catch (\Exception $e) {
                //     throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                // }
            }
        }

        // if ($this->aadhar_back_file_upload) {
        //     $fileName = 'aadhar_back_file_upload' . '_' . time() . '.' . $this->aadhar_back_file_upload->extension;
        //     $filePath = $userFolder . '/' . $fileName;

        //     if ($this->aadhar_back_file_upload->saveAs($filePath)) {
        //         $this->aadhar_back_file_upload = $filePath;
        //         $this->partner_model->aadhar_back_upload = $filePath;
        //     } else {
        //         Yii::error("Failed to save file: $fileName", __METHOD__);
        //     }
        // }

        // if (!$this->partner_model->save(false)) {
        //     Yii::error("Failed to save operator model with uploaded file paths.", __METHOD__);
        // }

        if ($this->aadhar_back_file_upload) {
            $storagePath = 'operator-registration';
            $userPath = $storagePath . '/' . $this->partner_model->user_id . '/aadharback';

            $fileName = $this->partner_model->user_id . '_aadharback_' . time() . '.' . $this->aadhar_back_file_upload->extension;
            $filePath = $userPath . '/' . $fileName;

            // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
            if ($fileName) {
                // try {
                if ($etag =  FsHelper::saveUploadedFile($this->aadhar_back_file_upload, $filePath, $fileName, true)) {
                    $this->partner_model->aadhar_back_upload = $filePath;
                    // $this->partner_model->filepath = $filePath;
                    // $this->partner_model->etag = $etag;

                    $extension = $this->aadhar_back_file_upload->extension;
                    if ($extension === 'svg') {
                        $width = 0;
                        $height = 0;
                    } else {
                        list($width, $height) = getimagesize($this->aadhar_back_file_upload->tempName);
                    }
                    // $this->partner_model->height =  $height;
                    // $this->partner_model->width = $width;
                    $this->partner_model->save(false);
                }
                // } catch (\Exception $e) {
                //     throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                // }
            }
        }
    }
}


// if ($this->file) {
//     $storagePath = 'watchpost';
//     $userPath = $storagePath . '/' . $this->user_photo_model->user_id . '/media';

//     $fileName = $this->user_photo_model->user_id . '_media_' . time() . '.' . $this->file->extension;
//     $filePath = $userPath . '/' . $fileName;

//     // $fileName = FsHelper::UserPostUploadFile($this->file, $filePath, $fileName, $this->caption, $this->user_id);
//     if ($fileName) {
//         try {
//             if ($etag =  FsHelper::saveUploadedFile($this->file, $filePath, $fileName, true)) {
//                 $this->user_photo_model->file = $fileName;
//                 $this->user_photo_model->filepath = $filePath;
//                 $this->user_photo_model->etag = $etag;

//                 $extension = $this->file->extension;
//                 if ($extension === 'svg') {
//                     $width = 0;
//                     $height = 0;
//                 } else {
//                     list($width, $height) = getimagesize($this->file->tempName);
//                 }
//                 $this->user_photo_model->height =  $height;
//                 $this->user_photo_model->width = $width;
//                 $this->user_photo_model->save(false);
//             }
//         } catch (\Exception $e) {
//             throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
//         }
//     }
// }