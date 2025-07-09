<?php

namespace business\modules\sharesafari\controllers;

use business\controllers\BusinessController;
use common\models\master\faq\MasterFaq;
use common\models\sharesafari\form\CreateDepartureVersionForm;
use common\models\sharesafari\form\DayItineraryForm;
use common\models\sharesafari\form\ShareSafariFaqForm;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariCommentSearch;
use common\models\sharesafari\ShareSafariDay;
use common\models\sharesafari\ShareSafariFaq;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariIncluded;
use common\models\sharesafari\ShareSafariParklist;
use common\models\sharesafari\ShareSafariVersion;
use common\models\sharesafari\ShareSafariVersionSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'itinerary', 'inclusion', 'policy-info', 'getting-there', 'faq', 'create-faq', 'update-faq', 'send-for-approval'],
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'copy-package'],
                        'allow' => $this->isFdOwner(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update', 'itinerary', 'inclusion', 'policy-info', 'getting-there', 'faq', 'create-faq', 'update-faq', 'send-for-approval'],
                        'allow' => $this->isFdOwner(),
                        'roles' => ['@'],
                    ],

                ],

            ],
        ];
    }

    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();
        $searchModel = new ShareSafariVersionSearch();
       $searchModel->custom_status = ShareSafariVersion::EDIATBLE_STATUS;
        $searchModel->host_user_id = $safari_operator->id;
        $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $share_safari = $this->findModel($id);
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $share_safari->share_safari_id;
        $searchModel->version = $share_safari->version;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        return $this->render('_fixed_view', [
            'share_safari' => $share_safari,
            'faqs' => $faqs,
        ]);
    }


    public function actionCreate()
    {
        $safari_operator = $this->module->operatormodel();
        $model = new CreateDepartureVersionForm();
        $model->host_user_id =  $safari_operator->id; //Operator Id Comes Here
        $model->type = 2;
        $model->host_type = 3; //check for operator

        $model->status = ShareSafariVersion::EDIATBLE_STATUS;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_version_model->save()) {
                        $this->updateFixedDepartureStatus($model->share_safari_id, $model->version, ShareSafariVersion::EDIATBLE_STATUS);

                        $parks = $model->park_list;
                        if ($parks) {
                            foreach ($parks as $park) {
                                $park_model = new ShareSafariParklist();
                                $park_model->share_safari_id = $model->shared_safari_departure_version_model->share_safari_id;
                                $park_model->version = $model->shared_safari_departure_version_model->version;
                                $park_model->park_id = $park;
                                $park_model->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Fixed departure created successfully');
                        return $this->redirect(['itinerary', 'id' => $model->shared_safari_departure_version_model->id]);
                    } else {
                        print_r($model->getErrors());
                        die();
                    }
                }
            }
        } else {
            $model->shared_safari_departure_version_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'safari_operator' => $safari_operator,
        ]);
    }


    /**
     * Updates an existing ShareSafari model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_version_model = $this->findModel($id);
        $model = new CreateDepartureVersionForm($shared_safari_departure_version_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_version_model->save(false)) {
                        $parks = $model->park_list;
                        if ($parks) {
                            ShareSafariParklist::deleteAll(['share_safari_id' => $shared_safari_departure_version_model->id]);
                            foreach ($parks as $park) {
                                $park_model = new ShareSafariParklist();
                                $park_model->share_safari_id = $model->shared_safari_departure_version_model->share_safari_id;
                                $park_model->version = $model->shared_safari_departure_version_model->version;
                                $park_model->park_id = $park;
                                $park_model->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Fixed departure updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_version_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'shared_safari_departure_version_model' => $shared_safari_departure_version_model,
            'safari_operator' => $safari_operator,

        ]);
    }

    public function actionItinerary($id, $day = 1)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_version_model = $this->findModel($id);

        $share_safari_id = $shared_safari_departure_version_model->share_safari_id;
        $version = $shared_safari_departure_version_model->version;
        $share_safari_day_model = $this->findModelDay($share_safari_id, $day, $version);

        if ($share_safari_day_model) {
            $model = new DayItineraryForm($share_safari_day_model);
        } else {
            $model = new DayItineraryForm();
            $model->share_safari_id = $share_safari_id;
            $model->version = $shared_safari_departure_version_model->version;
            $model->no_of_day = $shared_safari_departure_version_model->tour_duration;
            $model->day = $day;
        }
        // Validate and save each day's itinerary entries

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->day_image = UploadedFile::getInstance($model, 'day_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_day_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Itinerary updated successfully');
                        return $this->redirect(['itinerary', 'id' => $shared_safari_departure_version_model->id, 'day' => $day]);
                    }
                }
            }
        } else {
            $model->share_safari_day_model->loadDefaultValues();
        }

        return $this->render('itinerary', [
            'shared_safari_departure_version_model' => $shared_safari_departure_version_model,
            'model' => $model,
            'safari_operator' => $safari_operator
        ]);
    }


    public function actionInclusion($id)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_version_model = $this->findModel($id);
        $model = new CreateDepartureVersionForm($shared_safari_departure_version_model);
        $model->scenario = 'inclusion';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->shared_safari_departure_version_model->save(false)) {

                            foreach ($model->share_safari_included as $optionId => $selection) {
                                $sharesafariIncluded = ShareSafariIncluded::findOne(['include_id' => $optionId, 'share_safari_id' => $shared_safari_departure_version_model->share_safari_id, 'version' => $shared_safari_departure_version_model->version]);
                                if (!$sharesafariIncluded) {
                                    $sharesafariIncluded = new ShareSafariIncluded();
                                    $sharesafariIncluded->include_id = $optionId;
                                    $sharesafariIncluded->share_safari_id = $shared_safari_departure_version_model->share_safari_id;
                                    $sharesafariIncluded->version = $shared_safari_departure_version_model->version;
                                }
                                $sharesafariIncluded->selection = $selection;
                                if (!$sharesafariIncluded->save()) {
                                    throw new \Exception('Failed to save share safari inclusion option ' . $optionId);
                                }

                                if ($sharesafariIncluded->include_id == 2 && $sharesafariIncluded->selection == 1) {
                                    $share_safari_days = ShareSafariDay::find()->where(['share_safari_id' => $shared_safari_departure_version_model->share_safari_id, 'status' => ShareSafariDay::STATUS_ACTIVE, 'version' => $shared_safari_departure_version_model->version])->all();
                                    if ($share_safari_days) {
                                        foreach ($share_safari_days as $share_safari_day) {
                                            $share_safari_day->share_safari_id = $shared_safari_departure_version_model->share_safari_id;
                                            $share_safari_day->version = $shared_safari_departure_version_model->version;
                                            $share_safari_day->meal_breakfast = 1;
                                            $share_safari_day->meal_lunch = 1;
                                            $share_safari_day->meal_dinner = 1;
                                            $share_safari_day->save();
                                        }
                                    }
                                }
                            }

                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Inclusion updated successfully');
                            return $this->redirect(['inclusion', 'id' => $shared_safari_departure_version_model->id]);
                        } else {
                            Yii::$app->session->setFlash('success', 'Failed to update package details.');
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('success', 'An error occurred while updating data: ' . $e->getMessage());
                    }
                }
            }
        } else {

            $model->shared_safari_departure_version_model->loadDefaultValues();
            $includedOptions = [];
            foreach ($shared_safari_departure_version_model->sharesafariIncludeds as $includedOption) {
                $includedOptions[$includedOption->include_id] = $includedOption->selection;
            }
            $model->share_safari_included = $includedOptions;
        }

        return $this->render('inclusion', [
            'model' => $model,
            'shared_safari_departure_version_model' => $shared_safari_departure_version_model,
        ]);
    }

    public function actionGettingThere($id)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_version_model = $this->findModel($id);
        $model = new CreateDepartureVersionForm($shared_safari_departure_version_model);
        $model->scenario = 'getting_there';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_version_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Getting there updated successfully');
                        return $this->redirect(['getting-there', 'id' => $shared_safari_departure_version_model->id]);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_version_model->loadDefaultValues();
        }

        return $this->render('getting_there', [
            'model' => $model,
            'shared_safari_departure_version_model' => $shared_safari_departure_version_model,
        ]);
    }


    public function actionPolicyInfo($id)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_version_model = $this->findModel($id);
        $model = new CreateDepartureVersionForm($shared_safari_departure_version_model);
        $model->scenario = 'policy_info';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_version_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Policy info updated successfully');
                        return $this->redirect(['policy-info', 'id' => $shared_safari_departure_version_model->id]);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_version_model->loadDefaultValues();
        }

        return $this->render('policy_info', [
            'model' => $model,
            'shared_safari_departure_version_model' => $shared_safari_departure_version_model,
        ]);
    }

    public function actionFaq($id)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_version_model = $this->findModel($id, $safari_operator->id);
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $shared_safari_departure_version_model->share_safari_id;
        $searchModel->version = $shared_safari_departure_version_model->version;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $faqs = $dataProvider->getModels();

        $model = new ShareSafariFaqForm();
        $model->share_safari_id = $shared_safari_departure_version_model->share_safari_id;
        $model->version = $shared_safari_departure_version_model->version;
        $model->status = ShareSafariFaq::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_faq_model->save(false)) {
                        $faq = new MasterFaq();
                        $faq->question = $model->question;
                        $faq->answer = $model->answer;
                        $faq->position = 0;
                        $faq->status = MasterFaq::STATUS_ACTIVE;
                        if ($faq->save(false)) {
                            $model->share_safari_faq_model->faq_id = $faq->id;
                            $model->share_safari_faq_model->save(false);
                        }
                        \Yii::$app->session->setFlash('success', 'Faq submitted successfully');
                        return $this->redirect(['faq', 'id' => $shared_safari_departure_version_model->id]);
                    }
                }
            }
        } else {
            $model->share_safari_faq_model->loadDefaultValues();
        }

        return $this->render('faq', [
            'shared_safari_departure_version_model' => $shared_safari_departure_version_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'faqs' => $faqs,
            'model' => $model,
        ]);
    }

    public function actionUpdateFaq($id, $faq_id)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_version_model = $this->findModel($id);
        $faq_model = ShareSafariFaq::find()->where(['id' => $faq_id])->one();
        $model = new ShareSafariFaqForm($faq_model);
        $model->share_safari_id = $shared_safari_departure_version_model->share_safari_id;
        $model->version = $shared_safari_departure_version_model->version;

        if ($this->request->isPost) {
            if ($model->validate()) {
                $model->initializeForm();
                if ($faq_model->load($this->request->post())) {
                    if ($model->share_safari_faq_model->save(false)) {
                        $faq = new MasterFaq();
                        $faq->question = $model->question;
                        $faq->answer = $model->answer;
                        $faq->position = 0;
                        $faq->status = MasterFaq::STATUS_ACTIVE;
                        if ($faq->save(false)) {
                            $model->share_safari_faq_model->faq_id = $faq->id;
                            $model->share_safari_faq_model->save(false);
                        }
                        \Yii::$app->session->setFlash('success', 'Faq submitted successfully');
                        return $this->redirect(['faq', 'id' => $shared_safari_departure_version_model->id]);
                    }
                }
            }
        } else {
            $model->share_safari_faq_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'shared_safari_departure_version_model' => $shared_safari_departure_version_model,
            ]);
        }
    }

    protected function findModelDay($share_safari_id, $day, $version)
    {
        if (($model = ShareSafariDay::findOne(['share_safari_id' => $share_safari_id, 'version' => $version, 'day' => $day, 'status' => [ShareSafariDay::STATUS_ACTIVE, ShareSafariDay::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
    }

    protected function findModel($id)
    {
        if (($model = ShareSafariVersion::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Create ShareSafariFaqForm.
     * 
     * @return mixed
     */
    // public function actionCreateFaq($id)
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);
    //     $model = new ShareSafariFaqForm();
    //     $model->share_safari_id = $shared_safari_departure_model->id;
    //     $model->status = ShareSafariFaq::STATUS_ACTIVE;
    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->share_safari_faq_model->save(false)) {
    //                     $faq = new MasterFaq();
    //                     $faq->question = $model->question;
    //                     $faq->answer = $model->answer;
    //                     $faq->position = 0;
    //                     $faq->status = MasterFaq::STATUS_ACTIVE;
    //                     if ($faq->save(false)) {
    //                         $model->share_safari_faq_model->faq_id = $faq->id;
    //                         $model->share_safari_faq_model->save(false);
    //                     }
    //                     \Yii::$app->session->setFlash('success', 'Faq submitted successfully');
    //                     return $this->redirect(['faq', 'id' => $shared_safari_departure_model->id]);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->share_safari_faq_model->loadDefaultValues();
    //     }


    //     if (Yii::$app->request->isAjax) {
    //         return $this->renderAjax('create_faq', [
    //             'model' => $model,
    //             'shared_safari_departure_model' => $shared_safari_departure_model,
    //         ]);
    //     }
    // }

    // public function actionUpdateFaq($id, $faq_id)
    // {
    //     $safari_operator = $this->module->operatormodel();

    //     $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);
    //     $faq_model = ShareSafariFaq::find()->where(['id' => $faq_id])->one();
    //     $model = new ShareSafariFaqForm($faq_model);
    //     $model->share_safari_id = $shared_safari_departure_model->id;

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->share_safari_faq_model->save(false)) {
    //                     $faq = new MasterFaq();
    //                     $faq->question = $model->question;
    //                     $faq->answer = $model->answer;
    //                     $faq->position = 0;
    //                     $faq->status = MasterFaq::STATUS_ACTIVE;
    //                     if ($faq->save(false)) {
    //                         $model->share_safari_faq_model->faq_id = $faq->id;
    //                         $model->share_safari_faq_model->save(false);
    //                     }
    //                     \Yii::$app->session->setFlash('success', 'Faq submitted successfully');
    //                     return $this->redirect(['faq', 'id' => $shared_safari_departure_model->id]);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->share_safari_faq_model->loadDefaultValues();
    //     }
    //     if (Yii::$app->request->isAjax) {
    //         return $this->renderAjax('create_faq', [
    //             'model' => $model,
    //             'shared_safari_departure_model' => $shared_safari_departure_model,
    //         ]);
    //     }
    // }

    protected function isFdOwner()
    {
        $id = Yii::$app->request->get('id');

        $operator = $this->module->operatormodel();
        $model = ShareSafariVersion::findOne(['id' => $id]);

        if ($model && $model->host_user_id == $operator->id) {
            return true;
        }
        return false;
    }

    private function updateFixedDepartureStatus($share_safari_id, $version, $status)
    {
        $model = ShareSafari::find()->where(['id' => $share_safari_id])->one();
        $share_safari_version = ShareSafariVersion::find()->where(['share_safari_id' => $share_safari_id, 'version' => $version])->one();

        if (empty($model)) {
            $model = new ShareSafari();
            $model->share_safari_title = $share_safari_version->package_name;
        }
        if ($status == ShareSafariVersion::SEND_FOR_APPROVAL_STATUS) {
            $model->pending_for_approval_version = $version;
            // $model->editable_version = NULL;
        }
        if ($status == ShareSafariVersion::EDIATBLE_STATUS) {

            $model->editable_version = $version;
        }
        if ($model->save(false)) {
            $this->terminateFixedDeparture($share_safari_id);
            return true;
        }
        return false;
    }


    private function terminateFixedDeparture($share_safari_id)
    {
        $model = ShareSafari::find()->where(['id' => $share_safari_id])->one();
        $share_safari_version = ShareSafariVersion::find()->where(['share_safari_id' => $share_safari_id])->all();
        foreach ($share_safari_version as $version) {
            if ($version->version == $model->live_version) {
                $version->status = ShareSafariVersion::APPROVED_AND_LIVE_STATUS;
            } elseif ($version->version == $model->pending_for_approval_version) {
                $version->status = ShareSafariVersion::SEND_FOR_APPROVAL_STATUS;
            } elseif ($version->version ==  $model->editable_version) {
                $version->status = ShareSafariVersion::EDIATBLE_STATUS;
            } else {
                $version->status = ShareSafariVersion::TERMINATED_STATUS;
            }
            $version->save(false);
        }

        return true;
    }

    public function actionSendForApproval($id)
    {

        $m = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $m->status = ShareSafariVersion::SEND_FOR_APPROVAL_STATUS;
            $m->save(false);
            $this->updateFixedDepartureStatus($m->share_safari_id, $m->version, $m->status);
            $this->copyFixedDeparture($id);
            Yii::$app->session->setFlash('success', 'FixedDeparture sent for approval successfully');
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
            return $this->redirect(Yii::$app->request->referrer);
        }
        $transaction->commit();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function copyFixedDeparture($id)
    {

        $m = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $this->copyFixedDeparture($id, true);
            // $this->updatePackageStatus($m->uuid, $m->version, $m->status);
            Yii::$app->session->setFlash('success', 'FixedDeparture copy successfully');
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
        }
        $transaction->commit();

        return $this->redirect(Yii::$app->request->referrer);
    }
}
