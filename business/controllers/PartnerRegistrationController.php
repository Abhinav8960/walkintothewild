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
    
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
    
        $partner_model = PartnerRegistration::findOne(['user_id' => Yii::$app->user->id]);
        $model = $partner_model ? new PartnerRegistrationForm($partner_model) : new PartnerRegistrationForm();
        $model->user_id = Yii::$app->user->id;
    
        $gst_model = new PartnerGstDetails(); // Always create GST model
        $step = Yii::$app->request->post('step', $model->partner_model->current_step ?: 1);
    
        $model->setScenario('step' . $step);
    
        if (Yii::$app->request->isPost) {
            $isModelLoaded = $model->load(Yii::$app->request->post());
            $isGstLoaded = $gst_model->load(Yii::$app->request->post());
    
            if ($isModelLoaded) {
    
                if (Yii::$app->request->post('same_as_previous')) {
                    if ($model->pan_number) {
                        $model->kyc_pan = $model->pan_number;
                    }
                    if ($model->pan_upload) {
                        $model->kyc_pan_upload = $model->pan_upload;
                    }
                }
    
                $model->uploadFiles(); 
    
                if ($model->scenario == PartnerRegistrationForm::SCENARIO_STEP3 && $isGstLoaded) {
                    $gst_model->uploadFiles(); 
                    if ($model->validate() && $gst_model->validate()) {
    
                        $gst_model->save(false);
    
                        $model->initializeForm();
                        $model->partner_model->loadDefaultValues();
                        $model->partner_model->gst_id = $gst_model->id; 
                        $model->partner_model->current_step = $step;
                        $model->partner_model->{'form' . $step . '_status'} = 1;
    
                        if ($model->partner_model->save(false)) {
                            $step++;
                        }
                    }
                } else {
                    if ($model->validate()) {
                        $model->initializeForm();
                        $model->partner_model->loadDefaultValues();
                        $model->partner_model->current_step = $step;
                        $model->partner_model->{'form' . $step . '_status'} = 1;
    
                        if ($model->partner_model->save(false)) {
                            $step++;
                        }
                    }
                }
            }
        }
    
        return $this->render('card', [
            'model' => $model,
            'partner_model' => $partner_model,
            'currentStep' => $step,
            'readOnly' => false,
            'gst_model' => $gst_model,
        ]);
    }
    

    // public function actionSendForApproval()
    // {
    //     $model = PartnerRegistration::findOne(['user_id' => Yii::$app->user->id]);
    // if ($model !== null) {
    //     if($model->form1_status = 2 && $model->form2_status = 2 && $model->form3_status = 2 && $model->form4_status = 2 && $model->form5_status = 2); 
    //     $model->is_sendforapproval = 1 ;
    //     if ($model->save(false)) {
    //         Yii::$app->session->setFlash('success', 'Request sent for approval.');
    //     } else {
    //         Yii::$app->session->setFlash('error', 'Failed to send approval request.');
    //     }
    // } else {
    //     throw new NotFoundHttpException('Partner not found.');
    // }

    // return $this->redirect(['partner-registration/create']); 
    // }

}
