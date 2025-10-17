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
    public $about_business;
    public $logo_file;
    public $register_comapany_name;

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
            $this->about_business = $this->safari_operator_update_model->about_business;

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
            'about_business' => 'About Business',
        ];
    }

    public function initializeForm()
    {
        $this->safari_operator_update_model->operator_name = $this->operator_name;
        $this->safari_operator_update_model->business_name = $this->business_name;
        $this->safari_operator_update_model->register_comapany_name = $this->business_name;
        $this->safari_operator_update_model->address = $this->address;
        $this->safari_operator_update_model->about_business = $this->about_business;
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
            $parter_registration_model->about_business = $model->about_business;
            $parter_registration_model->logo = $model->logo;
            $parter_registration_model->save(false);
        }
    }
}
