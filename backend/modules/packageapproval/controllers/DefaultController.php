<?php

namespace backend\modules\packageapproval\controllers;

use common\models\master\faq\MasterFaq;
use common\models\package\form\DayItineraryForm;
use common\models\package\form\PackageFaqForm;
use common\models\package\form\PackageVersionForm;
use common\models\package\PackageVersion;
use common\models\package\PackageDay;
use common\models\package\PackageFaq;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageVersionSearch;
use common\models\package\Package;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
        $searchModel = new PackageVersionSearch();
        // $searchModel->status = [Package::APPROVED_AND_LIVE_STATUS,Package::SEND_FOR_status];
        $searchModel->status = PackageVersion::SEND_FOR_APPROVAL_STATUS;
        $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        return $this->render('view', [
            'package' => $model,
            'faqs' => $faqs,
        ]);
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
        if (($model = PackageVersion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApproved($package_id, $version)
    {
        $package = Package::find()->where(['id' => $package_id, 'pending_for_approval_version' => $version])->one();
        if (empty($package)) {
            Yii::$app->session->setFlash('error', 'Package not found.');
            return $this->redirect(['index']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!empty($package->live_version)) {
                $this->terminatePackage($package_id, $package->live_version);
            }
            $model = PackageVersion::find()->where(['package_id' => $package_id, 'version' => $version])->one();

            $package->package_name = $model->package_name;
            $package->owned_by_id = $model->owned_by_id;
            $package->package_agenda_id = $model->package_agenda_id;
            $package->no_of_day = $model->no_of_day;
            $package->no_of_night = $model->no_of_night;
            $package->safari_type = $model->safari_type;
            $package->no_of_safari = $model->no_of_safari;
            $package->start_location = $model->start_location;
            $package->end_location = $model->end_location;
            $package->start_date = $model->start_date;
            $package->end_date = $model->end_date;
            $package->package_image = $model->package_image;
            $package->package_banner_image = $model->package_banner_image;
            $package->stay_category_id = $model->stay_category_id;
            $package->cost_per_person = $model->cost_per_person;
            $package->type = $model->type;
            $package->gst_percentage = $model->gst_percentage;
            $package->total_price = $model->total_price;
            $package->package_description = $model->package_description;
            $package->package_itinerary_overview = $model->package_itinerary_overview;
            $package->package_inclusion = $model->package_inclusion;
            $package->package_exclusion = $model->package_exclusion;
            $package->package_terms_condtition = $model->package_terms_condtition;
            $package->privacy_policy = $model->privacy_policy;
            $package->change_policy = $model->change_policy;
            $package->what_you_must_carry = $model->what_you_must_carry;
            $package->date_change_policy = $model->date_change_policy;
            $package->refund_policy = $model->refund_policy;
            $package->getting_there = $model->getting_there;
            $package->master_vehicle_id = $model->master_vehicle_id;
            $package->cancellation_reason = $model->cancellation_reason;
            $package->breakfast_included = $model->breakfast_included;
            $package->lunch_included = $model->lunch_included;
            $package->dinner_included = $model->dinner_included;
            $package->meal_not_included = $model->meal_not_included;
            $package->popular_package = $model->popular_package;
            $package->refund_policy = $model->refund_policy;
            $package->pending_for_approval_version = null;
            $package->live_version = $version;
            $package->save(false);

            $model->status = PackageVersion::APPROVED_AND_LIVE_STATUS;
            $model->save(false);
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
            Yii::$app->session->setFlash('error', 'Failed to approve package.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $transaction->commit();


        Yii::$app->session->setFlash('success', 'Package approved and Live successfully.');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRejectview($package_id, $version)
    {
        $model = Package::find()->where(['id' => $package_id, 'version' => $version])->one();

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_rejection_form', [
                'package_id' => $package_id,
                'version' => $version,
                'model' => $model
            ]);
        }
    }

    public function actionReject($package_id, $version)
    {
        $package = Package::find()->where(['id' => $package_id, 'pending_for_approval_version' => $version])->one();
        if (empty($package)) {
            Yii::$app->session->setFlash('error', 'Package not found.');
            return $this->redirect(['index']);
        }
        $model = PackageVersion::find()->where(['package_id' => $package_id, 'version' => $version])->one();
        $model->scenario = 'reject';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // $transaction = Yii::$app->db->beginTransaction();
                // try {
                    $package->pending_for_approval_version = null;
                    $package->save(false);

                    $model->status = PackageVersion::NOT_APPROVED_STATUS;
                    $model->cancellation_reason = \Yii::$app->request->post('Package')['cancellation_reason'] ?? NULL;
                    $model->save(false);
                // } catch (\Exception $e) {
                //     Yii::error($e->getMessage());
                //     $transaction->rollBack();
                //     Yii::$app->session->setFlash('error', 'Failed to reject package.');
                //     return $this->redirect(Yii::$app->request->referrer);
                // }
                // $transaction->commit();
                Yii::$app->session->setFlash('success', 'Package rejected successfully.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_rejection_form', [
                'model' => $model,
            ]);
        }
    }


    private function terminatePackage($package_id, $version)
    {
        $model = PackageVersion::find()->where(['package_id' => $package_id, 'version' => $version])->one();
        if ($model) {
            $model->status = PackageVersion::TERMINATED_STATUS;
            $model->save(false);
            return true;
        }
        return false;
    }

    public function actionUpdate($id)
    {

        $package_version_model = $this->findModel($id);
        $model = new PackageVersion($package_version_model);
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
                            PackageSafariPark::deleteAll(['package_package_id' => $model->package_version_model->package_id]);
                            foreach ($package_park as $park) {
                                $packagesafaripark = new PackageSafariPark();
                                $packagesafaripark->package_id = $model->package_version_model->id;
                                $packagesafaripark->package_package_id = $model->package_version_model->package_id;
                                $packagesafaripark->park_id = $park;
                                $packagesafaripark->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Package updated successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->package_version_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'package_version_model' => $package_version_model,
        ]);
    }

    public function actionItinerary($id, $day = 1)
    {
        $package_day_model = $this->findModelDay($id, $day);
        $package_version_model = $this->findModel($id);
        if ($package_day_model) {
            $model = new DayItineraryForm($package_day_model);
        } else {
            $model = new DayItineraryForm();
            $model->package_id = $id;
            $model->no_of_day = $package_version_model->no_of_day;
            $model->day = $day;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->day_image = UploadedFile::getInstance($model, 'day_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_day_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['itinerary', 'id' => $id]);
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

    public function actionInclusion($id)
    {
        $package_version_model = $this->findModel($id);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'inclusion';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->package_version_model->save(false)) {
                            foreach ($model->package_included as $optionId => $selection) {
                                $packageIncluded = PackageIncluded::findOne(['include_id' => $optionId, 'package_id' => $package_version_model->id]);
                                if (!$packageIncluded) {
                                    $packageIncluded = new PackageIncluded();
                                    $packageIncluded->include_id = $optionId;
                                    $packageIncluded->package_id = $package_version_model->id;
                                }
                                $packageIncluded->selection = $selection;
                                if (!$packageIncluded->save()) {
                                    throw new \Exception('Failed to save package inclusion option ' . $optionId);
                                }

                                if ($packageIncluded->include_id == 2 && $packageIncluded->selection == 1) {
                                    $package_days = PackageDay::find()->where(['package_id' => $package_version_model->id, 'status' => 1])->all();
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
                            Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                            return $this->redirect(['inclusion', 'id' => $package_version_model->id]);
                        } else {
                            Yii::$app->session->setFlash('error', 'Failed to update package details.');
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'An error occurred while updating data: ' . $e->getMessage());
                    }
                }
            }
        } else {
            $model->package_version_model->loadDefaultValues();
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

    public function actionPolicyInfo($id)
    {
        $package_version_model = $this->findModel($id);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'policy_info';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_version_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['policy-info', 'id' => $id]);
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


    public function actionGettingThere($id)
    {
        $package_version_model = $this->findModel($id);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'getting_there';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_version_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['getting-there', 'id' => $id]);
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

    public function actionFaq($id)
    {
        $package_version_model = $this->findModel($id);
        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package_version_model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('faq', [
            'package_version_model' => $package_version_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateFaq($id)
    {
        $package_version_model = $this->findModel($id);
        $model = new PackageFaqForm();
        $model->package_id = $package_version_model->id;
        $model->status = PackageFaq::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        $faq = new MasterFaq();
                        $faq->question = $model->question;
                        $faq->answer = $model->answer;
                        $faq->position = 0;
                        $faq->status = MasterFaq::STATUS_ACTIVE;
                        if ($faq->save(false)) {
                            $model->package_faq_model->faq_id = $faq->id;
                            $model->package_faq_model->save(false);
                        }
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['faq', 'id' => $package_version_model->id]);
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
    public function actionUpdateFaq($id, $faq_id)
    {
        $package_version_model = $this->findModel($id);
        $faq_model = PackageFaq::find()->where(['id' => $faq_id])->one();
        $model = new PackageFaqForm($faq_model);
        $model->package_id = $package_version_model->id;
        $model->status = PackageFaq::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        $faq = new MasterFaq();
                        $faq->question = $model->question;
                        $faq->answer = $model->answer;
                        $faq->position = 0;
                        $faq->status = MasterFaq::STATUS_ACTIVE;
                        if ($faq->save(false)) {
                            $model->package_faq_model->faq_id = $faq->id;
                            $model->package_faq_model->save(false);
                        }
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['faq', 'id' => $package_version_model->id]);
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

    protected function findModelDay($id, $day)
    {
        if (($model = PackageDay::findOne(['package_id' => $id, 'day' => $day, 'status' => [PackageDay::STATUS_ACTIVE, PackageDay::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
    }
}
