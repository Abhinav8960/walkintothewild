<?php

namespace backend\modules\operator\controllers;

use common\interfaces\NewStatusInterface;
use common\models\Auth;
use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\MailLog;
use common\models\operator\form\SafariOperatorDeleteForm;
use common\models\operator\form\SafariOperatorForm;
use common\models\operator\form\SafariOperatorLogoForm;
use common\models\operator\form\SafariOperatorParkForm;
use common\models\operator\form\SafariOperatorRequestForm;
use common\models\operator\form\SafariOperatorUpdateForm;
use common\models\operator\OperatorQuoteSearch;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorActivities;
use common\models\operator\SafariOperatorFollowSearch;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorRatingReportSearch;
use common\models\operator\SafariOperatorRatingSearch;
use common\models\operator\SafariOperatorSearch;
use common\models\package\Package;
use common\models\partnerregistration\PartnerRegistration;
use common\models\registration\SafariOperatorRequest;
use common\models\registration\SafariOperatorRequestActivities;
use common\models\registration\SafariOperatorRequestPark;
use common\models\SafariOperatorRequestSearch;
use common\models\sharesafari\ShareSafari;
use common\models\sighting\Sighting;
use common\models\User;
use common\models\UserFollow;
use yii\data\ActiveDataProvider;

/**
 * SafariOperatorController.
 */
