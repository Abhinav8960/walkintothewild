<?php

namespace business\controllers;

use common\models\partnerregistration\form\PartnerGstDetailsForm;
use common\models\partnerregistration\PartnerRegistration;
use common\models\partnerregistration\form\PartnerRegistrationForm;
use common\models\partnerregistration\PartnerGstDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use Yii;

class PartnerRegistrationController extends Controller
{

    public function actionCreate()
    {
        $this->layout = 'registration';

        if (Yii::$app->user->identity) {
            $partner_model = PartnerRegistration::findOne(['user_id' => Yii::$app->user->identity->id]);
            if (!$partner_model) {
                $model = new PartnerRegistrationForm();
            } else {
                $model = new PartnerRegistrationForm($partner_model);
            }
        }
        $model->user_id = Yii::$app->user->identity->id;
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP1);
        $model->form1_status = PartnerRegistration::FORM_FILLED;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->logo_file_upload = UploadedFile::getInstance($model, 'logo_file_upload');

                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 2;
                    if ($model->partner_model->save()) {
                        $model->uploadFiles();
                        return $this->redirect(['step-2']);
                    } else {
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
            'currentStep' => 1
        ]);
    }

    public function actionStep2()
    {
        $this->layout = 'registration';
        $partner_model = $this->findModel();

        if ($partner_model->current_step < 2) {
            return $this->redirect(['create']);
        }

        $model = new PartnerRegistrationForm($partner_model);
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP2);
        $model->form2_status = PartnerRegistration::FORM_FILLED;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->registration_copy_file_upload = UploadedFile::getInstance($model, 'registration_copy_file_upload');
                $model->pan_file_upload = UploadedFile::getInstance($model, 'pan_file_upload');

                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 3;
                    if ($model->partner_model->save(false)) {
                        $model->uploadFiles();
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
        $partner_model = $this->findModel();

        if ($partner_model->current_step < 3) {
            return $this->redirect(['step-2']);
        }

        $model = new PartnerRegistrationForm($partner_model);
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP3);
        $model->form3_status = PartnerRegistration::FORM_FILLED;
        if ($partner_model->gst_id) {
            $gstDetail = PartnerGstDetails::findOne($partner_model->gst_id);
            if (!$gstDetail) {
                $gstDetail = new PartnerGstDetails();
            }
        } else {
            $gstDetail = new PartnerGstDetails();
        }
        $gstForm = new PartnerGstDetailsForm($gstDetail);

        if (Yii::$app->request->isPost) {
            $isModelLoaded = $model->load(Yii::$app->request->post());
            $isGstLoaded = $gstForm->load(Yii::$app->request->post());

            if ($isModelLoaded) {
                $gstForm->filepath_upload = UploadedFile::getInstance($gstForm, 'filepath_upload');
                if ($model->validate() && (!$isGstLoaded || $gstForm->validate())) {
                    if ($isGstLoaded) {
                        $gstForm->initializeForm();
                        if ($gstForm->gstdetail_model->save(false)) {
                            $gstForm->uploadFiles();
                        }
                    }

                    $model->initializeForm();
                    $model->partner_model->current_step = 4;
                    $model->partner_model->gst_id = $gstForm->gstdetail_model->id;

                    if ($model->partner_model->save(false)) {
                        return $this->redirect(['step-4']);
                    }
                }
            }
        }

        return $this->render('businessdetails', [
            'model' => $model,
            'partner_model' => $partner_model,
            'gst_model' => $gstForm,
            'currentStep' => 3,
        ]);
    }



    public function actionStep4()
    {

        $this->layout = 'registration';
        $partner_model = $this->findModel();
        if ($partner_model->current_step < 4) {
            return $this->redirect(['step-3']);
        }
        $model = new PartnerRegistrationForm($partner_model);
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP4);
        $model->form4_status = PartnerRegistration::FORM_FILLED;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->cancel_check_file_upload = UploadedFile::getInstance($model, 'cancel_check_file_upload');
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 5;
                    $model->partner_model->loadDefaultValues();
                    if ($model->partner_model->save(false)) {
                        $model->uploadFiles();
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
        $partner_model = $this->findModel();
        if ($partner_model->current_step < 5) {
            return $this->redirect(['step-4']);
        }
        $model = new PartnerRegistrationForm($partner_model);
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP5);
        $model->form5_status = PartnerRegistration::FORM_FILLED;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if (Yii::$app->request->post('same_as_previous')) {
                    if ($model->pan_number) {
                        $model->kyc_pan = $model->pan_number;
                    }
                    if ($model->pan_upload) {
                        $model->kyc_pan_upload = $model->pan_upload;
                    }
                }
                $model->kyc_pan_file_upload = UploadedFile::getInstance($model, 'kyc_pan_file_upload');
                $model->aadhar_front_file_upload = UploadedFile::getInstance($model, 'aadhar_front_file_upload');
                $model->aadhar_back_file_upload = UploadedFile::getInstance($model, 'aadhar_back_file_upload');
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->loadDefaultValues();
                    if ($model->partner_model->save(false)) {
                        $model->uploadFiles();
                        return $this->redirect(['final-view']);
                    }
                }
            }
        } else {
            $model->partner_model->loadDefaultValues();
        }
        return $this->render('userkyc', [
            'model' => $model,
            'partner_model' => $partner_model,
            'currentStep' => 5
        ]);
    }

    public function actionFinalView()
    {
        $this->layout = 'registration';

        $partner_model = $this->findModel();
        if ($partner_model === null) {
            throw new NotFoundHttpException('Partner not found.');
        }
        $partner_model->final_approved = 0;
        if (!$partner_model->save(false)) {
            Yii::error('Failed to save');
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
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Send For Approval Successfully.');
            return $this->redirect(Yii::$app->request->referrer ?: ['final-view']);
        } else {
            Yii::$app->session->setFlash('error', 'There was an error while sending for approval.');

            return $this->redirect(Yii::$app->request->referrer ?: ['final-view']);
        }
    }
}
