<?php

namespace common\models\operator\form;

use Yii;
use yii\base\Model;
use common\Helper\FsHelper;
use common\models\operator\SafariOperator;
use common\models\partnerregistration\PartnerRegistration;

class SafariOperatorUpdateForm extends model
{

    public $safari_operator_update_model;

    public $operator_name;
    public $business_name;
    public $address;
    public $logo_file;
    public $register_comapany_name;

    public $legal_entity_type;
    // public $legal_entity_phone;
    public $legal_entity_whatsapp;
    public $legal_entity_email;

    public $registration_number;
    public $pan_number;
    public $registration_copy_upload;
    public $pan_upload;

    public $about_business;
    public $billing_phone;

    public $bank_name;
    public $account_holder_name;
    public $account_number;
    public $ifsc_number;
    public $cancel_check_upload;

    public $owner_name;
    public $kyc_whatsapp;
    public $kyc_email;
    public $kyc_pan;
    public $aadhar_number;
    public $kyc_pan_upload;
    public $aadhar_front_upload;
    public $aadhar_back_upload;

    public $created_at;

    public function __construct(SafariOperator $safari_operator_update_model)
    {

        $this->safari_operator_update_model = Yii::createObject([
            'class' => SafariOperator::class
        ]);

        if ($safari_operator_update_model  != '') {
            $this->safari_operator_update_model = $safari_operator_update_model;

            $this->operator_name = $this->safari_operator_update_model->operator_name;
            $this->business_name = $this->safari_operator_update_model->business_name;
            $this->register_comapany_name = $this->safari_operator_update_model->register_comapany_name;
            $this->address = $this->safari_operator_update_model->address;
            $this->legal_entity_type = $this->safari_operator_update_model->legal_entity_type;

            // $this->legal_entity_phone = $this->safari_operator_update_model->operator_phone_no;
            $this->legal_entity_whatsapp = $this->safari_operator_update_model->legal_entity_whatsapp;
            $this->legal_entity_email = $this->safari_operator_update_model->operator_email;

            $this->registration_number = $this->safari_operator_update_model->registration_number;
            $this->pan_number = $this->safari_operator_update_model->pan_number;
            $this->registration_copy_upload = $this->safari_operator_update_model->registration_copy_upload;
            $this->pan_upload = $this->safari_operator_update_model->pan_upload;

            $this->about_business = $this->safari_operator_update_model->about_business;
            $this->billing_phone = $this->safari_operator_update_model->billing_phone;

            $this->bank_name = $this->safari_operator_update_model->bank_name;
            $this->account_holder_name = $this->safari_operator_update_model->account_holder_name;
            $this->account_number = $this->safari_operator_update_model->account_number;
            $this->ifsc_number = $this->safari_operator_update_model->ifsc_number;
            $this->cancel_check_upload = $this->safari_operator_update_model->cancel_check_upload;

            $this->owner_name = $this->safari_operator_update_model->owner_name;
            $this->kyc_whatsapp = $this->safari_operator_update_model->kyc_whatsapp;
            $this->kyc_email = $this->safari_operator_update_model->kyc_email;
            $this->kyc_pan = $this->safari_operator_update_model->kyc_pan;
            $this->aadhar_number = $this->safari_operator_update_model->aadhar_number;
            $this->kyc_pan_upload = $this->safari_operator_update_model->kyc_pan_upload;
            $this->aadhar_front_upload = $this->safari_operator_update_model->aadhar_front_upload;
            $this->aadhar_back_upload = $this->safari_operator_update_model->aadhar_back_upload;

            $this->created_at = $this->safari_operator_update_model->created_at;
        }
    }


