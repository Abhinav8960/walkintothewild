<?php

namespace business\controllers;

use common\models\EmailVerification;
use common\models\MobileVerification;
use common\models\operator\SafariOperator;
use common\models\partnerregistration\form\PartnerGstDetailsForm;
use common\models\partnerregistration\form\PartnerRegistrationForm;
use common\models\partnerregistration\PartnerGstDetails;
use common\models\partnerregistration\PartnerParkList;
use common\models\partnerregistration\PartnerRegistration;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\Json;

class PartnerRegistrationController extends Controller
{
    public function actionCreate()
    {
        $this->layout = 'registration';
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        if (Yii::$app->user->identity) {
            $partner_model = PartnerRegistration::findOne(['user_id' => Yii::$app->user->identity->id]);
            if (!$partner_model) {
                $model = new PartnerRegistrationForm();
            } else {
                $model = new PartnerRegistrationForm($partner_model);
                $this->handleRedirect($partner_model, 1);
            }
        }
        $model->action_url = '/partner-registration/create';
        $model->action_validate_url = '/partner-registration/validate-create?scenario=' . PartnerRegistrationForm::SCENARIO_STEP1;

        $model->user_id = Yii::$app->user->identity->id;
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP1);
        $model->form1_status = PartnerRegistration::FORM_FILLED;
        $verification_model = new MobileVerification();
        $verification_model->user_id = $model->user_id;
        $isLegalEntitySaved = false; //flag 
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->logo_file_upload = UploadedFile::getInstance($model, 'logo_file_upload');

                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 2;
                    if ($model->partner_model != null && ($model->partner_model->form1_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form2_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form3_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form4_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form5_status == PartnerRegistration::FORM_REJECTED)) {
                        $model->partner_model->final_approved = 0;
                    }
                    $model->form1_status = PartnerRegistration::FORM_FILLED;

                    if ($model->partner_model->getOldAttribute('legal_entity_phone') != $model->partner_model->legal_entity_phone) {
                        $model->partner_model->is_phone_no_verified = 0;
                    }

