<?php

namespace backend\modules\package\controllers;

use common\interfaces\StatusInterface;
use common\models\master\faq\MasterFaq;
use common\models\package\form\DayItineraryForm;
use common\models\package\form\PackageFaqForm;
use common\models\package\form\PackageFaqSelectForm;
use common\models\package\form\PackageVersionForm;
use common\models\package\form\PackageGalleryForm;
use common\models\package\Package;
use common\models\package\PackageVersion;
use common\models\package\PackageDay;
use common\models\package\PackageEnquiry;
use common\models\package\PackageFaq;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use common\models\package\PackageGallery;
use common\models\package\PackageGallerySearch;
use common\models\package\PackageIncluded;
use common\models\package\PackageQuoteSearch;
use common\models\package\PackageSafariPark;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProfileController.
 */
class ProfileController extends Controller
{
    public function actionIndex($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_image = UploadedFile::getInstance($model, 'package_image');
                $model->package_banner_image = UploadedFile::getInstance($model, 'package_banner_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_version_model->save(false)) {
                        $model->uploadFile();

                        $package_feature = $model->package_feature;
                        if ($package_feature) {
                            PackageFeature::deleteAll(['package_id' => $model->package_version_model->id]);
                            foreach ($package_feature as $feature) {
                                $packagefeature = new PackageFeature();
                                $packagefeature->package_id = $model->package_version_model->id;
                                $packagefeature->feature_id = $feature;
                                $packagefeature->save(false);
                            }
                        }



                        $package_park = $model->package_park;
                        if ($package_park) {
                            PackageSafariPark::deleteAll(['package_id' => $model->package_version_model->id]);
                            foreach ($package_park as $park) {
                                $packagesafaripark = new PackageSafariPark();
                                $packagesafaripark->package_id = $model->package_version_model->id;
                                $packagesafaripark->park_id = $park;
                                $packagesafaripark->save(false);
                            }
                        }
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_version_model->loadDefaultValues();
        }

        return $this->render('index', [
            'model' => $model,
            'package_version_model' => $package_version_model,
        ]);
    }


    public function actionPolicyInfo($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'policy_info';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_version_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['policy-info', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_version_model->loadDefaultValues();
        }

        return $this->render('policy_info', [
            'model' => $model,
            'package_version_model' => $package_version_model,
        ]);
    }


    public function actionGettingThere($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'getting_there';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_version_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['getting-there', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_version_model->loadDefaultValues();
        }

        return $this->render('getting_there', [
            'model' => $model,
            'package_version_model' => $package_version_model,
        ]);
    }