    /**
     * {@inheritdoc}is_offer_premium_budget
     */
    public function rules()
    {
        return [
            [['logo_file'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'webp'], 'maxSize' => 1 * 1024 * 1024],
            [['address', 'about_business', 'business_name', 'operator_name', 'register_comapany_name'], 'string', 'max' => 255, 'tooLong' => 'should not exceed 255 characters'],
            [['legal_entity_whatsapp', 'kyc_whatsapp', 'billing_phone'], 'match', 'pattern' => '/^[6-9]\d{9}$/', 'message' => 'Contact Number is Invalid.'],
            [['legal_entity_email'], 'email'],
            [['registration_number'], 'string', 'max' => 100],
            [['pan_number'], 'match', 'pattern' => '/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', 'message' => 'PAN must be in format AAAAA9999A'],
            [['bank_name', 'account_holder_name', 'owner_name', 'kyc_email', 'kyc_pan'], 'string', 'max' => 255, 'tooLong' => 'should not exceed 255 characters'],
            ['ifsc_number', 'match', 'pattern' => '/^[A-Z]{4}0[A-Z0-9]{6}$/', 'message' => 'Invalid IFSC format'],
            ['account_number', 'match', 'pattern' => '/^[0-9]{9,18}$/', 'message' => 'Account number must be 9 to 18 digits'],
            ['aadhar_number', 'match', 'pattern' => '/^[2-9]{1}[0-9]{11}$/', 'message' => 'Aadhaar number must be 12 digits and not start with 0 or 1'],
            ['aadhar_number', 'string', 'length' => 12, 'tooShort' => 'Aadhaar must be 12 digits', 'tooLong' => 'Aadhaar must be 12 digits'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'operator_name' => 'Operator Name',
            'business_name' => 'Business Name',
            'address' => 'Address',
            'logo' => 'Logo',

            'legal_entity_phone' => 'Legal Entity Phone',
            'legal_entity_whatsapp' => 'Legal Entity Whatsapp',
            'legal_entity_email' => 'Legal Entity Email',

            'registration_number' => 'Registration Number',
            'pan_number' => 'PAN Number',

            'about_business' => 'About Business',
            'billing_phone' => 'Billing Phone',

            'bank_name' => 'Bank Name',
            'account_holder_name' => 'Account Holder Name',
            'account_number' => 'Account Number',
            'ifsc_number' => 'IFSC Number',
            'cancel_check_upload' => 'Cancel Check Upload',

            'owner_name' => 'Owner Name',
            'kyc_whatsapp' => 'KYC Whatsapp',
            'kyc_email' => 'KYC Email',
            'kyc_pan' => 'KYC PAN',
            'aadhar_number' => 'Aadhaar Number',
            'kyc_pan_upload' => 'KYC PAN Upload',
            'aadhar_front_upload' => 'Aadhaar Front Upload',
            'aadhar_back_upload' => 'Aadhaar Back Upload',
        ];
    }

    public function initializeForm()
    {
        $this->safari_operator_update_model->operator_name = $this->operator_name;
        $this->safari_operator_update_model->business_name = $this->business_name;
        $this->safari_operator_update_model->register_comapany_name = $this->business_name;
        $this->safari_operator_update_model->address = $this->address;


        // $this->safari_operator_update_model->operator_phone_no = $this->legal_entity_phone;
        // $this->safari_operator_update_model->phone_no = $this->legal_entity_phone;
        $this->safari_operator_update_model->legal_entity_whatsapp = $this->legal_entity_whatsapp;
        $this->safari_operator_update_model->legal_entity_type = $this->legal_entity_type;
        $this->safari_operator_update_model->operator_email = $this->legal_entity_email;
        $this->safari_operator_update_model->email = $this->legal_entity_email;

        $this->safari_operator_update_model->registration_number = $this->registration_number;
        $this->safari_operator_update_model->pan_number = strtoupper($this->pan_number);

        $this->safari_operator_update_model->about_business = $this->about_business;
        $this->safari_operator_update_model->billing_phone = $this->billing_phone;

        $this->safari_operator_update_model->bank_name = $this->bank_name;
        $this->safari_operator_update_model->account_holder_name = $this->account_holder_name;
        $this->safari_operator_update_model->account_number = $this->account_number;
        $this->safari_operator_update_model->ifsc_number = strtoupper($this->ifsc_number);

        $this->safari_operator_update_model->owner_name = $this->owner_name;
        $this->safari_operator_update_model->kyc_whatsapp = $this->kyc_whatsapp;
        $this->safari_operator_update_model->kyc_email = $this->kyc_email;
        $this->safari_operator_update_model->kyc_pan = strtoupper($this->kyc_pan);
        $this->safari_operator_update_model->aadhar_number = $this->aadhar_number;
    }

    public function uploadFile()
    {

        if ($this->logo_file) {
            $storagePath = 'operator-registration' . '/' . date('ym', $this->created_at);
            $fileName = $this->safari_operator_update_model->user_id . '_logo_' . time() . '.' . $this->logo_file->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::restrictedsaveUploadedFile($this->logo_file, $filePath, $fileName, true)) {
                        $this->safari_operator_update_model->logo = $filePath;

                        if ($this->safari_operator_update_model->save(false)) {
                            $sourcePath = $this->safari_operator_update_model->logo;
                            $destinationPath = $this->safari_operator_update_model->logo;
                            if (Yii::$app->rfs->has($sourcePath)) {
                                $fileContent = Yii::$app->rfs->read($sourcePath);
                                Yii::$app->fs->write($destinationPath, $fileContent);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        if ($this->registration_copy_upload) {
            $storagePath = 'operator-registration' . '/' . date('ym', $this->created_at);
            $fileName = $this->safari_operator_update_model->user_id . '_registrationcopy_' . time() . '.' . $this->registration_copy_upload->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($fileName) {
                try {
                    if ($etag =  FsHelper::restrictedsaveUploadedFile($this->registration_copy_upload, $filePath, $fileName, true)) {
                        $this->safari_operator_update_model->registration_copy_upload = $filePath;
                        $this->safari_operator_update_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        if ($this->pan_upload) {
            $storagePath = 'operator-registration' . '/' . date('ym', $this->created_at);
            $fileName = $this->safari_operator_update_model->user_id . '_pancard_' . time() . '.' . $this->pan_upload->extension;
            $filePath = $storagePath . '/' . $fileName;

            if ($fileName) {
                try {
                    if ($etag =  FsHelper::restrictedsaveUploadedFile($this->pan_upload, $filePath, $fileName, true)) {
                        $this->safari_operator_update_model->pan_upload = $filePath;
                        $this->safari_operator_update_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        if ($this->cancel_check_upload) {
            $storagePath = 'operator-registration' . '/' . date('ym', $this->created_at);
            $fileName = $this->safari_operator_update_model->user_id . '_cancelcheck_' . time() . '.' . $this->cancel_check_upload->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::restrictedsaveUploadedFile($this->cancel_check_upload, $filePath, $fileName, true)) {
                        $this->safari_operator_update_model->cancel_check_upload = $filePath;
                        $this->safari_operator_update_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        if ($this->kyc_pan_upload) {
            $storagePath = 'operator-registration' . '/' . date('ym', $this->created_at);
            $fileName = $this->safari_operator_update_model->user_id . '_kycpan_' . time() . '.' . $this->kyc_pan_upload->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::restrictedsaveUploadedFile($this->kyc_pan_upload, $filePath, $fileName, true)) {
                        $this->safari_operator_update_model->kyc_pan_upload = $filePath;
                        $this->safari_operator_update_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        if ($this->aadhar_front_upload) {
            $storagePath = 'operator-registration' . '/' . date('ym', $this->created_at);
            $fileName = $this->safari_operator_update_model->user_id . '_aadharfront_' . time() . '.' . $this->aadhar_front_upload->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::restrictedsaveUploadedFile($this->aadhar_front_upload, $filePath, $fileName, true)) {
                        $this->safari_operator_update_model->aadhar_front_upload = $filePath;
                        $this->safari_operator_update_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }

        if ($this->aadhar_back_upload) {
            $storagePath = 'operator-registration' . '/' . date('ym', $this->created_at);
            $fileName = $this->safari_operator_update_model->user_id . '_aadharback_' . time() . '.' . $this->aadhar_back_upload->extension;
            $filePath = $storagePath . '/' . $fileName;
            if ($fileName) {
                try {
                    if ($etag =  FsHelper::restrictedsaveUploadedFile($this->aadhar_back_upload, $filePath, $fileName, true)) {
                        $this->safari_operator_update_model->aadhar_back_upload = $filePath;
                        $this->safari_operator_update_model->save(false);
                    }
                } catch (\Exception $e) {
                    throw new \yii\base\Exception("Failed to save uploaded file. Please try again.");
                }
            }
        }
    }

    /**
     * Update Partner Registration Table Update
     */
    public function partnerRegistrationTableUpdate(SafariOperator $model)
    {
        $parter_registration_model = PartnerRegistration::find()->where(['id' => $model->safari_operator_request_id])->one();
        if ($parter_registration_model) {
            $parter_registration_model->legal_entity_name = $model->operator_name;
            $parter_registration_model->brand_name = $model->business_name;
            $parter_registration_model->address = $model->address;
            $parter_registration_model->logo = $model->logo;
            
            // $parter_registration_model->legal_entity_phone = $model->legal_entity_phone;
            $parter_registration_model->legal_entity_whatsapp = $model->legal_entity_whatsapp;
            $parter_registration_model->legal_entity_email = $model->legal_entity_email;
            
            $parter_registration_model->registration_number = $model->registration_number;
            $parter_registration_model->registration_copy_upload = $model->registration_copy_upload;
            $parter_registration_model->pan_number = $model->pan_number;
            $parter_registration_model->pan_upload = $model->pan_upload;
            
            $parter_registration_model->about_business = $model->about_business;
            $parter_registration_model->billing_phone = $model->billing_phone;

            $parter_registration_model->bank_name = $model->bank_name;
            $parter_registration_model->account_holder_name = $model->account_holder_name;
            $parter_registration_model->account_number = $model->account_number;
            $parter_registration_model->ifsc_number = $model->ifsc_number;
            $parter_registration_model->cancel_check_upload = $model->cancel_check_upload;

            $parter_registration_model->owner_name = $model->owner_name;
            $parter_registration_model->kyc_whatsapp = $model->kyc_whatsapp;
            $parter_registration_model->kyc_email = $model->kyc_email;
            $parter_registration_model->kyc_pan = $model->kyc_pan;
            $parter_registration_model->aadhar_number = $model->aadhar_number;
            $parter_registration_model->kyc_pan_upload = $model->kyc_pan_upload;
            $parter_registration_model->aadhar_front_upload = $model->aadhar_front_upload;
            $parter_registration_model->aadhar_back_upload = $model->aadhar_back_upload;

            $parter_registration_model->save(false);
        }
    }
}
