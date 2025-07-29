<?php

namespace business\modules\sharesafari\controllers;

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
                'only' => ['index', 'view', 'create', 'update', 'itinerary', 'inclusion', 'policy-info', 'getting-there', 'faq', 'create-faq', 'update-faq', 'send-for-approval'],
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'copy-fixed-departure'],
                        'allow' => $this->isFdOwner(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update', 'itinerary', 'inclusion', 'policy-info', 'getting-there', 'faq', 'create-faq', 'update-faq', 'send-for-approval'],
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
        $searchModel = new ShareSafariVersionSearch();
        $searchModel->status = [ShareSafariVersion::EDIATBLE_STATUS, ShareSafariVersion::SEND_FOR_APPROVAL_STATUS];
        // $searchModel->status = [ShareSafariVersion::EDIATBLE_STATUS];
        $searchModel->host_partner_id = $safari_operator->id;
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

        $model->host_user_id =  null;
        $model->host_partner_id =  $safari_operator->id;
        $model->user_id =  Yii::$app->user->identity->id;

        $model->type = 2;
        $model->host_type = 3;

        $model->status = ShareSafariVersion::EDIATBLE_STATUS;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_version_model->save()) {
                        $model->uploadFile();
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

        if ($model && $model->host_partner_id == $operator->id) {
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
            $model->share_safari_title = $share_safari_version->share_safari_title;
        }
        if ($status == ShareSafariVersion::SEND_FOR_APPROVAL_STATUS) {
            $model->pending_for_approval_version = $version;
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
            // $this->copyFixedDeparture($id);
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

    public function actionCopyFixedDeparture($id)
    {

        $m = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $this->copyFixedDeparture($id, true);
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


    private function copyFixedDeparture($id, $isNewRecord = false)
    {
        $model = ShareSafariVersion::findOne($id);

        if ($model) {
            $newModel = new ShareSafariVersion();
            $newModel->attributes = $model->attributes;
            $this->version = $newModel->version = $model->version + 1;

            if ($isNewRecord) {
                $newModel->share_safari_id = $this->newFixedDeparture($model);
                $this->version =  $newModel->version = 1;
            }
            $newModel->id = null; // Set the ID to null for the new record
            $newModel->status = ShareSafariVersion::EDIATBLE_STATUS;
            $newModel->save(false);
            if (!$isNewRecord) {

                // $this->CopyFixedDepartureComment($model->share_safari_id, $model->version, $newModel->share_safari_id);
            }
            $this->CopyFixedDepartureDay($model->share_safari_id, $model->version, $newModel->share_safari_id);
            $this->CopyFixedDepartureIncluded($model->share_safari_id, $model->version, $newModel->share_safari_id);;
            $this->CopyFixedDepartureSafariPark($model->share_safari_id, $model->version, $newModel->share_safari_id);
            $this->CopyFixedDepartureFaq($model->share_safari_id, $model->version, $newModel->share_safari_id);
            $this->updateFixedDepartureStatus($newModel->share_safari_id, $newModel->version, ShareSafariVersion::EDIATBLE_STATUS);

            return $newModel;
        }
        return true;
    }

    private function newFixedDeparture($model)
    {
        $newModel = new ShareSafari();
        $newModel->share_safari_title = $model->share_safari_title;
        $newModel->slug = ShareSafari::generateUnqiueSlug($newModel->share_safari_title);
        $newModel->editable_version = 1;
        $newModel->id = null;
        $newModel->status = ShareSafari::STATUS_SUSPEND;
        $newModel->save(false);
        return $newModel->id;
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

        $m = $this->findModel($id);
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
        $last_version = ShareSafariVersion::find()->where(['share_safari_id' => $model->share_safari_id])->orderBy(['id' => SORT_DESC])->limit(1)->one();

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

    // public function actionCopyWithEdit($id)
    // {
    //     $m = $this->findModel($id);
    //     $transaction = Yii::$app->db->beginTransaction();
    //     try {
    //         $newModel = $this->copyWithEditFixedDeparture($id);
    //     } catch (\Exception $e) {
    //         Yii::error($e->getMessage());
    //         $transaction->rollBack();
    //         Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
    //         echo "<pre>";
    //         print_r($e->getMessage());
    //         die();
    //         return $this->redirect(Yii::$app->request->referrer);
    //     }
    //     $transaction->commit();
    //     return $this->redirect(['update', 'id' => $newModel->id]);
    // }


    // private function copyWithEditFixedDeparture($id, $isNewRecord = false)
    // {
    //     $model = ShareSafariVersion::findOne($id);

    //     if ($model) {
    //         $newModel = new ShareSafariVersion();
    //         $newModel->attributes = $model->attributes;
    //         $this->version = $newModel->version = $model->version + 1;

    //         $newModel->id = null;
    //         $newModel->status = ShareSafariVersion::EDIATBLE_STATUS;
    //         $newModel->save(false);

    //         $this->CopyFixedDepartureDay($model->share_safari_id, $model->version, $newModel->share_safari_id);
    //         $this->CopyFixedDepartureIncluded($model->share_safari_id, $model->version, $newModel->share_safari_id);;
    //         $this->CopyFixedDepartureSafariPark($model->share_safari_id, $model->version, $newModel->share_safari_id);
    //         $this->CopyFixedDepartureFaq($model->share_safari_id, $model->version, $newModel->share_safari_id);
    //         // $this->updateFixedDepartureStatus($newModel->share_safari_id, $newModel->version, ShareSafariVersion::EDIATBLE_STATUS);
    //         $model = ShareSafari::find()->where(['id' => $newModel->share_safari_id])->one();
    //         $model->editable_version = $newModel->version;
    //         $model->save(false);

    //         return $newModel;
    //     }
    //     return true;
    // }

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

}