                    if ($model->partner_model->save()) {
                        $isLegalEntitySaved = true;  //flag
                        $model->uploadFiles();
                        if ($model->partner_model != null && ($model->partner_model->is_phone_no_verified == 1) && ($model->partner_model->form1_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form2_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form3_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form4_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form5_status == PartnerRegistration::FORM_FILLED)) {
                            return $this->redirect(['final-view']);
                        }
                        $this->actionSendOtpMobile();
                        if ($model->partner_model->is_phone_no_verified == 1) {
                            return $this->redirect(['step-2']);
                        }
                    } else {
                        // print_r($model->partner_model->getErrors());
                        // die();
                        Yii::$app->session->setFlash('error', 'Please fill all required fields.');
                    }
                }
            }
        } else {
            $model->partner_model->loadDefaultValues();
        }

        return $this->render('legalentity', [
            'model' => $model,
            'partner_model' => $partner_model,
            'currentStep' => 1,
            'verification_model' => $verification_model,
            'isLegalEntitySaved' => $isLegalEntitySaved
        ]);
    }

    public function actionStep2()
    {
        $this->layout = 'registration';
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $partner_model = $this->findModel();
        $this->handleRedirect($partner_model, 2);
        // if ($partner_model->current_step < 2) {
        //     return $this->redirect(['create']);
        // }

        $model = new PartnerRegistrationForm($partner_model);
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP2);
        $model->form2_status = PartnerRegistration::FORM_FILLED;
        $model->action_url = '/partner-registration/step-2';
        $model->action_validate_url = '/partner-registration/validate-create?scenario=' . PartnerRegistrationForm::SCENARIO_STEP2;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->registration_copy_file_upload = UploadedFile::getInstance($model, 'registration_copy_file_upload');
                $model->pan_file_upload = UploadedFile::getInstance($model, 'pan_file_upload');

                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 3;
                    if ($model->partner_model != null && ($model->partner_model->form1_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form2_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form3_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form4_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form5_status == PartnerRegistration::FORM_REJECTED)) {
                        $model->partner_model->final_approved = 0;
                    }
                    $model->form2_status = PartnerRegistration::FORM_FILLED;
                    if ($model->partner_model->save(false)) {
                        $model->uploadFiles();
                        if ($model->partner_model != null && ($model->partner_model->form1_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form2_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form3_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form4_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form5_status == PartnerRegistration::FORM_FILLED)) {
                            return $this->redirect(['final-view']);
                        }
                        return $this->redirect(['step-3']);
                    }
                }
            }
        } else {
            $model->partner_model->loadDefaultValues();
        }

        return $this->render('registrationproof', [
            'model' => $model,
            'partner_model' => $partner_model,
            'currentStep' => 2
        ]);
    }

    public function actionStep3()
    {

        $this->layout = 'registration';
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $partner_model = $this->findModel();
        $this->handleRedirect($partner_model, 3);

        // if ($partner_model->current_step < 3) {
        //     return $this->redirect(['step-2']);
        // }

        $model = new PartnerRegistrationForm($partner_model);
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP3);
        $model->form3_status = PartnerRegistration::FORM_FILLED;
        $model->action_url = '/partner-registration/step-3';
        $model->action_validate_url = '/partner-registration/validate-create?scenario=' . PartnerRegistrationForm::SCENARIO_STEP3;
        // $gstDetail = PartnerGstDetails::findOne($partner_model->gst_id);
        $gstDetail = PartnerGstDetails::find()->where(['partner_registration_id' => $partner_model->id])->one();
        if (!$gstDetail) {
            $gstForm = new PartnerGstDetailsForm();
        } else {
            $gstForm = new PartnerGstDetailsForm($gstDetail);
        }
        $gstForm->setScenario(PartnerRegistrationForm::SCENARIO_STEP3);
        $gstForm->action_url = '/partner-registration/step-3';
        $gstForm->action_validate_url = '/partner-registration/validate-create?scenario=' . PartnerGstDetailsForm::SCENARIO_STEP3;


        $verification_model = new EmailVerification();
        $verification_model->user_id = $model->user_id;
        $isbusinessSaved = false; //flag 

        if (Yii::$app->request->isPost) {
            $isModelLoaded = $model->load(Yii::$app->request->post());
            $isGstLoaded = $gstForm->load(Yii::$app->request->post());

            if ($isModelLoaded) {
                $gstForm->filepath_upload = UploadedFile::getInstance($gstForm, 'filepath_upload');
                if ($model->validate() && (!$isGstLoaded || $gstForm->validate())) {
                    if ($isGstLoaded) {
                        $gstForm->initializeForm();
                        $gstForm->gstdetail_model->partner_registration_id = $model->partner_model->id;
                        $gstForm->gstdetail_model->status = 1;
                        if ($gstForm->gstdetail_model->save(false)) {
                            $gstForm->uploadFiles();
                        }
                    }
                    $selectedParkIds = $model->park_list ?? [];
                    $this->PartnerParks($selectedParkIds, $model->partner_model->id);
                    $model->initializeForm();
                    $model->partner_model->current_step = 4;
                    $model->partner_model->gst_id = $gstForm->gstdetail_model->id;
                    if ($model->partner_model != null && ($model->partner_model->form1_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form2_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form3_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form4_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form5_status == PartnerRegistration::FORM_REJECTED)) {
                        $model->partner_model->final_approved = 0;
                    }
                    $model->form3_status = PartnerRegistration::FORM_FILLED;
                    if ($model->partner_model->getOldAttribute('billing_mail') != $model->partner_model->billing_mail) {
                        $model->partner_model->is_billing_mail_verified = 0;
                    }
                    if ($model->partner_model->save(false)) {
                        $isbusinessSaved = true; //flag 

                        if ($model->partner_model != null && ($model->partner_model->is_billing_mail_verified == 1) && ($model->partner_model->form1_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form2_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form3_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form4_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form5_status == PartnerRegistration::FORM_FILLED && $model->partner_model->is_billing_mail_verified == 1)) {
                            return $this->redirect(['final-view']);
                        }
                        $this->actionSendOtpMobile();
                        if ($model->partner_model->is_billing_mail_verified == 1) {
                        return $this->redirect(['step-4']);
                        }
                    }
                }
            }
        }

        return $this->render('businessdetails', [
            'model' => $model,
            'partner_model' => $partner_model,
            'gst_model' => $gstForm,
            'currentStep' => 3,
            'verification_model' => $verification_model,
            'isbusinessSaved' => $isbusinessSaved
        ]);
    }

    public function actionStep4()
    {
        $this->layout = 'registration';
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $partner_model = $this->findModel();
        $this->handleRedirect($partner_model, 4);
        // if ($partner_model->current_step < 4) {
        //     return $this->redirect(['step-3']);
        // }
        $model = new PartnerRegistrationForm($partner_model);
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP4);
        $model->form4_status = PartnerRegistration::FORM_FILLED;
        $model->action_url = '/partner-registration/step-4';
        $model->action_validate_url = '/partner-registration/validate-create?scenario=' . PartnerRegistrationForm::SCENARIO_STEP4;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->cancel_check_file_upload = UploadedFile::getInstance($model, 'cancel_check_file_upload');
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 5;
                    $model->partner_model->loadDefaultValues();
                    if ($model->partner_model != null && ($model->partner_model->form1_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form2_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form3_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form4_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form5_status == PartnerRegistration::FORM_REJECTED)) {
                        $model->partner_model->final_approved = 0;
                    }
                    $model->form4_status = PartnerRegistration::FORM_FILLED;

                    if ($model->partner_model->save(false)) {
                        $model->uploadFiles();
                        if ($model->partner_model != null && ($model->partner_model->form1_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form2_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form3_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form4_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form5_status == PartnerRegistration::FORM_FILLED)) {
                            return $this->redirect(['final-view']);
                        }
                        return $this->redirect(['step-5']);
                    }
                }
            }
        } else {
            $model->partner_model->loadDefaultValues();
        }

        return $this->render('bankdetails', [
            'model' => $model,
            'partner_model' => $partner_model,
            'currentStep' => 4
        ]);
    }

    public function actionStep5()
    {
        $this->layout = 'registration';
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $partner_model = $this->findModel();
        $this->handleRedirect($partner_model, 5);
        // if ($partner_model->current_step < 5) {
        //     return $this->redirect(['step-4']);
        // }
        $model = new PartnerRegistrationForm($partner_model);
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP5);
        $model->form5_status = PartnerRegistration::FORM_FILLED;
        $model->action_url = '/partner-registration/step-5';
        $model->action_validate_url = '/partner-registration/validate-create?scenario=' . PartnerRegistrationForm::SCENARIO_STEP5;

        $verification_model = new MobileVerification();
        $verification_model->user_id = $model->user_id;
        $isUserKycSaved = false; //flag 

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                // if (Yii::$app->request->post('same_as_previous')) {
                //     if ($model->pan_number) {
                //         $model->kyc_pan = $model->pan_number;
                //     }
                //     if ($model->pan_upload) {
                //         $model->kyc_pan_upload = $model->pan_upload;
                //     }
                // }
                $model->kyc_pan_file_upload = UploadedFile::getInstance($model, 'kyc_pan_file_upload');
                $model->aadhar_front_file_upload = UploadedFile::getInstance($model, 'aadhar_front_file_upload');
                $model->aadhar_back_file_upload = UploadedFile::getInstance($model, 'aadhar_back_file_upload');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_model != null && ($model->partner_model->form1_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form2_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form3_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form4_status == PartnerRegistration::FORM_REJECTED || $model->partner_model->form5_status == PartnerRegistration::FORM_REJECTED)) {
                        $model->partner_model->final_approved = 0;
                    }
                    $model->form5_status = PartnerRegistration::FORM_FILLED;
                    $model->partner_model->loadDefaultValues();

                    if ($model->partner_model->getOldAttribute('kyc_phone') != $model->partner_model->kyc_phone) {
                        $model->partner_model->is_kyc_phone_verified = 0;
                    }

                    if ($model->partner_model->save(false)) {
                        $isUserKycSaved = true; //flag 
                        $model->uploadFiles();
                        //     if($model->partner_model != null && ($model->partner_model->form1_status == PartnerRegistration:: FORM_FILLED && $model->partner_model->form2_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form3_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form4_status == PartnerRegistration::FORM_FILLED && $model->partner_model->form5_status == PartnerRegistration::FORM_FILLED)){
                        //         return $this->redirect(['final-view']);
                        //  }
                        $this->actionSendOtpMobile();
                        if ($model->partner_model->is_kyc_phone_verified == 1) {
                            return $this->redirect(['final-view']);
                        }          
                    }
                }
            }
        } else {
            $model->partner_model->loadDefaultValues();
        }
        return $this->render('userkyc', [
            'model' => $model,
            'partner_model' => $partner_model,
            'currentStep' => 5,
            'verification_model' => $verification_model,
            'isUserKycSaved' => $isUserKycSaved
        ]);
    }

    public function actionFinalView()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        if (!empty(\Yii::$app->user->identity->operator)) {
            return $this->redirect(['/']);
        }
        $this->layout = 'registration';

        $partner_model = $this->findModel();
        if ($partner_model === null) {
            throw new NotFoundHttpException('Partner not found.');
        }
        if ($partner_model != null && ($partner_model->form1_status == PartnerRegistration::FORM_REJECTED || $partner_model->form2_status == PartnerRegistration::FORM_REJECTED || $partner_model->form3_status == PartnerRegistration::FORM_REJECTED || $partner_model->form4_status == PartnerRegistration::FORM_REJECTED || $partner_model->form5_status == PartnerRegistration::FORM_REJECTED)) {
            $partner_model->final_approved = 0;
            if (!$partner_model->save(false)) {
                Yii::error('Failed to save');
            }
        }
        $model = new PartnerRegistrationForm($partner_model);
        return $this->render('final-view', [
            'model' => $model,
            'currentStep' => 5,
            'partner_model' => $partner_model,
        ]);
    }

    protected function findModel()
    {
        if (($model = PartnerRegistration::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSendApproval($id)
    {
        $model = $this->findModel($id);
        $model->is_sendforapproval = 1;
        $model->status = 1;


        if (($model->form1_status == PartnerRegistration::FORM_FILLED && $model->updated_time_form_1 !== null) ||
            ($model->form2_status == PartnerRegistration::FORM_FILLED && $model->updated_time_form_2 !== null) ||
            ($model->form3_status == PartnerRegistration::FORM_FILLED && $model->updated_time_form_3 !== null) ||
            ($model->form4_status == PartnerRegistration::FORM_FILLED && $model->updated_time_form_4 !== null) ||
            ($model->form5_status == PartnerRegistration::FORM_FILLED && $model->updated_time_form_5 !== null))
        {
            $model->resent_after_rejection = 1;
        }


        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Send For Approval Successfully.');
            return $this->redirect(['thank-you']);
        } else {
            Yii::$app->session->setFlash('error', 'There was an error while sending for approval.');

            return $this->redirect(Yii::$app->request->referrer ?: ['final-view']);
        }
    }

    public function actionThankYou()
    {
        $this->layout = 'registration';

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = PartnerRegistration::find()
            ->where(['user_id' => Yii::$app->user->identity->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();;

        $safari_operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->one();
        if ($model === null) {
            throw new NotFoundHttpException('Registration record not found.');
        }

        if ($model->final_approved == 1 && $model->is_sendforapproval == 1 && $safari_operator->status = SafariOperator::STATUS_ACTIVE) {
            return $this->redirect(['site/index']);
        } elseif ($model->form1_status == PartnerRegistration::FORM_REJECTED || $model->form2_status == PartnerRegistration::FORM_REJECTED || $model->form3_status == PartnerRegistration::FORM_REJECTED || $model->form4_status == PartnerRegistration::FORM_REJECTED || $model->form5_status == PartnerRegistration::FORM_REJECTED) {
            return $this->redirect(['final-view']);
        } else {
            return $this->render('thank-you');
        }
    }

    private function handleRedirect($model, $step)
    {
        if (!empty(\Yii::$app->user->identity->operator)) {
            return $this->redirect(['/']);
        }

        $col = 'form' . $step . '_status';
        // if(in_array($model->$col,[PartnerRegistration::FORM_APPROVED])){

        if (isset($model->$col) && PartnerRegistration::FORM_APPROVED == $model->$col || (PartnerRegistration::FORM_FILLED == $model->$col && $model->is_sendforapproval != 0)) {
            return $this->redirect(['final-view']);
        }
    }

    // public function actionValidateCreate($id = null)
    // {
    //     $model = new PartnerRegistrationForm();
    //     $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP1);
    //     if ($id != null) {
    //         $formmodel = $this->findModel($id);
    //         $model = new PartnerRegistrationForm($formmodel);
    //     }

    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return \yii\bootstrap5\ActiveForm::validate($model);
    //     }

    // }

    public function actionValidateCreate($scenario, $id = null)
    {
        $model = new PartnerRegistrationForm();
        $model->setScenario($scenario);

        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new PartnerRegistrationForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }
    }

    private function PartnerParks($selectedParkIds, $id)
    {
        $existingParks = PartnerParkList::find()
            ->where(['partner_registration_id' => $id])
            ->indexBy('park_id')
            ->all();

        foreach ($existingParks as $parkId => $park) {
            if (!in_array($parkId, $selectedParkIds)) {
                $park->status = -1;
                $park->save(false);
            }
        }

        foreach ($selectedParkIds as $parkId) {
            if (isset($existingParks[$parkId])) {
                $existingParks[$parkId]->status = 1;
                $existingParks[$parkId]->save(false);
            } else {
                $newPark = new PartnerParkList();
                $newPark->partner_registration_id = $id;
                $newPark->park_id = $parkId;
                $newPark->status = 1;
                $newPark->save(false);
            }
        }

        $operated_parks = PartnerParkList::find()
            ->select('park_id')
            ->where([
                'partner_registration_id' => $id,
                'status' => 1
            ])
            ->column();
        return $operated_parks;
    }

    public function actionDeactivate()
    {
        $this->layout = 'registration';
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        return $this->render('deactivate');
    }






    public function actionSendOtpMobile()
    {
        $model = new MobileVerification();
        $model->user_id = Yii::$app->user->id;
        $model->otp = rand(100000, 999999);
        $model->exp_datetime = date('Y-m-d H:i:s', strtotime('+3 minutes'));
        $model->status = 1;

        $partner_model  = $this->findModel();

        if (Yii::$app->request->isPost) {
            $mobileNo = Yii::$app->request->post('mobile_no');

            if ($mobileNo) {
                if ($mobileNo != $partner_model->legal_entity_phone && $mobileNo != $partner_model->kyc_phone) {
                    Yii::$app->session->setFlash('error', 'Number is Invalid or Not Matched !!');
                    return $this->redirect(Yii::$app->request->referrer);
                }
                $model->mobile_no = $mobileNo;

                if ($model->save(false)) {
                    $to_be_send = MobileVerification::find()->where(['mobile_no' => $mobileNo, 'otp' => $model->otp, 'status' => 1])->andWhere(['<=', 'exp_datetime', date('Y-m-d H:i:s')])->orderBy(['id' => SORT_DESC])->one();
                    return \yii\helpers\Json::encode([
                        'success' => true,
                        'message' => 'OTP sent to ' . $mobileNo
                    ]);
                }
            }
        }
    }



    public function actionOtpVerificationMobile()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $otpByUser = Yii::$app->request->post('otp_by_user');
        if (!$otpByUser) {
            Yii::$app->session->setFlash('error', 'Missing OTP');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $model = MobileVerification::find()->where(['status' => 1, 'user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->one();
        if (!$model) {
            Yii::$app->session->setFlash('error', 'OTP record not found');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if ($model->otp != $otpByUser) {
            Yii::$app->session->setFlash('error', 'Incorrect OTP');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if (strtotime($model->exp_datetime) < time()) {
            Yii::$app->session->setFlash('error', 'OTP has expired');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $partner_model  = $this->findModel();
        $model->status = 2;
        $model->otp_by_user = $otpByUser;
        $model->source_type = MobileVerification::CALLING_NUMBER;
        $model->save(false);
        if ($partner_model->legal_entity_phone == $model->mobile_no) {
            $partner_model->is_phone_no_verified = 1;
            if ($model->status == 2) {
                Yii::$app->session->setFlash('success', 'OTP verified successfully');
            }
            $partner_model->save(false);
        }

        if ($partner_model->kyc_phone == $model->mobile_no) {
            $partner_model->is_kyc_phone_verified = 1;
            if ($model->status == 2) {
                Yii::$app->session->setFlash('success', 'OTP verified successfully');
            }
            $partner_model->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }



    public function actionSendOtpEmail()
    {
        $model = new EmailVerification();
        $model->user_id = Yii::$app->user->id;
        $model->otp = rand(100000, 999999);
        $model->exp_datetime = date('Y-m-d H:i:s', strtotime('+3 minutes'));
        $model->status = 1;

        $partner_model  = $this->findModel();

        if (Yii::$app->request->isPost) {
            $email = Yii::$app->request->post('email');

            if ($email) {
                if ($email != $partner_model->billing_mail) {
                    Yii::$app->session->setFlash('error', 'Email is Invalid or Not Matched !!');
                    return $this->redirect(['partner-registration/step-3']);
                }
                $model->email = $email;

                if ($model->save(false)) {
                    $to_be_send = EmailVerification::find()->where(['email' => $email, 'otp' => $model->otp, 'status' => 1])->andWhere(['>=', 'exp_datetime', date('Y-m-d H:i:s')])->orderBy(['id' => SORT_DESC])->one();
                    if($to_be_send != null){
                    new \common\events\user\EmailVerification($model->user_id,$model->email,$partner_model->legal_entity_name,$to_be_send->otp,$model->exp_datetime);
                    }
                    return \yii\helpers\Json::encode([
                        'success' => true,
                        'message' => 'OTP sent to ' . $email
                    ]);
                }
            }
        }
    }


    public function actionOtpVerificationEmail()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $otpByUser = Yii::$app->request->post('otp_by_user');
        if (!$otpByUser) {
            Yii::$app->session->setFlash('error', 'Missing OTP');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $model = EmailVerification::find()->where(['status' => 1, 'user_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->one();
        if (!$model) {
            Yii::$app->session->setFlash('error', 'OTP record not found');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if ($model->otp != $otpByUser) {
            Yii::$app->session->setFlash('error', 'Incorrect OTP');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if (strtotime($model->exp_datetime) < time()) {
            Yii::$app->session->setFlash('error', 'OTP has expired');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $partner_model  = $this->findModel();
        if ($partner_model->billing_mail == $model->email) {
            $model->status = 2;
            $model->otp_by_user = $otpByUser;
            $model->source_type = EmailVerification::BILLING_MAIL;
            $model->save(false);
            $partner_model->is_billing_mail_verified = 1;
            if ($model->status == 2) {
                Yii::$app->session->setFlash('success', 'OTP verified successfully');
            }
            $partner_model->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
