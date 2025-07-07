<?php

namespace business\modules\sharesafari\controllers;

use business\controllers\BusinessController;
use common\models\master\faq\MasterFaq;
use common\models\sharesafari\form\DayItineraryForm;
use common\models\sharesafari\form\ShareSafariFaqForm;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariCommentSearch;
use common\models\sharesafari\ShareSafariDay;
use common\models\sharesafari\ShareSafariFaq;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariIncluded;
use common\models\sharesafari\ShareSafariParklist;
use common\models\sharesafari\ShareSafariSearch;
use frontend\models\form\CreateDepartureForm;
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
        $searchModel = new ShareSafariSearch();
        // $searchModel->status = 1;
        $searchModel->host_user_id = $safari_operator->id;
        $dataProvider = $searchModel->fixeddeparturesearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $share_safari = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $share_safari->id;
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
        $model = new CreateDepartureForm();
        $model->host_user_id =  $safari_operator->id; //Operator Id Comes Here
        $model->type = 2;

        if ($safari_operator->category_id == 1) {
            $model->host_type = 3;
        } elseif ($safari_operator->category_id == 2) {
            $model->host_type = 2;
        } else {
            $model->host_type = Yii::$app->user->identity->account_type;
        }

        $model->status = ShareSafari::STATUS_SUSPEND;
        $model->rand_text = substr(sha1(mt_rand()), 17, 6) . '-' . $model->host_user_id . time();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save()) {
                        $model->shared_safari_departure_model->savehistory();
                        $parks = $model->park_list;

                        if ($parks) {
                            foreach ($parks as $park) {
                                $park_model = new ShareSafariParklist();
                                $park_model->share_safari_id = $model->shared_safari_departure_model->id;
                                $park_model->park_id = $park;
                                $park_model->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Fixed departure created successfully');
                        return $this->redirect(['itinerary', 'id' => $model->shared_safari_departure_model->id]);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
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
        $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save(false)) {
                        $model->shared_safari_departure_model->savehistory();
                        $parks = $model->park_list;
                        if ($parks) {
                            ShareSafariParklist::deleteAll(['share_safari_id' => $shared_safari_departure_model->id]);
                            foreach ($parks as $park) {
                                $park_model = new ShareSafariParklist();
                                $park_model->share_safari_id = $model->shared_safari_departure_model->id;
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
            $model->shared_safari_departure_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'safari_operator' => $safari_operator,

        ]);
    }

    public function actionItinerary($id, $day = 1)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);

        $share_safari_id = $shared_safari_departure_model->id;
        $share_safari_day_model = $this->findModelDay($share_safari_id, $day);

        if ($share_safari_day_model) {
            $model = new DayItineraryForm($share_safari_day_model);
        } else {
            $model = new DayItineraryForm();
            $model->share_safari_id = $share_safari_id;
            $model->no_of_day = $shared_safari_departure_model->tour_duration;
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
                        return $this->redirect(['itinerary', 'id' => $shared_safari_departure_model->id, 'day' => $day]);
                    }
                }
            }
        } else {
            $model->share_safari_day_model->loadDefaultValues();
        }

        return $this->render('itinerary', [
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'model' => $model,
            'safari_operator' => $safari_operator
        ]);
    }


    public function actionInclusion($id)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'inclusion';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->shared_safari_departure_model->save(false)) {

                            foreach ($model->share_safari_included as $optionId => $selection) {
                                $sharesafariIncluded = ShareSafariIncluded::findOne(['include_id' => $optionId, 'share_safari_id' => $shared_safari_departure_model->id]);
                                if (!$sharesafariIncluded) {
                                    $sharesafariIncluded = new ShareSafariIncluded();
                                    $sharesafariIncluded->include_id = $optionId;
                                    $sharesafariIncluded->share_safari_id = $shared_safari_departure_model->id;
                                }
                                $sharesafariIncluded->selection = $selection;
                                if (!$sharesafariIncluded->save()) {
                                    throw new \Exception('Failed to save share safari inclusion option ' . $optionId);
                                }

                                if ($sharesafariIncluded->include_id == 2 && $sharesafariIncluded->selection == 1) {
                                    $share_safari_days = ShareSafariDay::find()->where(['share_safari_id' => $shared_safari_departure_model->id, 'status' => ShareSafariDay::STATUS_ACTIVE])->all();
                                    if ($share_safari_days) {
                                        foreach ($share_safari_days as $share_safari_day) {
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
                            return $this->redirect(['inclusion', 'id' => $shared_safari_departure_model->id]);
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

            $model->shared_safari_departure_model->loadDefaultValues();
            $includedOptions = [];
            foreach ($shared_safari_departure_model->sharesafariIncludeds as $includedOption) {
                $includedOptions[$includedOption->include_id] = $includedOption->selection;
            }
            $model->share_safari_included = $includedOptions;
        }

        return $this->render('inclusion', [
            'model' => $model,
            'shared_safari_departure_model' => $shared_safari_departure_model,
        ]);
    }

    public function actionGettingThere($id)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'getting_there';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Getting there updated successfully');
                        return $this->redirect(['getting-there', 'id' => $shared_safari_departure_model->id]);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
        }

        return $this->render('getting_there', [
            'model' => $model,
            'shared_safari_departure_model' => $shared_safari_departure_model,
        ]);
    }


    public function actionPolicyInfo($id)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'policy_info';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Policy info updated successfully');
                        return $this->redirect(['policy-info', 'id' => $shared_safari_departure_model->id]);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
        }

        return $this->render('policy_info', [
            'model' => $model,
            'shared_safari_departure_model' => $shared_safari_departure_model,
        ]);
    }

    public function actionFaq($id)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $shared_safari_departure_model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $faqs = $dataProvider->getModels();

        $model = new ShareSafariFaqForm();
        $model->share_safari_id = $shared_safari_departure_model->id;
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
                        return $this->redirect(['faq', 'id' => $shared_safari_departure_model->id]);
                    }
                }
            }
        } else {
            $model->share_safari_faq_model->loadDefaultValues();
        }

        return $this->render('faq', [
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'faqs' => $faqs,
            'model' => $model,
        ]);
    }

    public function actionUpdateFaq($id, $faq_id)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($id, $safari_operator->id);
        $faq_model = ShareSafariFaq::find()->where(['id' => $faq_id])->one();
        $model = new ShareSafariFaqForm($faq_model);
        $model->share_safari_id = $shared_safari_departure_model->id;

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
                        return $this->redirect(['faq', 'id' => $shared_safari_departure_model->id]);
                    }
                }
            }
        } else {
            $model->share_safari_faq_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'shared_safari_departure_model' => $shared_safari_departure_model,
            ]);
        }
    }

    protected function findModelDay($share_safari_id, $day)
    {
        if (($model = ShareSafariDay::findOne(['share_safari_id' => $share_safari_id, 'day' => $day, 'status' => [ShareSafariDay::STATUS_ACTIVE, ShareSafariDay::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
    }

    protected function findModel($id, $host_user_id)
    {
        if (($model = ShareSafari::findOne(['id' => $id, 'host_user_id' => $host_user_id, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_SUSPEND, ShareSafari::STATUS_FULL_SEAT]])) !== null) {
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
        $model = ShareSafari::findOne(['id' => $id]);

        if ($model && $model->host_user_id == $operator->id) {
            return true;
        }
        return false;
    }
}
