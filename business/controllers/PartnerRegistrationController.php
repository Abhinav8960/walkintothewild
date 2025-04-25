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
        $step = Yii::$app->request->post('step', $model->partner_model->current_step ?: 1);
        $model->setScenario('step' . $step);
        $model->user_id = Yii::$app->user->id;
        $gst_model = new PartnerGstDetails();
        if($model->scenario == PartnerRegistrationForm :: SCENARIO_STEP3){
            if (Yii::$app->request->isPost) {
                if ($model->load(Yii::$app->request->post()) && $gst_model->load(Yii::$app->request->post())) {
                    $gst_model->uploadFiles();
                    if ($model->validate() && $gst_model->validate()) {
                        $model->initializeForm();
                        $model->partner_model->loadDefaultValues();
                        $model->partner_model->gst_id = $gst_model->id;
                        $model->partner_model->current_step = $step;
                        $model->partner_model->{'form' . $step . '_status'} = 1;
                        if ($model->partner_model->save(false) && $gst_model->save(false)) {
                            $step++;
                        }
                    }
                }
            }
        }

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
                $model->uploadFiles();
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

        return $this->render('card', [
            'model' => $model,
            'partner_model' => $partner_model,
            'currentStep' => $step,
            'readOnly' => false,
            'gst_model'=>$gst_model
        ]);
    }


}