    public function actionInclusion($package_id)
    {
        // Find the package model based on $package_id
        $package_version_model = $this->findModel($package_id);

        // Instantiate PackageVersionForm using the found package model
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'inclusion'; // Set scenario to 'inclusion' for validation purposes

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Validate and save package model
                if ($model->validate()) {
                    $model->initializeForm();

                    // Save the package model first
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->package_version_model->save(false)) {
                            // Save package inclusion options
                            foreach ($model->package_included as $optionId => $selection) {
                                // Check if option exists, and update or create as needed
                                $packageIncluded = PackageIncluded::findOne(['include_id' => $optionId, 'package_id' => $package_id]);
                                if (!$packageIncluded) {
                                    $packageIncluded = new PackageIncluded();
                                    $packageIncluded->include_id = $optionId;
                                    $packageIncluded->package_id = $package_id;
                                }
                                $packageIncluded->selection = $selection;
                                if (!$packageIncluded->save()) {
                                    throw new \Exception('Failed to save package inclusion option ' . $optionId);
                                }

                                if ($packageIncluded->include_id == 2 && $packageIncluded->selection == 1) {
                                    $package_days = PackageDay::find()->where(['package_id' => $package_id, 'status' => 1])->all();
                                    if ($package_days) {
                                        foreach ($package_days as $package_day) {
                                            $package_day->meal_breakfast = 1;
                                            $package_day->meal_lunch = 1;
                                            $package_day->meal_dinner = 1;
                                            $package_day->save();
                                        }
                                    }
                                }
                            }

                            $transaction->commit();
                            $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                            Yii::$app->session->setFlash('success', $message);
                            return $this->redirect(['inclusion', 'package_id' => $package_id]);
                        } else {
                            $message = Yii::$app->messageManager->getMessage('common.failed_to', ['{var}' => 'update package details']);
                            Yii::$app->session->setFlash('error', $message);
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        $message = Yii::$app->messageManager->getMessage('common.error_occurred');
                        Yii::$app->session->setFlash('error', $message.': ' . $e->getMessage());
                    }
                }
            }
        } else {
            // Populate the form with existing data
            $model->package_version_model->loadDefaultValues(); // Ensure package model has default values

            // Fetch related package inclusion options
            $includedOptions = [];
            foreach ($package_version_model->packageIncludeds as $includedOption) {
                $includedOptions[$includedOption->include_id] = $includedOption->selection;
            }
            $model->package_included = $includedOptions;
        }

        return $this->render('inclusion', [
            'model' => $model,
            'package_version_model' => $package_version_model,
        ]);
    }





    public function actionItinerary($package_id, $day = 1)
    {
        $package_day_model = $this->findModelDay($package_id, $day);
        $package_version_model = Package::findOne(['id' => $package_id]);
        if ($package_day_model) {
            $model = new DayItineraryForm($package_day_model);
        } else {
            $model = new DayItineraryForm();
            $model->package_id = $package_id;
            $model->no_of_day = $package_version_model->no_of_day;
            $model->day = $day;
        }
        // Validate and save each day's itinerary entries

        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $model->day_image = UploadedFile::getInstance($model, 'day_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_day_model->save(false)) {
                        $model->uploadFile();
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['itinerary', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_day_model->loadDefaultValues();
        }

        return $this->render('itinerary', [
            'package_version_model' => $package_version_model,
            'model' => $model,
        ]);
    }

    public function actionFaq($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('faq', [
            'package_version_model' => $package_version_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionCreateFaq($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $model = new PackageFaqForm();
        $model->package_id = $package_id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        $faq = new MasterFaq();
                        $faq->question = $model->question;
                        $faq->answer = $model->answer;
                        $faq->position = 0;
                        $faq->status = StatusInterface::STATUS_ACTIVE;
                        if ($faq->save(false)) {
                            $model->package_faq_model->faq_id = $faq->id;
                            $model->package_faq_model->save(false);
                        }
                        $message = Yii::$app->messageManager->getMessage('common.submitted', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['faq', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'package_version_model' => $package_version_model,
            ]);
        }
    }


    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionUpdateFaq($package_id, $faq_id)
    {
        $package_version_model = $this->findModel($package_id);
        $faq_model = PackageFaq::find()->where(['id' => $faq_id])->one();
        $model = new PackageFaqForm($faq_model);
        $model->package_id = $package_id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        $faq = new MasterFaq();
                        $faq->question = $model->question;
                        $faq->answer = $model->answer;
                        $faq->position = 0;
                        $faq->status = StatusInterface::STATUS_ACTIVE;
                        if ($faq->save(false)) {
                            $model->package_faq_model->faq_id = $faq->id;
                            $model->package_faq_model->save(false);
                        }
                        $message = Yii::$app->messageManager->getMessage('common.submitted', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['faq', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'package_version_model' => $package_version_model,
            ]);
        }
    }

    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionSelectFaq($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $model = new PackageFaqSelectForm();
        $model->package_id = $package_id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_select_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.submitted', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['faq', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_faq_select_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('select_faq', [
                'model' => $model,
                'package_version_model' => $package_version_model,
            ]);
        }
    }



    public function actionQuote($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $searchModel = new PackageQuoteSearch();
        $searchModel->package_id = $package_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('quote', [
            'package_version_model' => $package_version_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }




    public function actionGallery($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $searchModel = new PackageGallerySearch();
        $searchModel->package_id = $package_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('gallery', [
            'package_version_model' => $package_version_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateGallery($package_id, $id = null)
    {
        $package_version_model = $this->findModel($package_id);
        if ($id) {
            $package_gallery_model = $this->findModelgallery($id);
            $model = new PackageGalleryForm($package_gallery_model);
        } else {
            $model = new PackageGalleryForm();
            $model->package_id = $package_id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_gallery_model->save(false)) {
                        $model->uploadFile();
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['gallery', 'package_id' => $package_id]);
                    }
                }
            }
        } else {
            $model->package_gallery_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_gallery', [
                'model' => $model,
                'package_version_model' => $package_version_model,
            ]);
        }
    }

    public function actionBookNow($package_id)
    {
        $package_version_model = $this->findModel($package_id);
        $enquiries = PackageEnquiry::find()->where(['package_id' => $package_id, 'status' => 1]);

        $enquire_provider = new ActiveDataProvider([
            'query' => $enquiries,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('book_now', [
            'package_version_model' => $package_version_model,
            'enquire_provider' => $enquire_provider,

        ]);
    }

    public function actionActive($id)
    {
        $model = PackageFaq::find()->where(['id' => $id])->limit(1)->one();
        $model->status = PackageFaq::STATUS_ACTIVE;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    /**
     * Suspend Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionSuspend($id)
    {
        $model = PackageFaq::find()->where(['id' => $id])->limit(1)->one();
        $model->status = PackageFaq::STATUS_SUSPEND;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }
    /**
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Package::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }

    protected function findModelfaq($id)
    {
        if (($model = PackageFaq::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }

    protected function findModelgallery($id)
    {
        if (($model = PackageGallery::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }


    protected function findModelDay($package_id, $day)
    {
        if (($model = PackageDay::findOne(['package_id' => $package_id, 'day' => $day, 'status' => [PackageDay::STATUS_ACTIVE, PackageDay::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
    }
}
