<?php

namespace business\controllers;

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
        $model->form1_status = 1;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 2;
                    if ($model->partner_model->save()) {
                        return $this->redirect(['step-2']);
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
        $model->form2_status = 1;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 3;
                    if ($model->partner_model->save(false)) {
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
        $model->form3_status = 1;
        if ($partner_model->gst_id) {
            $gst_model = PartnerGstDetails::findOne($partner_model->gst_id);
            if (!$gst_model) {
                $gst_model = new PartnerGstDetails();
            }
        } else {
            $gst_model = new PartnerGstDetails();
        }
        if (Yii::$app->request->isPost) {
            $isModelLoaded = $model->load(Yii::$app->request->post());
            $isGstLoaded = $gst_model->load(Yii::$app->request->post());
            if ($isModelLoaded) {
                if ($model->validate() && (!$isGstLoaded || $gst_model->validate())) {
                    if ($isGstLoaded) {
                        $gst_model->uploadFiles();
                        $gst_model->save(false);
                        $model->partner_model->gst_id = $gst_model->id;
                    }
                    $model->initializeForm();
                    $model->partner_model->current_step = 4;
                    if ($model->partner_model->save(false)) {
                        return $this->redirect(['step-4']);
                    }
                }
            }
        }

        return $this->render('businessdetails', [
            'model' => $model,
            'partner_model' => $partner_model,
            'gst_model' => $gst_model,
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
        $model->form4_status = 1;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->uploadFiles();
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->current_step = 5;
                    $model->partner_model->loadDefaultValues();
                    if ($model->partner_model->save(false)) {
                        return $this->redirect(['step-5']);
                    }
                }
            }
        } else {
            $model->partner_model->loadDefaultValues();
        }

        return $this->render('bankdetails',[
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
        $model->form5_status = 1;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->uploadFiles();
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->partner_model->loadDefaultValues();
                    if ($model->partner_model->save(false)) {
                        return $this->render('final-view', ['currentStep' => 5, 'model' => $model]);
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


    protected function findModel()
    {
        if (($model = PartnerRegistration::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
