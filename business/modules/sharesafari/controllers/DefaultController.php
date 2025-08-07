<?php

namespace business\modules\sharesafari\controllers;

use api\models\sharesafari\ShareSafari as ApiShareSafari;
use business\controllers\BusinessController;
use common\models\master\faq\MasterFaq;
use common\models\operator\SafariOperatorFaq;
use common\models\partnergallery\PartnerGallerySearch;
use common\models\sharesafari\form\CreateDepartureVersionForm;
use common\models\sharesafari\form\DayItineraryForm;
use common\models\sharesafari\form\ShareSafariFaqForm;
use common\models\sharesafari\form\ShareSeatForm;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariCommentSearch;
use common\models\sharesafari\ShareSafariDay;
use common\models\sharesafari\ShareSafariFaq;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariIncluded;
use common\models\sharesafari\ShareSafariParklist;
use common\models\sharesafari\ShareSafariSearch;
use common\models\sharesafari\ShareSafariVersion;
use common\models\sharesafari\ShareSafariVersionSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    public $version;

    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'itinerary', 'inclusion', 'policy-info', 'getting-there', 'faq', 'create-faq', 'update-faq', 'send-for-approval', 'delete', 'inactive', 'copy-with-edit', 'update-seat'],
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'update', 'itinerary', 'inclusion', 'policy-info', 'getting-there', 'faq', 'create-faq', 'update-faq', 'send-for-approval', 'delete', 'inactive', 'copy-with-edit', 'update-seat'],
                        'allow' =>  $this->isFdOwner(),
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
        $searchModel->safari_operator_id = $safari_operator->id;
        $searchModel->type = ShareSafari::TYPE_FIXED_DEPARTURE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['!=', 'status', -1]);

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
        $searchModel->status = ShareSafariFaq::STATUS_ACTIVE;
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
        $model->status = ShareSafariVersion::EDIATBLE_STATUS;
        $model->host_user_id =  null;
        $model->safari_operator_id =  $safari_operator->id;
        $model->user_id =  Yii::$app->user->identity->id;
        $model->type = 2;
        $model->host_type = 3; //check it


        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_version_model->save()) {
                        $model->uploadFile();
                        $share_safari = ShareSafari::find()->where(['id' => $model->shared_safari_departure_version_model->share_safari_id, 'status' => 10])->limit(1)->one();
                        if ($share_safari) {
                            $share_safari->image_filepath = $model->shared_safari_departure_version_model->image_filepath;
                            $share_safari->save(false);
                        }
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
        $share_safari = ShareSafari::find()->where(['id' => $id])->andWhere(['IN', 'status', [10, 1]])->limit(1)->one();
        $shared_safari_departure_version_model = ShareSafariVersion::find()->where(['share_safari_id' => $id, 'version' => $share_safari->editable_version])->limit(1)->one();
        $model = new CreateDepartureVersionForm($shared_safari_departure_version_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_version_model->save(false)) {
                        $model->uploadFile();
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
            $model->day = $day;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // $model->day_image = UploadedFile::getInstance($model, 'day_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_day_model->save(false)) {
                        // $model->uploadFile();
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
                                if (!$sharesafariIncluded->save(false)) {
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
                            Yii::$app->session->setFlash('success', 'Data updated successfully');
                            return $this->redirect(['inclusion', 'id' => $shared_safari_departure_version_model->id]);
                        } else {
                            Yii::$app->session->setFlash('success', 'Failed to update fixed departure details.');
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

        $park_array = ShareSafariParklist::find()->where(['share_safari_id' => $shared_safari_departure_version_model->share_safari_id, 'version' => $shared_safari_departure_version_model->version])->select('park_id')->asArray()->column();

        $faqList = SafariOperatorFaq::find()
            ->where(['safari_operator_id' => $safari_operator->id])
            ->andWhere(['park_id' => $park_array])
            ->select(['id', 'question'])
            ->asArray()
            ->all();

        $drop_down_list = ArrayHelper::map($faqList, 'id', 'question');


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
            'drop_down_list' => $drop_down_list,
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
                        \Yii::$app->session->setFlash('success', 'Faq submitted successfully');
                        return $this->redirect(['faq', 'id' => $shared_safari_departure_version_model->id]);
                    }
                }
            }
        } else {
            $model->share_safari_faq_model->loadDefaultValues();
        }

        return $this->redirect(['faq', 'id' => $shared_safari_departure_version_model->id]);
    }





    public function actionSendForApproval($id)
    {

        $m = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $m->status = ShareSafariVersion::SEND_FOR_APPROVAL_STATUS;
            $m->save(false);
            $this->updateFixedDepartureStatus($m->share_safari_id, $m->version, $m->status);
            Yii::$app->session->setFlash('success', 'FixedDeparture sent for approval successfully');
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
            return $this->redirect(['index']);
        }
        $transaction->commit();

        return $this->redirect(['index']);
    }


    public function actionGalleryPopup($context, $preview)
    {
        $safari_operator = $this->module->operatormodel();
        $searchModel = new PartnerGallerySearch();
        $searchModel->is_live = 1;
        $searchModel->safari_operator_id = $safari_operator->id;

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->renderAjax('_gallery_popup', [
            'dataProvider' => $dataProvider,
            'context' => $context,
            'preview' => $preview
        ]);
    }

    public function actionGetMasterFaq($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $faq = SafariOperatorFaq::findOne($id);

        if ($faq) {
            return [
                'success' => true,
                'question' => $faq->question,
                'answer' => $faq->answer,
            ];
        }

        return ['success' => false];
    }


    public function actionUpdateSeat($id)
    {
        $share_safari = ShareSafari::find()->where(['id' => $id, 'status' => 1])->limit(1)->one();
        $m = ShareSafariVersion::find()->where(['share_safari_id' => $share_safari->id, 'version' => $share_safari->live_version])->limit(1)->one();
        $share_seat_model = new ShareSeatForm($m);

        if (Yii::$app->request->isAjax && $share_seat_model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($share_seat_model);
        }

        if ($this->request->isPost) {
            if ($share_seat_model->load($this->request->post()) && $share_seat_model->validate()) {
                $share_seat_model->initializeForm();
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $m->status = ShareSafariVersion::TERMINATED_STATUS;
                    $m->save(false);

                    $share_seat = $share_seat_model->share_seat;
                    $newModel = $this->autoApproval($id, $share_seat);

                    $model = ShareSafari::find()->where(['id' => $newModel->share_safari_id])->one();
                    $model->live_version = $newModel->version;
                    $model->share_seat = $newModel->share_seat;
                    $model->save(false);

                    $model->static_data_json  = $this->prepareJson($model->id);
                    $model->save(false);

                    $share_safari_version = ShareSafariVersion::find()->where(['share_safari_id' => $model->id])->andWhere(['version' => $model->editable_version])->limit(1)->one();
                    if ($share_safari_version) {
                        $share_safari_version->share_seat = $model->share_seat;
                        $share_safari_version->save(false);
                    }

                    Yii::$app->session->setFlash('success', 'Seat Update Successfully');
                } catch (\Exception $e) {
                    Yii::error($e->getMessage());
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'An error occurred while updation: ' . $e->getMessage());
                    echo "<pre>";
                    print_r($e->getMessage());
                    die();
                    return $this->redirect(Yii::$app->request->referrer);
                }
                $transaction->commit();

                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('_seat_update', ['share_seat_model' => $share_seat_model]);
    }


    private function autoApproval($id, $share_seat)
    {
        $model = ShareSafariVersion::findOne($id);
        $last_version = ShareSafariVersion::find()->where(['share_safari_id' => $model->share_safari_id, 'status' => 1])->orderBy(['id' => SORT_DESC])->limit(1)->one();

        if ($model) {

            $newModel = new ShareSafariVersion();
            $newModel->attributes = $model->attributes;
            $this->version = $newModel->version = $last_version->version + 1;
            $newModel->id = null;
            $newModel->status = ShareSafariVersion::APPROVED_AND_LIVE_STATUS;
            $newModel->share_seat = $share_seat;
            $newModel->save(false);

            $this->CopyFixedDepartureDay($model->share_safari_id, $model->version, $newModel->share_safari_id);
            $this->CopyFixedDepartureIncluded($model->share_safari_id, $model->version, $newModel->share_safari_id);;
            $this->CopyFixedDepartureSafariPark($model->share_safari_id, $model->version, $newModel->share_safari_id);
            $this->CopyFixedDepartureFaq($model->share_safari_id, $model->version, $newModel->share_safari_id);

            return $newModel;
        }
        return true;
    }



    private function updateFixedDepartureStatus($share_safari_id, $version, $status)
    {
        $model = ShareSafari::find()->where(['id' => $share_safari_id])->one();
        $share_safari_version = ShareSafariVersion::find()->where(['share_safari_id' => $share_safari_id, 'version' => $version])->one();

        if (empty($model)) {
            $model = new ShareSafari();
            $model->share_safari_title = $share_safari_version->share_safari_title;
        }
        if ($status == ShareSafariVersion::SEND_FOR_APPROVAL_STATUS) {
            $model->pending_for_approval_version = $version;
            $model->edit_status = 2;
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




    public function actionDelete($id)
    {
        $share_safari_version_model = $this->findModel($id);
        if ($share_safari_version_model) {
            $share_safari_version_model->status = ShareSafariVersion::TERMINATED_STATUS;
            if ($share_safari_version_model->save(false)) {
                $model = ShareSafari::find()->where(['id' => $share_safari_version_model->share_safari_id])->one();
                if ($model->status == 10) {
                    $model->status = ShareSafari::STATUS_DELETE;
                }
                $model->edit_status = 0;
                $model->editable_version = null;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Fixed Departure Delete successfully');
                    return $this->redirect(['index']);
                }
            }
        }
        Yii::$app->session->setFlash('error', 'Fixed Departure Not Delete successfully');
        return $this->redirect(['index']);
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


    protected function isFdOwner()
    {
        $id = Yii::$app->request->get('id');

        $operator = $this->module->operatormodel();
        $model = ShareSafariVersion::findOne(['id' => $id]);

        if ($model && $model->safari_operator_id == $operator->id) {
            return true;
        }
        return false;
    }

    protected function isFixedDepartureEditable()
    {
        $id = Yii::$app->request->get('id');
        $model = ShareSafariVersion::findOne(['id' => $id]);
        if ($model) {
            return $model->status == ShareSafariVersion::EDIATBLE_STATUS;
        } else {
            return false;
        }
    }


    public function actionCopyWithEdit($id)
    {

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $newModel = $this->copyWithEditFixedDeparture($id);
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
        return $this->redirect(['update', 'id' => $newModel->share_safari_id]);
    }


    private function copyWithEditFixedDeparture($id, $isNewRecord = false)
    {
        $model = ShareSafari::findOne($id);
        $share_safari_version_model = ShareSafariVersion::find()->where(['share_safari_id' => $model->id, 'version' => $model->live_version])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        $last_version = ShareSafariVersion::find()->where(['share_safari_id' => $model->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();

        if ($model) {
            $newModel = new ShareSafariVersion();
            $newModel->attributes = $share_safari_version_model->attributes;
            $this->version = $newModel->version = $last_version->version + 1;

            $newModel->id = null;
            $newModel->status = ShareSafariVersion::EDIATBLE_STATUS;
            $newModel->save(false);

            $this->CopyFixedDepartureDay($share_safari_version_model->share_safari_id, $share_safari_version_model->version, $newModel->share_safari_id);
            $this->CopyFixedDepartureIncluded($share_safari_version_model->share_safari_id, $share_safari_version_model->version, $newModel->share_safari_id);;
            $this->CopyFixedDepartureSafariPark($share_safari_version_model->share_safari_id, $share_safari_version_model->version, $newModel->share_safari_id);
            $this->CopyFixedDepartureFaq($share_safari_version_model->share_safari_id, $share_safari_version_model->version, $newModel->share_safari_id);


            $model->editable_version = $newModel->version;
            $model->edit_status = 1;
            $model->save(false);

            return $newModel;
        }
        return true;
    }


    public function actionInactive($id)
    {
        $share_safari = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
        if ($share_safari->status == 1) {
            $share_safari->status = 0;
            $share_safari->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Fixed Departure Inactive Successfully');
        } else {
            $share_safari->status = 1;
            $share_safari->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Fixed Departure Active Successfully');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }



    private function CopyFixedDepartureDay($old_share_safari_id, $old_version, $new_share_safari_id)
    {
        $model = ShareSafariDay::find()->where(['share_safari_id' => $old_share_safari_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $day) {
                $newModel = new ShareSafariDay();
                $newModel->attributes = $day->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->share_safari_id = $new_share_safari_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyFixedDepartureIncluded($old_share_safari_id, $old_version, $new_share_safari_id)
    {

        $model = ShareSafariIncluded::find()->where(['share_safari_id' => $old_share_safari_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $included) {
                $newModel = new ShareSafariIncluded();
                $newModel->attributes = $included->attributes;
                $newModel->selection = $included->selection;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->share_safari_id = $new_share_safari_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;
    }


    private function CopyFixedDepartureSafariPark($old_share_safari_id, $old_version, $new_share_safari_id)
    {

        $model = ShareSafariParklist::find()->where(['share_safari_id' => $old_share_safari_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $safari) {
                $newModel = new ShareSafariParklist();
                $newModel->attributes = $safari->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->share_safari_id = $new_share_safari_id;
                $newModel->version = $this->version;
                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyFixedDepartureFaq($old_share_safari_id, $old_version, $new_share_safari_id)
    {
        $model = ShareSafariFaq::find()->where(['share_safari_id' => $old_share_safari_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $faq) {
                $newModel = new ShareSafariFaq();
                $newModel->attributes = $faq->attributes;
                $newModel->id = null;
                $newModel->share_safari_id = $new_share_safari_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;;
    }


    public function prepareJson($id)
    {
        $this->layout = \common\interfaces\NewStatusInterface::SHARE_SAFARI_API_LAYOUT_FULL;

        $share_safari = ApiShareSafari::find()->where(['id' => $id])->limit(1)->one();

        $json = [
            'share_safari' => [
                'share_safari_title' => $share_safari->share_safari_title,
                'slug' => $share_safari->slug,
                'no_of_safari' => $share_safari->no_of_safari,
                'start_date' => $share_safari->start_date,
                'end_date' => $share_safari->end_date,
                'cut_off_date' => $share_safari->cut_off_date,
                'total_seat' => $share_safari->total_seat,
                'share_seat' => $share_safari->share_seat,
                'types' => $share_safari->types,
                'organized_by_name' => $share_safari->organizedbyname,
                'organized_by_image' => $share_safari->organizedbyimage,
                'organized_slug' => $share_safari->organizedslug,
                'shared_image_path' => $share_safari->sharedimagepath,
                'seat_full_status' => $share_safari->seat_full_status,
                'park_title' => $share_safari->park_title,
                'park_slug' => $share_safari->park_slug,
                'cost_per_person' => $share_safari->cost_per_person,
                'breakfast_included' => $share_safari->breakfast_included,
                'lunch_included' => $share_safari->lunch_included,
                'dinner_included' => $share_safari->dinner_included,
                'meal_not_included' => $share_safari->meal_not_included,
                'meals_label' => $share_safari->meals_label,
                'share_safari_inclusion' => $share_safari->share_safari_inclusion,
                'share_safari_exclusion' => $share_safari->share_safari_exclusion,
                'getting_there' => $share_safari->getting_there,
                'safari_plan' => $share_safari->safari_plan,
                'share_safari_agenda' => $share_safari->share_safari_agenda,
                'stay_category_display' => $share_safari->stay_category_display,
                'stay_category_id' => $share_safari->stay_category_id,
                'parks' => ArrayHelper::toArray($share_safari->parks),
                'includeds' => ArrayHelper::toArray($share_safari->includeds),
                'share_safari_days' => ArrayHelper::toArray($share_safari->share_safari_days),
            ],
        ];

        return json_encode($json);
    }
}
