<?php

namespace business\controllers;

use common\models\operator\SafariOperator;
use common\models\partnerregistration\PartnerRegistration;
use common\models\partnerregistration\form\PartnerRegistrationForm;
use common\models\partnerregistration\PartnerGstDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use Yii;

class PartnerRegistrationController extends Controller
{

    public function actionIndex()
    {
        if (!SafariOperator::find()->where(['user_id' => \Yii::$app->user->id])->limit(1)->exists()) {
            return $this->redirect(['/partner-registration/create']);
        }
    }

    // public function actionCreate()
    // {
    //     $this->layout = 'registration';

    //     if (Yii::$app->user->isGuest) {
    //         return $this->redirect(['site/login']);
    //     }

    //     $partner_model = PartnerRegistration::findOne(['user_id' => Yii::$app->user->id]);
    //     $model = $partner_model ? new PartnerRegistrationForm($partner_model) : new PartnerRegistrationForm();
    //     $step = Yii::$app->request->post('step', $model->partner_model->current_step ?: 1);
    //     $model->setScenario('step' . $step);
    //     $model->user_id = Yii::$app->user->id;
    //     $gst_model = new PartnerGstDetails();
    //     if ($model->scenario == PartnerRegistrationForm::SCENARIO_STEP3) {
    //         if (Yii::$app->request->isPost) {
    //             if ($model->load(Yii::$app->request->post()) && $gst_model->load(Yii::$app->request->post())) {
    //                 $gst_model->uploadFiles();
    //                 if ($model->validate() && $gst_model->validate()) {
    //                     $model->initializeForm();
    //                     $model->partner_model->loadDefaultValues();
    //                     $model->partner_model->gst_id = $gst_model->id;
    //                     $model->partner_model->current_step = $step;
    //                     $model->partner_model->{'form' . $step . '_status'} = 1;
    //                     if ($model->partner_model->save(false) && $gst_model->save(false)) {
    //                         $step++;
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     if (Yii::$app->request->isPost) {
    //         if ($model->load(Yii::$app->request->post())) {
    //             if (Yii::$app->request->post('same_as_previous')) {
    //                 if ($model->pan_number) {
    //                     $model->kyc_pan = $model->pan_number;
    //                 }
    //                 if ($model->pan_upload) {
    //                     $model->kyc_pan_upload = $model->pan_upload;
    //                 }
    //             }
    //             $model->uploadFiles();
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 $model->partner_model->loadDefaultValues();
    //                 $model->partner_model->current_step = $step;
    //                 $model->partner_model->{'form' . $step . '_status'} = 1;
    //                 if ($model->partner_model->save(false)) {
    //                     $step++;
    //                 }
    //             }
    //         }
    //     }

    //     return $this->render('card', [
    //         'model' => $model,
    //         'partner_model' => $partner_model,
    //         'currentStep' => $step,
    //         'readOnly' => false,
    //         'gst_model' => $gst_model
    //     ]);
    // }


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
        // if ($partner_model && $partner_model->is_step_1_approved != 1) {
        //     $model->is_step_1_approved = 0;
        // }

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
        $model->current_step = 3;

        $model->form2_status = 1;
        // if ($partner_model->is_step_2_approved != 1) {
        //     $model->is_step_2_approved = 0;
        // }


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
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
        $model->setScenario(PartnerRegistrationForm::SCENARIO_STEP2);
        $model->current_step = 4;

        $model->form3_status = 1;
        // if ($partner_model->is_step_2_approved != 1) {
        //     $model->is_step_2_approved = 0;
        // }
        $gst_model = new PartnerGstDetails();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->partner_model->save(false)) {
                        $gst_model->uploadFiles();
                        return $this->redirect(['step-4']);
                    }
                }
            }
        } else {
            $model->partner_model->loadDefaultValues();
        }

        return $this->render('businessdetails', [
            'model' => $model,
            'partner_model' => $partner_model,
            'currentStep' => 3,
            'gst_model' => $gst_model,
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
