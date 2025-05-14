<?php

namespace backend\modules\operatorapproval\controllers;

use api\models\User;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorPark;
use common\models\operatorregistration\OperatorRegistration;
use common\models\operatorregistration\OperatorRegistrationSearch;
use common\models\partnerregistration\form\PartnerRegistrationForm;
use common\models\partnerregistration\PartnerRegistration;
use common\models\partnerregistration\PartnerRegistrationSearch;
use PHPUnit\Framework\Constraint\Operator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PartnerRegistrationSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        // $model = $this->findModel($id);
        $partner_model = $this->findModel($id);

        $model = new PartnerRegistrationForm($partner_model);

        return $this->render('update', [
            'model' => $model,
            'partner_model' => $partner_model,
        ]);
    }

    // public function actionStepApproved($id, $step)
    // {
    //     $model = $this->findModel($id);
    //     if ($step == 1) {
    //         $model->is_step_1_approved = 1;
    //         $model->updated_time_step_1 = date('Y-m-d H:i:s');
    //     } else if ($step == 2) {
    //         $model->is_step_2_approved = 1;
    //         $model->updated_time_step_2 = date('Y-m-d H:i:s');
    //     } else if ($step == 3) {
    //         $model->is_step_3_approved = 1;
    //         $model->updated_time_step_3 = date('Y-m-d H:i:s');
    //     } else if ($step == 4) {
    //         $model->is_step_4_approved = 1;
    //         $model->updated_time_step_4 = date('Y-m-d H:i:s');
    //     }
    //     if ($model->save(false)) {
    //         \Yii::$app->session->setFlash('success', 'Approved Successfully');
    //         return $this->redirect(['update', 'id' => $model->id]);
    //     }
    // }

    public function actionStepApproved($id, $step)
    {
        $model = $this->findModel($id);
        if ($step == 1) {
            $model->form1_status = PartnerRegistration::FORM_APPROVED;
            $model->updated_time_form_1 = date('Y-m-d H:i:s');
        } else if ($step == 2) {
            $model->form2_status = PartnerRegistration::FORM_APPROVED;
            $model->updated_time_form_2 = date('Y-m-d H:i:s');
        } else if ($step == 3) {
            $model->form3_status = PartnerRegistration::FORM_APPROVED;
            $model->updated_time_form_3 = date('Y-m-d H:i:s');
        } else if ($step == 4) {
            $model->form4_status = PartnerRegistration::FORM_APPROVED;
            $model->updated_time_form_4 = date('Y-m-d H:i:s');
        } else if ($step == 5) {
            $model->form5_status = PartnerRegistration::FORM_APPROVED;
            $model->updated_time_form_5 = date('Y-m-d H:i:s');
        }
        if ($model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Approved Successfully');
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }

    public function actionStepReject($id, $step)
    {
        $model = $this->findModel($id);
        $model->is_sendforapproval = 0;
        if ($step == 1) {
            $model->form1_status = PartnerRegistration::FORM_REJECTED;
            // $model->is_step_1_submit = 0;
            $model->updated_time_form_1 = date('Y-m-d H:i:s');
        } else if ($step == 2) {
            $model->form2_status = PartnerRegistration::FORM_REJECTED;
            // $model->is_step_2_submit = 0;
            $model->updated_time_form_2 = date('Y-m-d H:i:s');
        } else if ($step == 3) {
            $model->form3_status = PartnerRegistration::FORM_REJECTED;
            // $model->is_step_3_submit = 0;
            $model->updated_time_form_3 = date('Y-m-d H:i:s');
        } else if ($step == 4) {
            $model->form4_status = PartnerRegistration::FORM_REJECTED;
            // $model->is_step_4_submit = 0;
            $model->updated_time_form_4 = date('Y-m-d H:i:s');
        } else if ($step == 5) {
            $model->form5_status = PartnerRegistration::FORM_REJECTED;
            // $model->is_step_4_submit = 0;
            $model->updated_time_form_5 = date('Y-m-d H:i:s');
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $reason = $model->reason;
                // if ($model->validate()) {
                if ($reason) {
                    if ($step == 1) {
                        $model->form1_reject_reason = $reason;
                    } else if ($step == 2) {
                        $model->form2_reject_reason = $reason;
                    } else if ($step == 3) {
                        $model->form3_reject_reason = $reason;
                    } else if ($step == 4) {
                        $model->form4_reject_reason = $reason;
                    } else if ($step == 5) {
                        $model->form5_reject_reason = $reason;
                    }
                    if ($model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Reject Successfully');
                        return $this->redirect(['update', 'id' => $model->id]);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->renderAjax('_reject_reason', [
            'model' => $model,
        ]);
    }

    // public function actionStepReject($id, $step)
    // {
    //     $model = $this->findModel($id);
    //     if ($step == 1) {
    //         $model->is_step_1_approved = 2;
    //         $model->is_step_1_submit = 0;
    //         $model->updated_time_step_1 = date('Y-m-d H:i:s');
    //     } else if ($step == 2) {
    //         $model->is_step_2_approved = 2;
    //         $model->is_step_2_submit = 0;
    //         $model->updated_time_step_2 = date('Y-m-d H:i:s');
    //     } else if ($step == 3) {
    //         $model->is_step_3_approved = 2;
    //         $model->is_step_3_submit = 0;
    //         $model->updated_time_step_3 = date('Y-m-d H:i:s');
    //     } else if ($step == 4) {
    //         $model->is_step_4_approved = 2;
    //         $model->is_step_4_submit = 0;
    //         $model->updated_time_step_4 = date('Y-m-d H:i:s');
    //     }

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             $reason = $model->reason;
    //             if ($model->validate()) {
    //                 if ($step == 1) {
    //                     $model->step_1_reject_reason = $reason;
    //                 } else if ($step == 2) {
    //                     $model->step_2_reject_reason = $reason;
    //                 } else if ($step == 3) {
    //                     $model->step_3_reject_reason = $reason;
    //                 } else if ($step == 4) {
    //                     $model->step_4_reject_reason = $reason;
    //                 }
    //                 if ($model->save(false)) {
    //                     \Yii::$app->session->setFlash('success', 'Reject Successfully');
    //                     return $this->redirect(['update', 'id' => $model->id]);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }
    //     return $this->renderAjax('_reject_reason', [
    //         'model' => $model,
    //     ]);
    // }

    // public function makeoperator($model)
    // {
    //     $safari_operator_model = new SafariOperator();
    //     $safari_operator_model->operator_name = $model->name;
    //     $safari_operator_model->operator_email = $model->email;
    //     $safari_operator_model->operator_phone_no = $model->phone_no;
    //     $safari_operator_model->user_id = $model->user_id;
    //     $safari_operator_model->is_approved = 1;
    //     $safari_operator_model->safari_operator_request_id = $model->id;
    //     $safari_operator_model->category_id = 2;
    //     $safari_operator_model->business_name = $model->business_registration_name;
    //     $safari_operator_model->register_comapany_name = $model->business_registration_name;
    //     $safari_operator_model->is_highlighted = 0;
    //     $safari_operator_model->google_rating = 0;
    //     $safari_operator_model->google_review_count = 0;
    //     $safari_operator_model->facebook_url = null;
    //     $safari_operator_model->instagram_url = null;
    //     $safari_operator_model->youtube_link = null;
    //     $safari_operator_model->phone_no = $model->phone_no;
    //     $safari_operator_model->email = $model->email;
    //     $safari_operator_model->website = null;
    //     $safari_operator_model->is_register_company = 0;
    //     $safari_operator_model->has_a_website = 0;
    //     $safari_operator_model->has_cancellation_policy = 0;
    //     $safari_operator_model->wildlife_photographer = 0;
    //     $safari_operator_model->wildlife_influencer = 0;
    //     $safari_operator_model->is_offer_premium_budget = 1;
    //     $safari_operator_model->is_offer_standard_budget = 0;
    //     $safari_operator_model->is_offer_economical_budget = 0;
    //     $safari_operator_model->is_wildlife_trekking = 0;
    //     $safari_operator_model->is_wildlife_non_safari_drive = 0;
    //     $safari_operator_model->is_bird_watching = 0;
    //     $safari_operator_model->is_camping = 0;
    //     $safari_operator_model->starting_price = 2000;
    //     $safari_operator_model->is_approved = 1;
    //     if ($safari_operator_model->save(false)) {
    //         return true;
    //     }
    // }
    public function makeoperator($model)
    {
        $safari_operator_model = new SafariOperator();
        $safari_operator_model->operator_name = $model->legal_entity_name;
        $safari_operator_model->operator_email = $model->legal_entity_email;
        $safari_operator_model->operator_phone_no = $model->legal_entity_phone;
        $safari_operator_model->user_id = $model->user_id;
        $safari_operator_model->is_approved = 1;
        $safari_operator_model->safari_operator_request_id = $model->id;
        $safari_operator_model->category_id = 1;
        $safari_operator_model->business_name = $model->brand_name;
        $safari_operator_model->register_comapany_name = $model->brand_name;
        $safari_operator_model->address = $model->address;
        $safari_operator_model->gst = $model->gst_id;
        $safari_operator_model->logo = $model->logo;
        $safari_operator_model->about_business = $model->about_business;
        $safari_operator_model->is_highlighted = 0;
        $safari_operator_model->google_rating = 0;
        $safari_operator_model->google_review_count = 0;
        $safari_operator_model->facebook_url = null;
        $safari_operator_model->instagram_url = null;
        $safari_operator_model->youtube_link = null;
        $safari_operator_model->phone_no = null;
        $safari_operator_model->email = $model->user->email;
        $safari_operator_model->website = null;
        $safari_operator_model->is_register_company = 0;
        $safari_operator_model->has_a_website = 0;
        $safari_operator_model->has_cancellation_policy = 0;
        $safari_operator_model->wildlife_photographer = 0;
        $safari_operator_model->wildlife_influencer = 0;
        $safari_operator_model->is_offer_premium_budget = 0;
        $safari_operator_model->is_offer_standard_budget = 0;
        $safari_operator_model->is_offer_economical_budget = 0;
        $safari_operator_model->is_wildlife_trekking = 0;
        $safari_operator_model->is_wildlife_non_safari_drive = 0;
        $safari_operator_model->is_bird_watching = 0;
        $safari_operator_model->is_camping = 0;
        $safari_operator_model->starting_price = 0;
        $safari_operator_model->is_approved = 1;

        $safari_operator_model->legal_entity_type  = $model->legal_entity_type;
        $safari_operator_model->legal_entity_whatsapp  = $model->legal_entity_whatsapp;
        $safari_operator_model->registration_number  = $model->registration_number;
        $safari_operator_model->registration_copy_upload  = $model->registration_copy_upload;
        $safari_operator_model->pan_number  = $model->pan_number;
        $safari_operator_model->pan_upload  = $model->pan_upload;
        $safari_operator_model->operated_park  = $model->operated_park;
        $safari_operator_model->billing_mail  = $model->billing_mail;
        $safari_operator_model->billing_phone  = $model->billing_phone;
        $safari_operator_model->bank_name  = $model->bank_name;
        $safari_operator_model->account_holder_name  = $model->account_holder_name;
        $safari_operator_model->account_number = $model->account_number;
        $safari_operator_model->ifsc_number  = $model->ifsc_number;
        $safari_operator_model->cancel_check_upload  = $model->cancel_check_upload;
        $safari_operator_model->owner_name  = $model->owner_name;
        $safari_operator_model->kyc_phone  = $model->kyc_phone;
        $safari_operator_model->kyc_whatsapp = $model->kyc_whatsapp;
        $safari_operator_model->kyc_email = $model->kyc_email;
        $safari_operator_model->kyc_pan = $model->kyc_pan;
        $safari_operator_model->kyc_pan_upload = $model->kyc_pan_upload;
        $safari_operator_model->aadhar_number = $model->aadhar_number;
        $safari_operator_model->aadhar_front_upload = $model->aadhar_front_upload;
        $safari_operator_model->aadhar_back_upload = $model->aadhar_back_upload;

        $safari_operator_model->status = SafariOperator :: STATUS_ACTIVE;
        
        if ($safari_operator_model->save(false)) {
            return true;
        }
    }

    public function approvedparks($model)
    {
        if (!empty($model->parkList)) {
            foreach ($model->parkList as $park_field) {
                $operator_park = new SafariOperatorPark();
                $operator_park->safari_operator_id = $park_field['partner_registration_id']; 
                $operator_park->park_id = $park_field['park_id'];
                $operator_park->status = $park_field['status'];
                if (!$operator_park->save(false)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    protected function findModel($id)
    {
        if (($model = PartnerRegistration::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFinalApproved($id)
    {
        $model = $this->findModel($id);

        if (($model->final_approved != 1) && ($model->form1_status == PartnerRegistration::FORM_APPROVED) && ($model->form2_status == PartnerRegistration::FORM_APPROVED) && ($model->form3_status == PartnerRegistration::FORM_APPROVED) && ($model->form4_status == PartnerRegistration::FORM_APPROVED) && ($model->form5_status == PartnerRegistration::FORM_APPROVED)) {
            $model->final_approved = 1;
            $model->updated_time_final_approved = date('Y-m-d H:i:s');
            if ($model->save(false)) {
                $this->makeoperator($model);
                $this->approvedparks($model);
                $model_user = User::findOne(['id' => $model->user_id]);
                $model_user->is_safari_operator = 1;
                $model_user->save(false);
                \Yii::$app->session->setFlash('success', 'Final Approved Successfully');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            \Yii::$app->session->setFlash('danger', 'Reject Finally');
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }
}
