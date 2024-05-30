<?php

namespace backend\modules\registration\controllers;

use backend\modules\registration\model\SafariOperatorTourApprovalForm;
use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorPark;
use common\models\registration\form\SafaritourRegistrationForm;
use common\models\User;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;
use common\models\SafariOperatorRequestSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * SafariOperatorTourController.
 */
class SafariOperatorTourController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new SafariOperatorRequestSearch();
        $searchModel->is_approved = 0;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id = null)
    {
        $safarioperator_request_model = $this->findModel($id);


        $model = new SafariOperatorTourApprovalForm($safarioperator_request_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safarioperator_request_approval_model->save()) {
                        if ($model->is_approved == 1) {
                            $old_safari_operator = SafariOperator::find()->where(['safari_operator_request_id' => $model->safarioperator_request_approval_model->id, 'status' => 1])->limit(1)->one();
                            if (!$old_safari_operator) {
                                $new_safari_operator = new SafariOperator();
                                $safari_operator = $new_safari_operator;
                            } else {
                                $safari_operator = $old_safari_operator;
                            }
                            $safari_operator->category_id                     =  $model->safarioperator_request_approval_model->category_id;
                            $safari_operator->safari_operator_request_id      =  $model->safarioperator_request_approval_model->id;
                            $safari_operator->business_name                   =  $model->safarioperator_request_approval_model->business_name;
                            $safari_operator->register_comapany_name          =  $model->safarioperator_request_approval_model->register_comapany_name;
                            $safari_operator->address                         =  $model->safarioperator_request_approval_model->address;
                            $safari_operator->gst                             =  $model->safarioperator_request_approval_model->gst;
                            $safari_operator->logo                            =  $model->safarioperator_request_approval_model->logo;
                            $safari_operator->is_highlighted                  =  $model->safarioperator_request_approval_model->is_highlighted;
                            $safari_operator->google_rating                   =  $model->safarioperator_request_approval_model->google_rating;
                            $safari_operator->google_review_count             =  $model->safarioperator_request_approval_model->google_review_count;
                            $safari_operator->google_business_url             =  $model->safarioperator_request_approval_model->google_business_url;
                            $safari_operator->google_business_name            =  $model->safarioperator_request_approval_model->google_business_name;
                            $safari_operator->about_business                  =  $model->safarioperator_request_approval_model->about_business;
                            $safari_operator->facebook_url                    =  $model->safarioperator_request_approval_model->facebook_url;
                            $safari_operator->instagram_url                   =  $model->safarioperator_request_approval_model->instagram_url;
                            $safari_operator->youtube_link                    =  $model->safarioperator_request_approval_model->youtube_link;
                            $safari_operator->phone_no                        =  $model->safarioperator_request_approval_model->phone_no;
                            $safari_operator->email                           =  $model->safarioperator_request_approval_model->email;
                            $safari_operator->website                         =  $model->safarioperator_request_approval_model->website;
                            $safari_operator->is_register_company             =  $model->safarioperator_request_approval_model->is_register_company;
                            $safari_operator->has_a_website                   =  $model->safarioperator_request_approval_model->has_a_website;
                            $safari_operator->has_cancellation_policy         =  $model->safarioperator_request_approval_model->has_cancellation_policy;
                            $safari_operator->wildlife_photographer           =  $model->safarioperator_request_approval_model->wildlife_photographer;
                            $safari_operator->wildlife_influencer             =  $model->safarioperator_request_approval_model->wildlife_influencer;
                            $safari_operator->is_offer_premium_budget         =  $model->safarioperator_request_approval_model->is_offer_premium_budget;
                            $safari_operator->is_offer_standard_budget        =  $model->safarioperator_request_approval_model->is_offer_standard_budget;
                            $safari_operator->is_offer_economical_budget      =  $model->safarioperator_request_approval_model->is_offer_economical_budget;
                            $safari_operator->starting_price                  =  $model->safarioperator_request_approval_model->starting_price;
                            $safari_operator->is_approved                     =  $model->safarioperator_request_approval_model->is_approved;
                            $safari_operator->operator_name                   =  $model->safarioperator_request_approval_model->operator_name;
                            $safari_operator->operator_phone_no               =  $model->safarioperator_request_approval_model->operator_phone_no;
                            $safari_operator->operator_email                  =  $model->safarioperator_request_approval_model->operator_email;
                            $safari_operator->is_highlighted                  =  $model->safarioperator_request_approval_model->is_highlighted;
                            $safari_operator->status                          =  $model->safarioperator_request_approval_model->status;
                            if ($safari_operator->save(false)) {

                                $parks = SafariOperatorRequestPark::find()->where(['safari_operator_request_id' => $model->safarioperator_request_approval_model->id, 'status' => 1])->all();

                                if ($parks) {
                                    SafariOperatorPark::updateAll(['status' => 2], ['safari_operator_id' => $safari_operator->id]);
                                    foreach ($parks as $park) {
                                        $safarioperatorpark = new SafariOperatorPark();
                                        $safarioperatorpark->safari_operator_id = $safari_operator->id;
                                        $safarioperatorpark->park_id = $park->park_id;
                                        $safarioperatorpark->save(false);
                                    }
                                }

                                $activities = SafariOperatorRequestActivities::find()->where(['safari_operator_request_id' => $model->safarioperator_request_approval_model->id, 'status' => 1])->all();
                                if ($activities) {
                                    SafariOperatorActivities::updateAll(['status' => 2], ['safari_operator_id' => $safari_operator->id]);
                                    foreach ($activities as $activity) {
                                        $safarioperatorrequestactivities = new SafariOperatorActivities();
                                        $safarioperatorrequestactivities->safari_operator_id = $safari_operator->id;
                                        $safarioperatorrequestactivities->wildlife_activity_id = $activity->wildlife_activity_id;
                                        $safarioperatorrequestactivities->save(false);
                                    }
                                }

                                if (!$old_safari_operator) {
                                    $user = new User();
                                    $user->username = $safari_operator->email;
                                    $user->generateAuthKey();
                                    $user->generateEmailVerificationToken();
                                    $user->email = $safari_operator->email;
                                    $user->mobile_no = $safari_operator->phone_no;
                                    $user->name = $safari_operator->business_name;
                                    $user->setPassword($safari_operator->phone_no);
                                    $user->is_safari_operator = 1;
                                    $user->status = 10;
                                    // $user->setUpd($model->phone);

                                    if ($user->save(false)) {
                                        $safari_operator->user_id = $user->id;
                                        $safari_operator->save(false);
                                        if ($user->save(false)) {
                                            \Yii::$app->session->setFlash('success', 'Operator Approved Successfully');
                                            return $this->redirect(['index']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $model->safarioperator_request_approval_model->loadDefaultValues();
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new SafaritourRegistrationForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->action_url = '/registration/safari-operator-tour/create';
        $model->action_validate_url = '/registration/safari-operator-tour/validate';

        $model->referrer_url = \Yii::$app->request->referrer;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safarioperator_request_model->save(false)) {
                        $model->uploadFile();
                        $parks = $model->park_id;
                        if ($parks) {
                            foreach ($parks as $park) {
                                $safarioperatorrequestpark = new SafariOperatorRequestPark();
                                $safarioperatorrequestpark->safari_operator_request_id = $model->safarioperator_request_model->id;
                                $safarioperatorrequestpark->park_id = $park;
                                $safarioperatorrequestpark->save(false);
                            }
                        }


                        $activities = $model->offers_other_wildlifeactivities;
                        if ($activities) {
                            foreach ($activities as $activity) {
                                $safarioperatorrequestactivity = new SafariOperatorRequestActivities();
                                $safarioperatorrequestactivity->safari_operator_request_id = $model->safarioperator_request_model->id;
                                $safarioperatorrequestactivity->wildlife_activity_id = $activity;
                                $safarioperatorrequestactivity->save(false);
                            }
                        }

                        $to_mail = $model->safarioperator_request_model->email;
                        // $subject = 'Welcome to ' . $model->safarioperator_request_model->business_name . ' – Your Registration is Successful!';
                        $subject = 'Safari Tour Operator Submission Received: Let`s Walk into the Wild!';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_REGISTRATION;
                        $req = ['username' => $model->safarioperator_request_model->business_name];

                        MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        //$model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safarioperator_request_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    public function actionUpdate($id)
    {
        $request_model = $this->findModel($id);
        // echo '<pre>';
        // print_r($request_model);
        // die();
        $model = new SafaritourRegistrationForm($request_model);
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->action_url = '/registration/safari-operator-tour/update?id=' . $id . '';
        $model->action_validate_url = '/registration/safari-operator-tour/validate?id=' . $id . '';

        $model->referrer_url = \Yii::$app->request->referrer;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safarioperator_request_model->save(false)) {
                        $model->uploadFile();
                        $parks = $model->park_id;
                        if ($parks) {
                            SafariOperatorRequestPark::updateAll(['status' => 2], ['safari_operator_request_id' => $model->safarioperator_request_model->id]);
                            foreach ($parks as $park) {
                                $safarioperatorrequestpark = new SafariOperatorRequestPark();
                                $safarioperatorrequestpark->safari_operator_request_id = $model->safarioperator_request_model->id;
                                $safarioperatorrequestpark->park_id = $park;
                                $safarioperatorrequestpark->save(false);
                            }
                        }


                        $activities = $model->offers_other_wildlifeactivities;
                        if ($activities) {
                            SafariOperatorRequestActivities::updateAll(['status' => 2], ['safari_operator_request_id' => $model->safarioperator_request_model->id]);
                            foreach ($activities as $activity) {
                                $safarioperatorrequestactivity = new SafariOperatorRequestActivities();
                                $safarioperatorrequestactivity->safari_operator_request_id = $model->safarioperator_request_model->id;
                                $safarioperatorrequestactivity->wildlife_activity_id = $activity;
                                $safarioperatorrequestactivity->save(false);
                            }
                        }

                        $to_mail = $model->safarioperator_request_model->email;
                        // $subject = 'Welcome to ' . $model->safarioperator_request_model->business_name . ' – Your Registration is Successful!';
                        $subject = 'Safari Tour Operator Submission Received: Let`s Walk into the Wild!';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_REGISTRATION;
                        $req = ['username' => $model->safarioperator_request_model->business_name];

                        MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        //$model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Safari Operator Added Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safarioperator_request_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidate($id = null)
    {
        $model = new SafaritourRegistrationForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new SafaritourRegistrationForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Suspend Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->business_name = $model->id . '_' . $model->business_name;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterAnimal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterAnimal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SafariOperatorRequest::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
