<?php

namespace frontend\modules\manage\controllers;

use Yii;
use yii\web\UploadedFile;
use common\models\MailLog;
use common\models\GeneralModel;
use yii\data\ActiveDataProvider;
use common\models\package\Package;
use yii\web\NotFoundHttpException;
use common\models\package\PackageDay;
use common\models\package\PackageFaq;
use common\models\master\faq\MasterFaq;
use common\models\package\PackageSearch;
use common\interfaces\NewStatusInterface;
use common\models\package\PackageComment;
use common\models\package\PackageEnquiry;
use common\models\package\PackageFeature;
use common\models\package\PackageGallery;
use common\models\package\PackageIncluded;
use common\models\package\form\PackageForm;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageSafariPark;
use common\models\package\PackageQuoteSearch;
use common\models\package\form\PackageFaqForm;
use common\models\package\PackageCommentReport;
use common\models\package\PackageGallerySearch;
use common\models\package\form\DayItineraryForm;
use frontend\controllers\FrontendBaseController;
use common\models\sharesafari\ShareSafariComment;
use common\models\package\form\PackageGalleryForm;
use common\models\package\form\PackageFaqSelectForm;
use common\models\package\form\PackageCommentActionForm;

/**
 * Default controller for the `manage` module
 */
class PackageController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->managesearch($this->request->queryParams, [
            'owned_by_id' => $safari_operator->id
        ]);
        return $this->render('index', [
            'safari_operator' => $safari_operator,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Create SeatType.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        
        $safari_operator = $this->module->operatormodel();
        $model = new PackageForm();
        $model->status = Package::STATUS_ACTIVE;
        $model->owned_by_id = $safari_operator->id;
        $model->scenario = 'create';


        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_image = UploadedFile::getInstance($model, 'package_image');
                $model->package_banner_image = UploadedFile::getInstance($model, 'package_banner_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_model->save()) {
                        $model->uploadFile();

                        $package_feature = $model->package_feature;
                        if ($package_feature) {
                            PackageFeature::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_feature as $feature) {
                                $packagefeature = new PackageFeature();
                                $packagefeature->package_id = $model->package_model->id;
                                $packagefeature->feature_id = $feature;
                                $packagefeature->save(false);
                            }
                        }


                        $package_park = $model->package_park;
                        if ($package_park) {
                            PackageSafariPark::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_park as $park) {
                                $packagesafaripark = new PackageSafariPark();
                                $packagesafaripark->package_id = $model->package_model->id;
                                $packagesafaripark->park_id = $park;
                                $packagesafaripark->save(false);
                            }
                        }

                        // Send Email to Admin
                        $to_mail = Yii::$app->params['adminEmail'];
                        $subject = 'New Package Created | ' . substr($model->package_model->package_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_OPERATOR_CREATED_NEW_PACKAGE;
                        $package_url = Yii::$app->urlManager->createAbsoluteUrl(['/package/default/view', 'slug' => $model->package_model->package_slug, 'operator_slug' => $safari_operator->slug]);

                        $req = ['package' => $model->package_model->attributes, 'package_url' => $package_url, 'operator_name' => $safari_operator->business_name];
                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        }
                        \Yii::$app->session->setFlash('success', 'Package create successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->package_model->loadDefaultValues();
        }



        return $this->render('create', [
            'model' => $model,
            'safari_operator' => $safari_operator,
        ]);
    }


    public function actionUpdate($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageForm($package_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_image = UploadedFile::getInstance($model, 'package_image');
                $model->package_banner_image = UploadedFile::getInstance($model, 'package_banner_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_model->save(false)) {
                        $model->uploadFile();

                        $package_feature = $model->package_feature;
                        if ($package_feature) {
                            PackageFeature::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_feature as $feature) {
                                $packagefeature = new PackageFeature();
                                $packagefeature->package_id = $model->package_model->id;
                                $packagefeature->feature_id = $feature;
                                $packagefeature->save(false);
                            }
                        }



                        $package_park = $model->package_park;
                        if ($package_park) {
                            PackageSafariPark::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_park as $park) {
                                $packagesafaripark = new PackageSafariPark();
                                $packagesafaripark->package_id = $model->package_model->id;
                                $packagesafaripark->park_id = $park;
                                $packagesafaripark->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Package updated successfully');
                        return $this->redirect(['update', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->package_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }

    public function actionPolicyInfo($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageForm($package_model);
        $model->scenario = 'policy_info';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Policy information updated successfully');
                        return $this->redirect(['policy-info', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->package_model->loadDefaultValues();
        }

        return $this->render('policy_info', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }


    public function actionGettingThere($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageForm($package_model);
        $model->scenario = 'getting_there';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Getting there updated successfully');
                        return $this->redirect(['getting-there', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->package_model->loadDefaultValues();
        }

        return $this->render('getting_there', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }

    public function actionInclusion($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageForm($package_model);
        $model->scenario = 'inclusion';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->package_model->save(false)) {
                            foreach ($model->package_included as $optionId => $selection) {
                                $packageIncluded = PackageIncluded::findOne(['include_id' => $optionId, 'package_id' => $package_model->id]);
                                if (!$packageIncluded) {
                                    $packageIncluded = new PackageIncluded();
                                    $packageIncluded->include_id = $optionId;
                                    $packageIncluded->package_id = $package_model->id;
                                }
                                $packageIncluded->selection = $selection;
                                if (!$packageIncluded->save()) {
                                    throw new \Exception('Failed to save package inclusion option ' . $optionId);
                                }

                                if ($packageIncluded->include_id == 2 && $packageIncluded->selection == 1) {
                                    $package_days = PackageDay::find()->where(['package_id' => $package_model->id, 'status' => PackageDay::STATUS_ACTIVE])->all();
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
                            Yii::$app->session->setFlash('success', 'Inclusion updated successfully');
                            return $this->redirect(['inclusion', 'slug' => $slug]);
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

            $model->package_model->loadDefaultValues();
            $includedOptions = [];
            foreach ($package_model->packageIncludeds as $includedOption) {
                $includedOptions[$includedOption->include_id] = $includedOption->selection;
            }
            $model->package_included = $includedOptions;
        }

        return $this->render('inclusion', [
            'model' => $model,
            'package_model' => $package_model,
        ]);
    }

    public function actionItinerary($slug, $day = 1)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_day_model = $this->findModelDay($package_model->id, $day);
        if ($package_day_model) {
            $model = new DayItineraryForm($package_day_model);
        } else {
            $model = new DayItineraryForm();
            $model->package_id = $package_model->id;
            $model->no_of_day = $package_model->no_of_day;
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
                        \Yii::$app->session->setFlash('success', 'Itinerary updated successfully');
                        return $this->redirect(['itinerary', 'slug' => $slug, 'day' => $day]);
                    }
                }
            }
        } else {
            $model->package_day_model->loadDefaultValues();
        }

        return $this->render('itinerary', [
            'package_model' => $package_model,
            'model' => $model,
        ]);
    }

    public function actionFaq($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package_model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('faq', [
            'package_model' => $package_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionCreateFaq($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageFaqForm();
        $model->package_id =  $package_model->id;
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
                        $faq->status = NewStatusInterface::STATUS_ACTIVE;
                        if ($faq->save(false)) {
                            $model->package_faq_model->faq_id = $faq->id;
                            $model->package_faq_model->save(false);
                        }
                        \Yii::$app->session->setFlash('success', 'Faq created successfully');
                        return $this->redirect(['faq', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'package_model' => $package_model,
            ]);
        }
    }



    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionUpdateFaq($slug, $faq_id)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $faq_model = PackageFaq::find()->where(['id' => $faq_id])->one();
        $model = new PackageFaqForm($faq_model);
        $model->package_id = $package_model->id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        $faq = new MasterFaq();
                        $faq->question = $model->question;
                        $faq->answer = $model->answer;
                        $faq->position = 0;
                        $faq->status = NewStatusInterface::STATUS_ACTIVE;
                        if ($faq->save(false)) {
                            $model->package_faq_model->faq_id = $faq->id;
                            $model->package_faq_model->save(false);
                        }
                        \Yii::$app->session->setFlash('success', 'Faq updated successfully');
                        return $this->redirect(['faq', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'package_model' => $package_model,
            ]);
        }
    }

    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionSelectFaq($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageFaqSelectForm();
        $model->package_id = $package_model->id;
        $model->status = PackageFaq::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_select_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data submitted successfully');
                        return $this->redirect(['faq', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->package_faq_select_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('select_faq', [
                'model' => $model,
                'package_model' => $package_model,
            ]);
        }
    }



    // public function actionView($package_id)
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     $package_model = $this->findModel($package_id, $safari_operator->id);
    //     $searchModel = new PackageQuoteSearch();
    //     $searchModel->package_id = $package_id;
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //     $model = $dataProvider->getModels();

    //     return $this->render('view', [
    //         'package_model' => $package_model,
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //         'model' => $model,
    //     ]);
    // }

    // public function actionComment($package_id)
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     $package_model = $this->findModel($package_id, $safari_operator->id);
    //     $dataProvider = new ActiveDataProvider([
    //         'query' =>  PackageComment::find()->where(['package_id' => $package_id, 'status' => PackageComment::STATUS_ACTIVE])->andWhere(['parent_id' => null]),
    //         'pagination' => [
    //             'pageSize' => 20,
    //         ],
    //     ]);
    //     return $this->render('comment', [
    //         'package_model' => $package_model,
    //         'dataProvider' => $dataProvider,

    //     ]);
    // }


    // public function actionReplies($id)
    // {
    //     $comment = PackageComment::find()->where(['id' => $id, 'status' => PackageComment::STATUS_ACTIVE])->limit(1)->one();
    //     $safari_operator = $this->module->operatormodel();
    //     $package_model = $this->findModel($comment->package_id, $safari_operator->id);
    //     $dataProvider = new ActiveDataProvider([
    //         'query' =>  $comment->getReplies()->where(['status' =>  PackageComment::STATUS_ACTIVE]),
    //         'pagination' => [
    //             'pageSize' => 20,
    //         ],
    //     ]);
    //     return $this->renderAjax('replies', [
    //         'package_model' => $package_model,
    //         'dataProvider' => $dataProvider,

    //     ]);
    // }

    // public function actionBookNow($package_id)
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     $package_model = $this->findModel($package_id, $safari_operator->id);
    //     $enquiries = PackageEnquiry::find()->where(['package_id' => $package_id, 'status' => 1]);
    //     $enquire_provider = new ActiveDataProvider([
    //         'query' => $enquiries,
    //         'pagination' => [
    //             'pageSize' => 20,
    //         ],
    //     ]);
    //     return $this->render('book_now', [
    //         'package_model' => $package_model,
    //         'enquire_provider' => $enquire_provider,

    //     ]);
    // }



    // public function actionFlag($id)
    // {

    //     $dataProvider = new ActiveDataProvider([
    //         'query' =>  PackageCommentReport::find()->where(['package_comment_id' => $id, 'status' => [1, 20]]),
    //         'pagination' => [
    //             'pageSize' => 20,
    //         ],
    //     ]);
    //     return $this->renderAjax('flag', [
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    // public function actionEdit($id)
    // {
    //     $comment_action_model = PackageCommentReport::find()->where(['id' => $id])->limit(1)->one();
    //     $model = new PackageCommentActionForm($comment_action_model);

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->comment_action_model->save(false)) {
    //                     \Yii::$app->session->setFlash('success', 'Action taken successfully');
    //                     return $this->redirect(['/manage/package/comment?package_id=' . $comment_action_model->package_id . '']);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->comment_action_model->loadDefaultValues();
    //     }
    //     return $this->renderAjax('edit', [
    //         'model' => $model,
    //     ]);
    // }



    public function actionGallery($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new PackageGallerySearch();
        $searchModel->package_id = $package_model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('gallery', [
            'package_model' => $package_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateGallery($slug, $id = null)
    {
        $safari_operator = $this->module->operatormodel();
        $package_model = $this->findModel($slug, $safari_operator->id);
        if ($id) {
            $package_gallery_model = $this->findModelgallery($id);
            $model = new PackageGalleryForm($package_gallery_model);
        } else {
            $model = new PackageGalleryForm();
            $model->package_id =  $package_model->id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_gallery_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Gallery updated successfully');
                        return $this->redirect(['gallery', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->package_gallery_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_gallery', [
                'model' => $model,
                'package_model' => $package_model,
            ]);
        }
    }


    // public function actionActive($id)
    // {
    //     $model = PackageFaq::find()->where(['id' => $id])->limit(1)->one();
    //     $model->status = PackageFaq::STATUS_ACTIVE;
    //     $model->save(false);
    //     return $this->redirect(\Yii::$app->request->referrer);
    // }


    // /**
    //  * Suspend Model
    //  *
    //  * @param [type] $id
    //  * @return void
    //  */
    // public function actionSuspend($id)
    // {
    //     $model = PackageFaq::find()->where(['id' => $id])->limit(1)->one();
    //     $model->status = PackageFaq::STATUS_SUSPEND;
    //     $model->save(false);
    //     return $this->redirect(\Yii::$app->request->referrer);
    // }

    /**
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug, $owned_by_id)
    {
        if (($model = Package::findOne(['owned_by_id' => $owned_by_id, 'package_slug' => $slug, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelfaq($id)
    {
        if (($model = PackageFaq::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findModelDay($package_id, $day)
    {
        if (($model = PackageDay::findOne(['package_id' => $package_id, 'day' => $day, 'status' => [PackageDay::STATUS_ACTIVE, PackageDay::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
    }


    protected function findModelgallery($id)
    {
        if (($model = PackageGallery::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
