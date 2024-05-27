<?php

namespace backend\modules\registration\controllers;

use backend\modules\registration\model\BirdingOperatorTourApprovalForm;
use common\interfaces\StatusInterface;
use common\models\operator\BirdingOperatorActivities;
use common\models\operator\BirdingOperatorPark;
use common\models\operator\SafariOperator;
use common\models\User;
use frontend\models\BirdingOperatorRequestSearch;
use frontend\models\registration\BirdingOperatorRequest;
use frontend\models\registration\BirdingOperatorRequestActivities;
use frontend\models\registration\BirdingOperatorRequestPark;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BirdingOperatorTourController.
 */
class BirdingOperatorTourController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new BirdingOperatorRequestSearch();
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
        $birdingoperator_request_model = $this->findModel($id);


        $model = new BirdingOperatorTourApprovalForm($birdingoperator_request_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birdingoperator_request_approval_model->save()) {
                        if ($model->is_approved == 1) {
                            $old_birding_operator = SafariOperator::find()->where(['birding_operator_request_id' => $model->birdingoperator_request_approval_model->id, 'status' => 1])->limit(1)->one();
                            if (!$old_birding_operator) {
                                $new_birding_operator = new SafariOperator();
                                $birding_operator = $new_birding_operator;
                            } else {
                                $birding_operator = $old_birding_operator;
                            }
                            $birding_operator->category_id                     =  $model->birdingoperator_request_approval_model->category_id;
                            $birding_operator->birding_operator_request_id     =  $model->birdingoperator_request_approval_model->id;
                            $birding_operator->business_name                   =  $model->birdingoperator_request_approval_model->business_name;
                            $birding_operator->register_comapany_name          =  $model->birdingoperator_request_approval_model->register_comapany_name;
                            $birding_operator->address                         =  $model->birdingoperator_request_approval_model->address;
                            $birding_operator->gst                             =  $model->birdingoperator_request_approval_model->gst;
                            $birding_operator->logo                            =  $model->birdingoperator_request_approval_model->logo;
                            $birding_operator->is_highlighted                  =  $model->birdingoperator_request_approval_model->is_highlighted;
                            $birding_operator->google_rating                   =  $model->birdingoperator_request_approval_model->google_rating;
                            $birding_operator->google_review_count             =  $model->birdingoperator_request_approval_model->google_review_count;
                            $birding_operator->google_business_url             =  $model->birdingoperator_request_approval_model->google_business_url;
                            $birding_operator->google_business_name            =  $model->birdingoperator_request_approval_model->google_business_name;
                            $birding_operator->about_business                  =  $model->birdingoperator_request_approval_model->about_business;
                            $birding_operator->facebook_url                    =  $model->birdingoperator_request_approval_model->facebook_url;
                            $birding_operator->instagram_url                   =  $model->birdingoperator_request_approval_model->instagram_url;
                            $birding_operator->youtube_link                    =  $model->birdingoperator_request_approval_model->youtube_link;
                            $birding_operator->phone_no                        =  $model->birdingoperator_request_approval_model->phone_no;
                            $birding_operator->email                           =  $model->birdingoperator_request_approval_model->email;
                            $birding_operator->website                         =  $model->birdingoperator_request_approval_model->website;
                            $birding_operator->is_register_company             =  $model->birdingoperator_request_approval_model->is_register_company;
                            $birding_operator->has_a_website                   =  $model->birdingoperator_request_approval_model->has_a_website;
                            $birding_operator->has_cancellation_policy         =  $model->birdingoperator_request_approval_model->has_cancellation_policy;
                            $birding_operator->wildlife_photographer           =  $model->birdingoperator_request_approval_model->wildlife_photographer;
                            $birding_operator->wildlife_influencer             =  $model->birdingoperator_request_approval_model->wildlife_influencer;
                            $birding_operator->is_offer_premium_budget         =  $model->birdingoperator_request_approval_model->is_offer_premium_budget;
                            $birding_operator->is_offer_standard_budget        =  $model->birdingoperator_request_approval_model->is_offer_standard_budget;
                            $birding_operator->is_offer_economical_budget      =  $model->birdingoperator_request_approval_model->is_offer_economical_budget;
                            $birding_operator->starting_price                  =  $model->birdingoperator_request_approval_model->starting_price;
                            $birding_operator->is_approved                     =  $model->birdingoperator_request_approval_model->is_approved;
                            $birding_operator->operator_name                   =  $model->birdingoperator_request_approval_model->operator_name;
                            $birding_operator->operator_phone_no               =  $model->birdingoperator_request_approval_model->operator_phone_no;
                            $birding_operator->operator_email                  =  $model->birdingoperator_request_approval_model->operator_email;
                            $birding_operator->is_highlighted                  =  $model->birdingoperator_request_approval_model->is_highlighted;
                            $birding_operator->status                          =  $model->birdingoperator_request_approval_model->status;
                            if ($birding_operator->save(false)) {

                                $parks = BirdingOperatorRequestPark::find()->where(['birding_operator_request_id' => $model->birdingoperator_request_approval_model->id, 'status' => 1])->all();

                                if ($parks) {
                                    BirdingOperatorPark::updateAll(['status' => 2], ['birding_operator_id' => $birding_operator->id]);
                                    foreach ($parks as $park) {
                                        $birdingoperatorpark = new BirdingOperatorPark();
                                        $birdingoperatorpark->birding_operator_id = $birding_operator->id;
                                        $birdingoperatorpark->park_id = $park->park_id;
                                        $birdingoperatorpark->save(false);
                                    }
                                }

                                $activities = BirdingOperatorRequestActivities::find()->where(['birding_operator_request_id' => $model->birdingoperator_request_approval_model->id, 'status' => 1])->all();
                                if ($activities) {
                                    BirdingOperatorActivities::updateAll(['status' => 2], ['birding_operator_id' => $birding_operator->id]);
                                    foreach ($activities as $activity) {
                                        $birdingioperatorrequestactivities = new BirdingOperatorActivities();
                                        $birdingioperatorrequestactivities->birding_operator_id = $birding_operator->id;
                                        $birdingioperatorrequestactivities->wildlife_activity_id = $activity->wildlife_activity_id;
                                        $birdingioperatorrequestactivities->save(false);
                                    }
                                }

                                if (!$old_birding_operator) {
                                    $user = new User();
                                    $user->username = $birding_operator->email;
                                    $user->generateAuthKey();
                                    $user->generateEmailVerificationToken();
                                    $user->email = $birding_operator->email;
                                    $user->mobile_no = $birding_operator->phone_no;
                                    $user->name = $birding_operator->business_name;
                                    $user->setPassword($birding_operator->phone_no);
                                    $user->is_birding_operator = 1;
                                    $user->status = 10;
                                    // $user->setUpd($model->phone);

                                    if ($user->save(false)) {
                                        $birding_operator->user_id = $user->id;
                                        $birding_operator->save(false);
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
            $model->birdingoperator_request_approval_model->loadDefaultValues();
        }
        return $this->render('view', [
            'model' => $model,
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

    /**
     * Finds the MasterAnimal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterAnimal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BirdingOperatorRequest::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