class SafariOperatorController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariOperatorSearch();
        // $searchModel->report_days = 'today';
        // $searchModel->status = [SafariOperator::STATUS_ACTIVE, NewStatusInterface::STATUS_BLOCKED];
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere(['IN', 'status', [SafariOperator::STATUS_ACTIVE, NewStatusInterface::STATUS_BLOCKED]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View Operator
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * View Partner Registration DetailsBank
     */
    public function actionBankAndKycDetails($id)
    {
        $model = $this->findModel($id);

        return $this->render('bank_kyc_details', ['model' => $model]);
    }


    /**
     * View Operator
     */
    public function actionQuote($id)
    {
        $model = $this->findModel($id);
        $searchModel = new OperatorQuoteSearch();
        $searchModel->operator_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('free_quote', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View Operator
     */
    // public function actionSharedsafari($id)
    // {
    //     $model = $this->findModel($id);
    //     return $this->render('shared_safari', ['model' => $model]);
    // }

    /**
     * View Operator
     */
    public function actionReview($id)
    {
        $model = $this->findModel($id);

        $searchModel = new SafariOperatorRatingSearch();
        $searchModel->safari_operator_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('user_review', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * View Operator
     */
    public function actionFlagview($id, $safari_operator_id)
    {

        $searchModel = new SafariOperatorRatingReportSearch();
        $searchModel->safari_operator_rating_id = $id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = $this->findModel($safari_operator_id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('flag_review', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
    }
    /**
     * View Operator
     */
    public function actionFollower($id)
    {
        $operator = SafariOperator::find()->where(['id' => $id])->limit(1)->one();
        $follow_query = $operator->getFollowerlist()->joinWith('user')->where(['user_follower.status' => 1, 'user.status' => User::STATUS_ACTIVE]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $follow_query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $model = $this->findModel($id);
        return $this->render('follower', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
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
        $model->status = SafariOperator::STATUS_SUSPEND;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = SafariOperator::STATUS_ACTIVE;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = SafariOperator::findOne(['id' => $id, 'status' => [SafariOperator::STATUS_ACTIVE, SafariOperator::STATUS_SUSPEND, NewStatusInterface::STATUS_BLOCKED]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // public function actionUpdate($id)
    // {
    //     $safarioperator_model = $this->findModel($id);
    //     $model = new SafariOperatorForm($safarioperator_model);
    //     $model->status = SafariOperator::STATUS_ACTIVE;
    //     $model->action_url = '/operator/safari-operator/update?id=' . $id . '';
    //     $model->action_validate_url = '/operator/safari-operator/validate?id=' . $id . '';

    //     $model->referrer_url = \Yii::$app->request->referrer;

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             $model->logo = UploadedFile::getInstance($model, 'logo');
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->safarioperator_model->save(false)) {
    //                     $model->uploadFile();
    //                     $parks = $model->park_id;
    //                     if ($parks) {
    //                         SafariOperatorPark::updateAll(['status' => SafariOperatorPark::STATUS_SUSPEND], ['safari_operator_id' => $model->safarioperator_model->id]);
    //                         foreach ($parks as $park) {
    //                             $safarioperatorpark = new SafariOperatorPark();
    //                             $safarioperatorpark->safari_operator_id = $model->safarioperator_model->id;
    //                             $safarioperatorpark->park_id = $park;
    //                             $safarioperatorpark->save(false);
    //                         }
    //                     }
    //                     $activities = $model->offers_other_wildlifeactivities;
    //                     if ($activities) {
    //                         SafariOperatorActivities::updateAll(['status' => SafariOperatorActivities::STATUS_SUSPEND], ['safari_operator_id' => $model->safarioperator_model->id]);
    //                         foreach ($activities as $activity) {
    //                             $safarioperatoractivity = new SafariOperatorActivities();
    //                             $safarioperatoractivity->safari_operator_id = $model->safarioperator_model->id;
    //                             $safarioperatoractivity->wildlife_activity_id = $activity;
    //                             $safarioperatoractivity->save(false);
    //                         }
    //                     }

    //                     $to_mail = $model->safarioperator_model->email;
    //                     $subject = 'Safari Tour Operator Submission Received: Let`s Walk into the Wild!';
    //                     $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_REGISTRATION;
    //                     $req = ['username' => $model->safarioperator_model->business_name];

    //                     MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //                     \Yii::$app->session->setFlash('success', 'Safari Operator Update Successfully');
    //                     return $this->redirect(['index']);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->safarioperator_model->loadDefaultValues();
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }


    // public function actionUpdate($id)
    // {
    //     $safari_operator = $this->findModel($id);
    //     $safari_operator_id = $safari_operator->id;

    //     $searchModel = new SafariOperatorRequestSearch();
    //     $searchModel->safari_operator_id = $safari_operator_id;
    //     $searchModel->user_id = $safari_operator->user_id;
    //     $dataProvider = $searchModel->search($this->request->queryParams);

    //     $safari_operator_model = SafariOperator::find()->where(['id' => $safari_operator_id])->limit(1)->one();
    //     $model = new SafariOperatorRequestForm($safari_operator_model);
    //     $model->user_id = $safari_operator->user_id;
    //     $model->status = SafariOperator::STATUS_ACTIVE;
    //     $model->action_url = '/operator/safari-operator/update?id=' . $id . '';
    //     $model->action_validate_url = '/operator/safari-operator/validate?id=' . $id . '';
    //     $model->referrer_url = \Yii::$app->request->referrer;

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             $model->logo = UploadedFile::getInstance($model, 'logo');
    //             if ($model->validate()) {
    //                 $model->initializeForm();

    //                 // Revome All Previouse Request if ANy Pending for Approval
    //                 SafariOperatorRequest::updateAll(['status' => NewStatusInterface::STATUS_DELETE], ['safari_operator_id' => $safari_operator_model->id, 'status' => 1, 'is_approved' => 0]);

    //                 if ($model->safari_operator_request_model->save(false)) {
    //                     $model->uploadFile();
    //                     $parks = $model->park_id;
    //                     SafariOperatorRequestPark::updateAll(['status' => 0], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
    //                     if ($parks) {
    //                         foreach ($parks as $park) {
    //                             $safarioperatorrequestpark = new SafariOperatorRequestPark();
    //                             $safarioperatorrequestpark->safari_operator_request_id = $model->safari_operator_request_model->id;
    //                             $safarioperatorrequestpark->park_id = $park;
    //                             $safarioperatorrequestpark->save(false);
    //                         }
    //                     }


    //                     $activities = $model->offers_other_wildlifeactivities;
    //                     SafariOperatorRequestActivities::updateAll(['status' => 0], ['safari_operator_request_id' => $model->safari_operator_request_model->id]);
    //                     if ($activities) {
    //                         foreach ($activities as $activity) {
    //                             $safarioperatorrequestactivity = new SafariOperatorRequestActivities();
    //                             $safarioperatorrequestactivity->safari_operator_request_id = $model->safari_operator_request_model->id;
    //                             $safarioperatorrequestactivity->wildlife_activity_id = $activity;
    //                             $safarioperatorrequestactivity->save(false);
    //                         }
    //                     }
    //                     $model->safari_operator_request_model->is_approved = 1;
    //                     if ($model->safari_operator_request_model->save(false)) {
    //                         $safari_operator = $model->safari_operator_request_model->safariapproved($model->safari_operator_request_model);
    //                         if ($safari_operator) {
    //                             \Yii::$app->session->setFlash('success', 'Safari Update Successfully');
    //                             return $this->redirect(['index']);
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->safari_operator_request_model->loadDefaultValues();
    //     }

    //     return $this->render('update_new', [
    //         'model' => $model,
    //     ]);
    // }



    // public function actionValidate($id)
    // {
    //     $formmodel = $this->findModel($id);
    //     $model = new SafariOperatorForm($formmodel);


    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return \yii\widgets\ActiveForm::validate($model);
    //     }
    // }

    // public function actionValidate($id)
    // {
    //     $safari_operator = $this->findModel($id);
    //     $model = new SafariOperatorRequestForm($safari_operator);

    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return \yii\widgets\ActiveForm::validate($model);
    //     }
    // }

    public function actionDelete($id)
    {
        $safari_operator_delete_model = $this->findModel($id);
        $model = new SafariOperatorDeleteForm($safari_operator_delete_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_operator_delete_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safari_operator_delete_model->loadDefaultValues();
        }
        return $this->renderAjax('_delete_form', [
            'model' => $model,
            'safari_operator_model' => $safari_operator_delete_model,
        ]);
    }

    // public function actionChangeLogo($id)
    // {
    //     $safari_operator_logo_model = $this->findModel($id);
    //     $model = new SafariOperatorLogoForm($safari_operator_logo_model);
    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->validate()) {
    //                 if ($model->safari_operator_logo_model->save(false)) {
    //                     \Yii::$app->session->setFlash('success', 'Successfully Changed');
    //                     return $this->redirect(['index']);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->safari_operator_logo_model->loadDefaultValues();
    //     }
    //     return $this->renderAjax('_logo_form', [
    //         'model' => $model,
    //         'safari_operator_logo_model' => $safari_operator_logo_model,
    //     ]);
    // }

    // public function actionRedirectPartner($id)
    // {
    //     $safari_operator = $this->findModel($id);
    //     return $this->redirect(Yii::$app->urlManagerPartner->createAbsoluteUrl([
    //         '/check-in',
    //         'username' => $safari_operator->user->username,
    //         'google_source_id' => $safari_operator->user->google_source_id,
    //     ]));
    // }

    // public function actionRedirectPartner($id)
    // {
    //     $safari_operator = $this->findModel($id);
    //      \Yii::$app->response->redirect(Yii::$app->params['partner_url'] . '/check-in?username=' . $safari_operator->user->username . '&google_source_id=' . $safari_operator->user->google_source_id)->send();
    //     // return $this->redirect(Yii::$app->params['partner_url'] . '/check-in?username=' . $safari_operator->user->username . '&google_source_id=' . $safari_operator->user->google_source_id);
    // }

    public function actionTemporaryDelete($id)
    {
        $safari_operator = $this->findModel($id);
        if ($safari_operator) {
            $user_model = User::find()->where(['id' => $safari_operator->user_id])->limit(1)->one();
            // $auth_model = Auth::find()->where(['user_id' => $user_model->id])->limit(1)->all();

            $user_model->status = User::STATUS_DELETED;
            $safari_operator->status =  SafariOperator::STATUS_DELETE;

            $safari_operator->is_temporary_delete = 1;
            $safari_operator->email = time() . '_' . $safari_operator->email;
            $safari_operator->operator_email = time() . '_' . $safari_operator->operator_email;

            if ($safari_operator->save(false)) {

                $user_model->username = time() . '_' . $user_model->username;
                $user_model->email = time() . '_' . $user_model->email;
                if ($user_model->google_source_id != null) {
                    $user_model->google_source_id = time() . '_' . $user_model->google_source_id;
                }
                if ($user_model->apple_source_id != null) {
                    $user_model->apple_source_id = time() . '_' . $user_model->apple_source_id;
                }

                if ($user_model->save(false)) {

                    // foreach ($auth_model as $auth) {
                    //     $auth->source_id = time() . '_' . $auth->source_id;
                    //     $auth->save(false);
                    // }
                    \Yii::$app->session->setFlash('success', 'Successfully Temporary Deleted');
                    return $this->redirect(['index']);
                }
            }
        }
    }

    public function actionOperatorParks($id)
    {
        $operator_model = $this->findModel($id);

        $query =  SafariOperatorPark::find()->where(['status' => SafariOperatorPark::STATUS_ACTIVE, 'safari_operator_id' => $operator_model->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('operator_parks_list', ['dataProvider' => $dataProvider, 'operator_model' => $operator_model]);
    }

    public function actionRemovePark($id, $park_id)
    {
        $operator_model = $this->findModel($id);

        $operator_park =  SafariOperatorPark::find()->where(['id' => $park_id, 'status' => SafariOperatorPark::STATUS_ACTIVE])->limit(1)->one();
        if ($operator_park) {
            $operator_park->status = SafariOperatorPark::STATUS_SUSPEND;
            if ($operator_park->save(false)) {
                \Yii::$app->session->setFlash('success', 'Successfully Removed');
                return $this->redirect(['operator-parks', 'id' => $operator_model->id]);
            }
        }
    }


    public function actionAddPark($id)
    {
        $operator_model = $this->findModel($id);

        $model = new SafariOperatorParkForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    if ($model->parks) {
                        foreach ($model->parks as $park) {
                            $park_model = new SafariOperatorPark();
                            $park_model->safari_operator_id = $id;
                            $park_model->park_id = $park;
                            $park_model->status = SafariOperatorPark::STATUS_ACTIVE;
                            $park_model->save(false);
                        }
                    }
                    \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                    return $this->redirect(['operator-parks', 'id' => $id]);
                }
            }
        } else {
            $model->safari_operator_park_model->loadDefaultValues();
        }

        return $this->renderAjax('_add_park_form', [
            'operator_model' => $operator_model,
            'model' => $model,
        ]);
    }

    public function actionFileView($filepath, $duration = 1)
    {
        $urlParts = parse_url($filepath);
        $relativePath = ltrim($urlParts['path'], '/');

        if (strpos($relativePath, 'site/files/') === 0) {
            $relativePath = substr($relativePath, strlen('site/files/'));
        }

        $expiresAt = new \DateTimeImmutable("+$duration minutes");
        $url = Yii::$app->rfs->temporaryUrl($relativePath, $expiresAt);
        return $this->renderAjax('_file_view', ['fileUrl' => $url]);
    }

    public function actionPhoneVerified($id)
    {
        $model = $this->findModel($id);
        if ($model->is_phone_no_verified == 1) {
            $model->is_phone_no_verified = 0;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Operator phone is set to not verified!');
        } else {
            $model->is_phone_no_verified = 1;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Operator phone is set to verified !');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionBlockedOperator($id)
    {
        $safari_operator = $this->findModel($id);
        if ($safari_operator) {
            $user_model = User::find()->where(['id' => $safari_operator->user_id])->limit(1)->one();
            $user_model->status = NewStatusInterface::STATUS_BLOCKED;
            $safari_operator->status =  NewStatusInterface::STATUS_BLOCKED;
            if ($safari_operator->save(false)) {
                if ($user_model->save(false)) {
                    $packages = Package::find()->where(['safari_operator_id' => $safari_operator->id])->andWhere(['status' => 1])->all();
                    foreach ($packages as $pack) {
                        $pack->status = NewStatusInterface::STATUS_BLOCKED;
                        $pack->save();
                    }
                    $fixed_departures = ShareSafari::find()->where(['type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'safari_operator_id' => $safari_operator->id])->andWhere(['status' => 1])->all();
                    foreach ($fixed_departures as $fd) {
                        $fd->status = NewStatusInterface::STATUS_BLOCKED;
                        $fd->save(false);
                    }
                    $sightings = Sighting::find()->where(['safari_operator_id' => $safari_operator->id])->andWhere(['status' => 1])->all();
                    foreach ($sightings as $st) {
                        $st->status = NewStatusInterface::STATUS_BLOCKED;
                        $st->save();
                    }
                    \Yii::$app->session->setFlash('success', 'Blocked Successfully!!!');
                    return $this->redirect(['index']);
                }
            }
        }
    }

    public function actionUnblockedOperator($id)
    {

        $safari_operator = $this->findModel($id);
        if ($safari_operator) {
            $user_model = User::find()->where(['id' => $safari_operator->user_id])->limit(1)->one();
            $user_model->status = User::STATUS_ACTIVE;
            $safari_operator->status =  NewStatusInterface::STATUS_ACTIVE;
            if ($safari_operator->save(false)) {
                if ($user_model->save(false)) {
                    $packages = Package::find()->where(['safari_operator_id' => $safari_operator->id])->andWhere(['status' => NewStatusInterface::STATUS_BLOCKED])->all();
                    foreach ($packages as $pack) {
                        $pack->status = 1;
                        $pack->save();
                    }
                    $fixed_departures = ShareSafari::find()->where(['type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'safari_operator_id' => $safari_operator->id])->andWhere(['status' => NewStatusInterface::STATUS_BLOCKED])->all();
                    foreach ($fixed_departures as $fd) {
                        $fd->status = 1;
                        $fd->save(false);
                    }
                    $sightings = Sighting::find()->where(['safari_operator_id' => $safari_operator->id])->andWhere(['status' => NewStatusInterface::STATUS_BLOCKED])->all();
                    foreach ($sightings as $st) {
                        $st->status = 1;
                        $st->save();
                    }
                    \Yii::$app->session->setFlash('success', 'UnBlocked Successfully!!!');
                    return $this->redirect(['index']);
                }
            }
        }
    }


    public function actionUpdateDetails($id)
    {
        $safari_operator_update_model = $this->findModel($id);
        $model = new SafariOperatorUpdateForm($safari_operator_update_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo_file = UploadedFile::getInstance($model, 'logo_file');
                $model->registration_copy_upload = UploadedFile::getInstance($model, 'registration_copy_upload');
                $model->pan_upload = UploadedFile::getInstance($model, 'pan_upload');
                $model->cancel_check_upload = UploadedFile::getInstance($model, 'cancel_check_upload');
                $model->kyc_pan_upload = UploadedFile::getInstance($model, 'kyc_pan_upload');
                $model->aadhar_front_upload = UploadedFile::getInstance($model, 'aadhar_front_upload');
                $model->aadhar_back_upload = UploadedFile::getInstance($model, 'aadhar_back_upload');
                $model->pan_upload = UploadedFile::getInstance($model, 'pan_upload');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_operator_update_model->save(false)) {
                        $model->uploadFile();
                        // $model->partnerRegistrationTableUpdate($safari_operator_update_model);
                        \Yii::$app->session->setFlash('success', 'Successfully Changed');
                        return $this->redirect(['view', 'id' => $safari_operator_update_model->id]);
                    }
                }
            }
        } else {
            $model->safari_operator_update_model->loadDefaultValues();
        }
        return $this->render('_update_form', [
            'model' => $model,
            'safari_operator_update_model' => $safari_operator_update_model,
        ]);
    }
}
