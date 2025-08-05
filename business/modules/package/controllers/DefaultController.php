<?php

namespace business\modules\package\controllers;

use common\models\master\faq\MasterFaq;
use common\models\operator\SafariOperator;
use common\models\operator\SafariOperatorFaq;
use common\models\package\form\DayItineraryForm;
use common\models\package\form\PackageFaqForm;
use common\models\package\form\PackageVersionForm;
use common\models\package\PackageVersion;
use common\models\package\PackageComment;
use common\models\package\PackageCommentReport;
use common\models\package\PackageDay;
use common\models\package\PackageFaq;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use common\models\package\PackageGallery;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageVersionSearch;
use common\models\package\Package;
use common\models\package\PackagePartnerSearch;
use common\models\partnergallery\PartnerGallery;
use common\models\partnergallery\PartnerGallerySearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    public $version;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'itinerary', 'inclusion', 'policy-info', 'getting-there', 'faq', 'create-faq', 'update-faq', 'send-for-approval', 'copy-package', 'copy-with-edit'],
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'copy-package', 'copy-with-edit'],
                        'allow' => $this->isPackageOwner(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update', 'itinerary', 'inclusion', 'policy-info', 'getting-there', 'faq', 'create-faq', 'update-faq', 'send-for-approval'],
                        'allow' => $this->isPackageOwner(),
                        'roles' => ['@'],
                    ],
                ],

            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PackagePartnerSearch();
        $searchModel->owned_by_id = $this->operatormodel()->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['!=', 'status', -1]);

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
        $searchModel->status = PackageFaq::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        return $this->render('view', [
            'package' => $model,
            'faqs' => $faqs,
        ]);
    }


    /**
     * Create Package.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $safari_operator = $this->operatormodel();
        $model = new PackageVersionForm();
        $model->status = PackageVersion::EDIATBLE_STATUS;
        $model->owned_by_id = $safari_operator->id;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_image = UploadedFile::getInstance($model, 'package_image');
                $model->package_banner_image = UploadedFile::getInstance($model, 'package_banner_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_version_model->save()) {
                        $model->uploadFile();
                        $this->updatePackageStatus($model->package_id, $model->version, PackageVersion::EDIATBLE_STATUS);
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
                        \Yii::$app->session->setFlash('success', 'Package create successfully');
                        return $this->redirect(['itinerary', 'id' => $model->package_version_model->id]);
                    } else {
                        print_r($model->getErrors());
                        print_r($model->package_version_model->getErrors());
                        die();
                        \Yii::$app->session->setFlash('error', 'Failed to create package.');
                    }
                }
            }
        } else {
            $model->package_version_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'safari_operator' => $safari_operator,
        ]);
    }



    public function actionUpdate($id)
    {
        $safari_operator = $this->operatormodel();
        $package_version_model = PackageVersion::find()->where(['package_id' => $id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
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
            'safari_operator' => $safari_operator,
        ]);
    }

    public function actionItinerary($id, $day = 1)
    {
        $safari_operator = $this->operatormodel();
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
            'safari_operator' => $safari_operator,
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
                                $packageIncluded = PackageIncluded::find()->andWhere(['include_id' => $optionId, 'package_id' => $package_version_model->package_id, 'version' => $package_version_model->version])->one();
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
        $safari_operator = $this->operatormodel();
        $package_version_model = $this->findModel($id);

        $park_array = PackageSafariPark::find()->where(['package_id' => $package_version_model->package_id, 'version' => $package_version_model->version])->select('park_id')->asArray()->column();

        $faqList = SafariOperatorFaq::find()
            ->where(['safari_operator_id' => $safari_operator->id])
            ->andWhere(['park_id' => $park_array])
            ->select(['id', 'question'])
            ->asArray()
            ->all();

        $drop_down_list = ArrayHelper::map($faqList, 'id', 'question');

        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package_version_model->package_id;
        $searchModel->version = $package_version_model->version;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $faqs = $dataProvider->getModels();


        $model = new PackageFaqForm();
        $model->package_id = $package_version_model->package_id;
        $model->version = $package_version_model->version;
        $model->status = PackageFaq::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_faq_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['faq', 'id' => $package_version_model->id]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }

        return $this->render('faq', [
            'package_version_model' => $package_version_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'faqs' => $faqs,
            'model' => $model,
            'drop_down_list' => $drop_down_list,
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




    public function actionUpdateFaq($id, $package_id, $faq_id)
    {
        $package_version_model = PackageVersion::find()->where(['package_id' => $package_id])->andWhere(['status' => PackageVersion::EDIATBLE_STATUS])->limit(1)->one();
        $faq_model = PackageFaq::find()->where(['id' => $faq_id])->one();
        $model = new PackageFaqForm($faq_model);
        $model->package_id = $package_version_model->package_id;
        $model->version = $package_version_model->version;
        $model->status = PackageFaq::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->validate()) {
                $model->initializeForm();
                if ($faq_model->load($this->request->post())) {
                    if ($model->package_faq_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['faq', 'id' => $package_version_model->id]);
                    }
                }
            }
        } else {
            $model->package_faq_model->loadDefaultValues();
        }


        return $this->redirect(['faq', 'id' => $package_version_model->id]);
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

    protected function findModelDay($id, $version, $day)
    {
        if (($model = PackageDay::find()->andWhere(['package_id' => $id, 'version' => $version, 'day' => $day, 'status' => [PackageDay::STATUS_ACTIVE, PackageDay::STATUS_SUSPEND]])->one()) !== null) {
            return $model;
        }
    }


    public function actionCopyPackage($id)
    {
        $m = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $newModel = $this->copyPackageNow($id, true);
            Yii::$app->session->setFlash('success', 'Package copied successfully');
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
        }
        $transaction->commit();

        return $this->redirect(['update', 'id' => $newModel->package_id]);
    }


    protected function isPackageEditable()
    {
        $id = Yii::$app->request->get('id');
        $model = PackageVersion::findOne(['id' => $id]);
        if ($model) {
            return $model->status == PackageVersion::EDIATBLE_STATUS;
        } else {
            return false;
        }
    }

    protected function isPackageOwner()
    {
        $id = Yii::$app->request->get('id');

        $operator = $this->operatormodel();
        $model = PackageVersion::findOne(['id' => $id]);

        if ($model && $model->owned_by_id == $operator->id) {
            return true;
        }
        return false;
    }

    private function copyPackageNow($id, $isNewRecord = false)
    {
        $model = PackageVersion::findOne($id);

        if ($model) {
            $newModel = new PackageVersion();
            $newModel->attributes = $model->attributes;
            $this->version = $newModel->version = 'v' . (intval(substr($model->version, 1)) + 1);

            if ($isNewRecord) {
                $newModel->package_id = $this->newpackage($model);
                $this->version =  $newModel->version = 'v1';
            }
            $newModel->id = null;
            $newModel->status = PackageVersion::EDIATBLE_STATUS;
            $newModel->save(false);
            if (!$isNewRecord) {
                $this->CopyPackageComment($model->package_id, $model->version, $newModel->package_id);
            }
            $this->CopyPackageDay($model->package_id, $model->version, $newModel->package_id);
            $this->CopyPackageIncluded($model->package_id, $model->version, $newModel->package_id);;
            $this->CopyPackageFeature($model->package_id, $model->version, $newModel->package_id);
            $this->CopyPackageSafariPark($model->package_id, $model->version, $newModel->package_id);
            $this->CopyPackageFaq($model->package_id, $model->version, $newModel->package_id);
            $this->updatePackageStatus($newModel->package_id, $newModel->version, PackageVersion::EDIATBLE_STATUS);

            return $newModel;
        }
        return true;
    }

    private function CopyPackageComment($old_package_id, $old_version, $new_package_id)
    {
        $model = PackageComment::find()->where(['package_id' => $old_package_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $comment) {
                $newModel = new PackageComment();
                $newModel->attributes = $comment->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageDay($old_package_id, $old_version, $new_package_id)
    {

        $model = PackageDay::find()->where(['package_id' => $old_package_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $day) {
                $newModel = new PackageDay();
                $newModel->attributes = $day->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageIncluded($old_package_id, $old_version, $new_package_id)
    {
        $model = PackageIncluded::find()->where(['package_id' => $old_package_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $included) {
                $newModel = new PackageIncluded();
                $newModel->attributes = $included->attributes;
                $newModel->selection = $included->selection;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;
    }
    private function CopyPackageFeature($old_package_id, $old_version, $new_package_id)
    {
        $model = PackageFeature::find()->where(['package_id' => $old_package_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $feature) {
                $newModel = new PackageFeature();
                $newModel->attributes = $feature->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageSafariPark($old_package_id, $old_version, $new_package_id)
    {
        $model = PackageSafariPark::find()->where(['package_id' => $old_package_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $safari) {
                $newModel = new PackageSafariPark();
                $newModel->attributes = $safari->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->version = $this->version;
                $newModel->save(false);
            }
        }

        return true;
    }

    private function CopyPackageFaq($old_package_id, $old_version, $new_package_id)
    {
        $model = PackageFaq::find()->where(['package_id' => $old_package_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $faq) {
                $newModel = new PackageFaq();
                $newModel->attributes = $faq->attributes;
                $newModel->id = null; // Set the ID to null for the new record
                $newModel->package_id = $new_package_id;
                $newModel->version = $this->version;

                $newModel->save(false);
            }
        }

        return true;;
    }



    private function updatePackageStatus($package_id, $version, $status)
    {
        $model = Package::find()->where(['id' => $package_id])->one();
        $packageversion = PackageVersion::find()->where(['package_id' => $package_id, 'version' => $version])->one();

        if (empty($model)) {
            $model = new Package();
            $model->package_name = $packageversion->package_name;
        }
        if ($status == PackageVersion::SEND_FOR_APPROVAL_STATUS) {
            $model->pending_for_approval_version = $version;
            $model->pending_status = 1;
        }
        if ($status == PackageVersion::EDIATBLE_STATUS) {
            $model->editable_version = $version;
        }
        $model->edit_status = 1;
        if ($model->save(false)) {
            $this->terminatePackage($package_id);
            return true;
        }
        return false;
    }

    private function terminatePackage($package_id)
    {
        $model = Package::find()->where(['id' => $package_id])->one();
        $packageversion = PackageVersion::find()->where(['package_id' => $package_id])->all();
        foreach ($packageversion as $version) {
            if ($version->version == $model->live_version) {
                $version->status = PackageVersion::APPROVED_AND_LIVE_STATUS;
            } elseif ($version->version == $model->pending_for_approval_version) {
                $version->status = PackageVersion::SEND_FOR_APPROVAL_STATUS;
            } elseif ($version->version ==  $model->editable_version) {
                $version->status = PackageVersion::EDIATBLE_STATUS;
            } else {
                $version->status = PackageVersion::TERMINATED_STATUS;
            }
            $version->save(false);
        }

        return true;
    }




    private function newpackage($model)
    {
        $newModel = new Package();
        $newModel->package_name = $model->package_name;
        $newModel->package_slug = Package::generateUnqiueSlug($newModel->package_name);
        $newModel->editable_version = 'v1';
        $newModel->id = null;
        $newModel->status = Package::STATUS_CREATE;
        $newModel->save(false);
        return $newModel->id;
    }

    public function upsertEditablePackage($package_id, $version)
    {

        $model = Package::find()->where(['id' => $package_id])->one();
        if (empty($model)) {
            $model = new Package();
        }
        $model->editable_version = $version;
        $model->save();
        return true;
    }


    public function operatormodel()
    {
        if ($operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->limit(1)->one()) {
            return $operator;
        }
        throw new ForbiddenHttpException('You are not Allowed to access this Page');
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

    public function actionGalleryPopup($context, $preview)
    {
        $safari_operator = $this->operatormodel();
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

    public function actionSendForApproval($id)
    {

        $m = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $m->status = PackageVersion::SEND_FOR_APPROVAL_STATUS;
            $m->save(false);
            $this->updatePackageStatus($m->package_id, $m->version, $m->status);
            Yii::$app->session->setFlash('success', 'Package sent for approval successfully');
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

    public function actionDelete($id)
    {
        $package_version_model = $this->findModel($id);
        if ($package_version_model) {
            $package_version_model->status = PackageVersion::TERMINATED_STATUS;
            if ($package_version_model->save(false)) {
                $model = Package::find()->where(['id' => $package_version_model->package_id])->one();
                if ($model->status == 10) {
                    $model->status = Package::STATUS_DELETE;
                }
                $model->edit_status = 0;
                $model->pending_status = 0;
                $model->editable_version = null;
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Package Delete successfully');
                    return $this->redirect(['index']);
                }
            }
        }
        Yii::$app->session->setFlash('error', 'Package Not Delete successfully');
        return $this->redirect(['index']);
    }


    public function actionCopyWithEdit($id)
    {
        $safari_operator = $this->operatormodel();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $newModel = $this->copyWithEditPackage($id);
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
        return $this->redirect(['update', 'id' => $newModel->package_id]);
    }


    private function copyWithEditPackage($id, $isNewRecord = false)
    {
        $model = Package::findOne($id);
        $package_version_model = PackageVersion::find()->where(['package_id' => $model->id, 'version' => $model->live_version])->orderBy(['id' => SORT_ASC])->limit(1)->one();
        $last_version = PackageVersion::find()->where(['package_id' => $model->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();

        if ($model) {
            $newModel = new PackageVersion();
            $newModel->attributes = $package_version_model->attributes;
            $this->version = $newModel->version = 'v' . (intval(substr($last_version->version, 1)) + 1);

            $newModel->id = null;
            $newModel->status = PackageVersion::EDIATBLE_STATUS;
            $newModel->save(false);

            $this->CopyPackageDay($package_version_model->package_id, $package_version_model->version, $newModel->package_id);
            $this->CopyPackageIncluded($package_version_model->package_id, $package_version_model->version, $newModel->package_id);;
            $this->CopyPackageFeature($package_version_model->package_id, $package_version_model->version, $newModel->package_id);
            $this->CopyPackageSafariPark($package_version_model->package_id, $package_version_model->version, $newModel->package_id);
            $this->CopyPackageFaq($package_version_model->package_id, $package_version_model->version, $newModel->package_id);

            $model->editable_version = $newModel->version;
            $model->edit_status = 1;
            $model->pending_status = 0;
            $model->save(false);

            return $newModel;
        }
        return true;
    }
}
