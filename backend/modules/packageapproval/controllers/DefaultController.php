<?php

namespace backend\modules\packageapproval\controllers;

use api\models\package\Package as ApiPackage;
use common\models\master\faq\MasterFaq;
use common\models\package\form\DayItineraryForm;
use common\models\package\form\PackageDiscountForm;
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
use yii\helpers\ArrayHelper;
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
        $searchModel->package_id = $model->package_id;
        $searchModel->version = $model->version;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        return $this->render('view', [
            'package' => $model,
            'faqs' => $faqs,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = PackageVersion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }

    public function actionApproved($package_id, $version)
    {
        $package = Package::find()->where(['id' => $package_id, 'pending_for_approval_version' => $version])->one();
        if (empty($package)) {
            $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            \Yii::$app->session->setFlash('success', $message);
            return $this->redirect(['index']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!empty($package->live_version)) {
                $this->terminatePackage($package_id, $package->live_version);
            }
            $model = PackageVersion::find()->where(['package_id' => $package_id, 'version' => $version])->one();

            $package->package_name = $model->package_name;
            $package->safari_operator_id = $model->safari_operator_id;
            $package->user_id = $model->user_id;
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
            $package->original_image_filename = $model->original_image_filename;
            $package->original_banner_filename = $model->original_banner_filename;
            $package->stay_category_id = $model->stay_category_id;
            $package->cost_per_person = $model->cost_per_person;
            $package->cost_per_two_person = $model->cost_per_two_person;
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
            $package->max_booking_date = $model->max_booking_date;
            $package->partner_gallery_id = $model->partner_gallery_id;
            $package->gallery_json = $model->gallery_json;
            $package->gallery_version = $model->gallery_version;
            $package->status = Package::STATUS_ACTIVE;
            $package->edit_status = 0;
            $package->pending_status = 0;
            $package->retail_price = $model->retail_price;
            $package->tag_type = $model->tag_type;
            $package->master_package_tag_id = $model->master_package_tag_id;
            $package->custom_package_tag = $model->custom_package_tag;
            $package->custom_package_tag_color = $model->custom_package_tag_color;
            $package->custom_activity_message = $model->custom_activity_message;
            $package->custom_price_message = $model->custom_price_message;
            $package->cost_per_person_strike_off = $model->cost_per_person_strike_off;
            $package->save(false);

            $package->static_json = $this->prepareJson($package->id);
            $package->save(false);

            $model->status = PackageVersion::APPROVED_AND_LIVE_STATUS;
            $model->cancellation_reason = null;
            $model->final_approved_at = time();

            $model->save(false);
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            $message = Yii::$app->messageManager->getMessage('common.send_for_approval_failed');
            Yii::$app->session->setFlash('error', $message . '' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
            $message = Yii::$app->messageManager->getMessage('common.failed_to_approve', ['{var}' => 'Package']);
            \Yii::$app->session->setFlash('error', $message);
            return $this->redirect(['index']);
        }
        $transaction->commit();


        $message = Yii::$app->messageManager->getMessage('common.approved_and_live', ['{var}' => 'Package']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(['index']);
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
            $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            \Yii::$app->session->setFlash('success', $message);
            return $this->redirect(['index']);
        }
        $model = PackageVersion::find()->where(['package_id' => $package_id, 'version' => $version])->one();
        $model->scenario = 'reject';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $package->pending_for_approval_version = null;
                $package->pending_status = 0;
                $package->save(false);
                $model->status = PackageVersion::NOT_APPROVED_STATUS;
                $model->cancellation_reason = \Yii::$app->request->post('PackageVersion')['cancellation_reason'] ?? NULL;
                $model->save(false);
                $message = Yii::$app->messageManager->getMessage('common.rejected', ['{var}' => 'Package']);
                \Yii::$app->session->setFlash('success', $message);
                return $this->redirect(['index']);
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
                            PackageFeature::deleteAll(['package_id' => $model->package_version_model->package_id, 'version' => $model->package_version_model->version]);
                            foreach ($package_feature as $feature) {
                                $packagefeature = new PackageFeature();
                                $packagefeature->package_id = $model->package_version_model->package_id;
                                $packagefeature->version = $model->package_version_model->version;
                                $packagefeature->feature_id = $feature;
                                $packagefeature->save(false);
                            }
                        }



                        $package_park = $model->package_park;
                        if ($package_park) {
                            PackageSafariPark::deleteAll(['package_id' => $model->package_version_model->package_id, 'version' => $model->package_version_model->version]);
                            foreach ($package_park as $park) {
                                $packagesafaripark = new PackageSafariPark();
                                $packagesafaripark->package_id = $model->package_version_model->package_id;
                                $packagesafaripark->version = $model->package_version_model->version;
                                $packagesafaripark->park_id = $park;
                                $packagesafaripark->save(false);
                            }
                        }

                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Package']);
                        \Yii::$app->session->setFlash('success', $message);
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
        $package_version_model = $this->findModel($id);
        $package_day_model = $this->findModelDay($package_version_model->package_id, $package_version_model->version, $day);
        if ($package_day_model) {
            $model = new DayItineraryForm($package_day_model);
        } else {
            $model = new DayItineraryForm();
            $model->package_id = $package_version_model->package_id;
            $model->version = $package_version_model->version;
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
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
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
                                $packageIncluded = PackageIncluded::findOne(['include_id' => $optionId, 'package_id' => $package_version_model->package_id, 'version' => $package_version_model->version]);
                                if (!$packageIncluded) {
                                    $packageIncluded = new PackageIncluded();
                                    $packageIncluded->include_id = $optionId;
                                    $packageIncluded->package_id = $package_version_model->package_id;
                                    $packageIncluded->version = $package_version_model->version;
                                }
                                $packageIncluded->selection = $selection;
                                if (!$packageIncluded->save()) {
                                    throw new \Exception('Failed to save package inclusion option ' . $optionId);
                                }

                                if ($packageIncluded->include_id == 2 && $packageIncluded->selection == 1) {
                                    $package_days = PackageDay::find()->where(['package_id' => $package_version_model->package_id, 'version' => $package_version_model->version, 'status' => 1])->all();
                                    if ($package_days) {
                                        foreach ($package_days as $package_day) {
                                            $package_day->package_id = $package_version_model->package_id;
                                            $package_day->version = $package_version_model->version;
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
                            \Yii::$app->session->setFlash('success', $message);
                            return $this->redirect(['inclusion', 'id' => $package_version_model->id]);
                        } else {
                            $message = Yii::$app->messageManager->getMessage('common.update_failed', ['{var}' => 'Package']);
                            \Yii::$app->session->setFlash('error', $message);
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        $message = Yii::$app->messageManager->getMessage('common.send_for_approval_failed');
                        Yii::$app->session->setFlash('error', $message . '' . $e->getMessage());
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
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
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
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
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
        $searchModel->package_id = $package_version_model->package_id;
        $searchModel->version = $package_version_model->version;
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
        $model->package_id = $package_version_model->package_id;
        $model->version = $package_version_model->version;
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
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Data Submitted ']);
                        \Yii::$app->session->setFlash('success', $message);
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
        $model->package_id = $package_version_model->package_id;
        $model->version = $package_version_model->version;
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
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Data Submitted ']);
                        \Yii::$app->session->setFlash('success', $message);
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

    protected function findModelDay($id, $version, $day)
    {
        if (($model = PackageDay::find()->andWhere(['package_id' => $id, 'version' => $version, 'day' => $day, 'status' => [PackageDay::STATUS_ACTIVE, PackageDay::STATUS_SUSPEND]])->one()) !== null) {
            return $model;
        }
    }


    public function prepareJson($id)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PACKAGE_API_LAYOUT_FULL;
        $package = ApiPackage::find()->where(['id' => $id])->limit(1)->one();


        $json = [
            'package' => [
                'package_display_name' => $package->package_display_name,
                'package_name' => $package->package_name,
                'package_slug' => $package->package_slug,
                'primary_park' => $package->primary_park,
                'primary_park_slug' => $package->primary_park_slug,
                'no_of_day' => $package->no_of_day,
                'no_of_night' => $package->no_of_night,
                'no_of_safari' => $package->no_of_safari,
                'cost_per_person' => (int) ceil($package->cost_per_person),
                'cost_per_two_person' => (int) ceil($package->cost_per_two_person),
                'retail_price' => (int) ceil($package->retail_price),
                'total_price' => (int) ceil($package->total_price),

                'package_description' => $package->package_description,
                'image_path' => $package->image_path,
                'image_banner_path' => $package->image_banner_path,
                'package_day_night_labels' => $package->package_day_night_labels,
                'pick_and_drop' => $package->pick_and_drop,
                'pick_and_drop_display' => $package->pick_and_drop_display,
                'stay_category_id' => $package->stay_category_id,
                'stay_category_display' => $package->stay_category_display,
                'meals_listing' => $package->meals_listing,
                'breakfast_included' => (bool) $package->breakfast_included,
                'lunch_included' => (bool) $package->lunch_included,
                'dinner_included' => (bool) $package->dinner_included,
                'meal_not_included' => (bool) $package->meal_not_included,
                'start_location' => $package->start_location,
                'end_location' => $package->end_location,
                'start_date' => $package->start_date,
                'end_date' => $package->end_date,
                'package_itinerary_overview' => $package->package_itinerary_overview,
                'package_inclusion' => $package->package_inclusion,
                'package_exclusion' => $package->package_exclusion,
                'getting_there' => $package->getting_there,
                'meals' => $package->meals,
                'meals_label' => $package->meals_label,
                'type' => $package->type,
                'master_vehicle_id' => $package->master_vehicle_id,
                'safari_type' => $package->safari_type,
                'gst_percentage' => $package->gst_percentage,
                'package_agenda_id' => $package->package_agenda_id,
                'max_booking_date' => $package->max_booking_date,

                'package_park' => ArrayHelper::toArray($package->package_park),
                'master_package_with_included' => ArrayHelper::toArray($package->master_package_with_included),
                'package_days' => ArrayHelper::toArray($package->package_days),
                'faqs' => ArrayHelper::toArray($package->faqs),
                'package_features_name' => ArrayHelper::toArray($package->package_features_name),

                'partner_gallery_id' => $package->partner_gallery_id,
                'gallery_json' => $package->gallery_json,
                'gallery_version' => $package->gallery_version,

                'tag_type' => $package->tag_type,
                'master_package_tag_id' => $package->master_package_tag_id,
                'custom_package_tag' => $package->custom_package_tag,
                'custom_package_tag_color' => $package->custom_package_tag_color,
                'custom_activity_message' => $package->custom_activity_message,
                'custom_price_message' => $package->custom_price_message,
                'cost_per_person_strike_off' => $package->cost_per_person_strike_off,
            ],
        ];

        return json_encode($json);
    }
}
