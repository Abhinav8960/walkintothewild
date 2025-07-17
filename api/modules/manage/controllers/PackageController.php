<?php

namespace api\modules\manage\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use Yii;
use yii\web\UploadedFile;
use api\controllers\RestController;
use api\models\master\faq\MasterFaq;
use api\models\package\Package;
use api\models\package\PackageDay;
use api\models\package\PackageFaq;
use api\models\package\PackageFaqSearch;
use api\models\package\PackageFeature;
use api\models\package\PackageGallery;
use api\models\package\PackageGallerySearch;
use api\models\package\PackageIncluded;
use api\models\package\PackageSafariPark;
use api\models\package\PackageVersion;
use api\models\package\PackageVersionSearch;
use yii\web\NotFoundHttpException;
use common\interfaces\NewStatusInterface;
use common\models\GeneralModel;
use common\models\MailLog;
use common\models\package\form\PackageVersionForm;
use common\models\package\form\PackageFaqForm;
use common\models\package\form\DayItineraryForm;
use common\models\package\form\PackageGalleryForm;
use common\models\package\PackageComment;
use yii\filters\AccessControl;

/**
 * Default controller for the `manage` module
 */
class PackageController extends RestController
{
    public $version;
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => [],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index',
                    'create',
                    'update',
                    'policy-info',
                    'getting-there',
                    'itinerary',
                    'inclusion',
                    'create-faq',
                    'update-faq',
                    'faqs',
                    'gallery',
                    'send-for-approval',
                    'view',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'create',
                            'update',
                            'policy-info',
                            'getting-there',
                            'itinerary',
                            'inclusion',
                            'create-faq',
                            'update-faq',
                            'faqs',
                            'gallery',
                            'send-for-approval',
                            'view',

                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'create' => ['POST'],
                    'update' => ['POST'],
                    'policy-info' => ['POST'],
                    'getting-there' => ['POST'],
                    'itinerary' => ['POST'],
                    'inclusion' => ['POST'],
                    'create-faq' => ['POST'],
                    'update-faq' => ['POST'],
                    'faqs' => ['GET'],
                    'gallery' => ['GET'],
                    'send-for-approval' => ['POST'],
                    'view' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $searchModel = new PackageVersionSearch();
        $searchModel->status = PackageVersion::EDIATBLE_STATUS;
        $searchModel->owned_by_id = $safari_operator->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "packages", $additionalSearchQueryParams = [], $singleRecord = false, $paginationNeededAsPerQuery = 1, $searchfunction = "partnersearch");
    }

    public function actionCreate()
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $model = new PackageVersionForm();
        $model->status = PackageVersion::EDIATBLE_STATUS;
        $model->owned_by_id = $safari_operator->id;
        $model->scenario = 'create';

        $model->attributes = $this->request;

        $model->package_image = UploadedFile::getInstanceByName('package_image');
        $model->package_banner_image = UploadedFile::getInstanceByName('package_banner_image');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_version_model->save()) {
                $model->uploadFile();

                $this->updatePackageStatus($model->package_id, $model->version, PackageVersion::EDIATBLE_STATUS);

                $package_feature = explode(",", (string)$model->package_feature);
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


                $package_park = explode(",", (string)$model->package_park);
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

                // $to_mail = Yii::$app->params['adminEmail'];
                // $subject = 'New Package Created | ' . substr($model->package_version_model->package_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_OPERATOR_CREATED_NEW_PACKAGE;
                // $package_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/package/default/view', 'slug' => $model->package_version_model->package_slug, 'operator_slug' => $safari_operator->slug]);

                // $req = ['package' => $model->package_version_model->attributes, 'package_url' => $package_url, 'operator_name' => $safari_operator->business_name];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }

                return Yii::$app->api->sendResponse($data = ['status' => 1, 'created_slug' => $model->package_version_model->getPackage_slug()], ['message' => "Package create successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Package not create successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionUpdate($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'update';

        $model->attributes = $this->request;


        $model->package_image = UploadedFile::getInstanceByName('package_image');
        $model->package_banner_image = UploadedFile::getInstanceByName('package_banner_image');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_version_model->save(false)) {
                $model->uploadFile();

                $package_feature = explode(",", (string)$model->package_feature);
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



                $package_park = explode(",", (string)$model->package_park);
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

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Package update successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Package not update successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionPolicyInfo($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'policy_info';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_version_model->save(false)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Policy info updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Policy info not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionGettingThere($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'getting_there';

        $model->attributes = $this->request;


        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_version_model->save(false)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Getting there updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Getting there not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionInclusion($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'inclusion';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->package_version_model->save(false)) {
                    foreach (json_decode($model->package_included, true) as $optionId => $selection) {
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
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Inclusion updated successfully"]);
                } else {
                    return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Failed to update package details."]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "An error occurred while updating data"]);
            }
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionItinerary($slug, $day = 1)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
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

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_day_model->save(false)) {
                $model->uploadFile();
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Itinerary updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Itinerary not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionFaqs($slug)
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package_version_model->package_id;
        $searchModel->version = $package_version_model->version;
        return $this->dataProviderSender($searchModel, $rootIndexName = "faqs");
    }

    /**
     * Create PackageFaqForm.
     *
     * @return mixed
     */
    public function actionCreateFaq($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
        $model = new PackageFaqForm();
        $model->package_id =  $package_version_model->package_id;
        $model->version =  $package_version_model->version;
        $model->status = PackageFaq::STATUS_ACTIVE;

        $model->attributes = $this->request;

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
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Faq submitted successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Faq not submitted successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionUpdateFaq($slug, $faq_id)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }

        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
        $faq_model = PackageFaq::find()->where(['id' => $faq_id])->limit(1)->one();
        if (!$faq_model) {
            throw new NotFoundHttpException('Faq Not Found.');
        }
        $model = new PackageFaqForm($faq_model);
        $model->package_id = $package_version_model->package_id;
        $model->version = $package_version_model->version;

        $model->attributes = $this->request;


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
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Faq update successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Faq not update successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionSendForApproval($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.'],403);

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }

        $package_model = $this->findModel($slug, $safari_operator->id);
        $package_version_model = $this->findPackageVersionModelWithStatus($package_model->id, PackageVersion::EDIATBLE_STATUS);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $package_version_model->status = PackageVersion::SEND_FOR_APPROVAL_STATUS;
            $package_version_model->save(false);
            $this->updatePackageStatus($package_version_model->package_id, $package_version_model->version, $package_version_model->status);
            $this->copyPackageNow($package_version_model->id);
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "An error occurred while sending for approval"]);
        }
        $transaction->commit();


        return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Package sent for approval successfully"]);
    }




    // public function actionGallery($slug)
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     if ($safari_operator->category_id == 2) {

    //         return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
    //     }
    //     $package_version_model = $this->findModel($slug, $safari_operator->id);
    //     $searchModel = new PackageGallerySearch();
    //     $searchModel->package_id = $package_version_model->id;
    //     return $this->dataProviderSender($searchModel, $rootIndexName = "gallery");
    // }

    // public function actionCreateGallery($slug, $id = null)
    // {
    //     $safari_operator = $this->module->operatormodel();
    //     if ($safari_operator->category_id == 2) {

    //         return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
    //     }
    //     $package_version_model = $this->findModel($slug, $safari_operator->id);
    //     if ($id) {
    //         $package_gallery_model = $this->findModelgallery($id);
    //         $model = new PackageGalleryForm($package_gallery_model);
    //     } else {
    //         $model = new PackageGalleryForm();
    //         $model->package_id =  $package_version_model->id;
    //     }

    //     $model->attributes = $this->request;

    //     $model->image = UploadedFile::getInstanceByName('image');
    //     if ($model->validate()) {
    //         $model->initializeForm();
    //         if ($model->package_gallery_model->save(false)) {
    //             $model->uploadFile();
    //             return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Gallery updated successfully"]);
    //         }

    //         return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery not updated successfully"]);
    //     }

    //     return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
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

    protected function findPackageVersionModel($package_id, $version)
    {
        if (($model = PackageVersion::findOne(['package_id' => $package_id, 'version' => $version])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findPackageVersionModelWithStatus($package_id, $status)
    {
        if (($model = PackageVersion::findOne(['package_id' => $package_id, 'status' => $status])) !== null) {
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


    protected function findModelDay($package_id, $version, $day)
    {
        if (($model = PackageDay::findOne(['package_id' => $package_id, 'version' => $version, 'day' => $day, 'status' => [PackageDay::STATUS_ACTIVE, PackageDay::STATUS_SUSPEND]])) !== null) {
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
            $newModel->id = null; // Set the ID to null for the new record
            $newModel->status = PackageVersion::EDIATBLE_STATUS;
            $newModel->save(false);
            if (!$isNewRecord) {
                $this->CopyPackageComment($model->package_id, $model->version, $newModel->package_id);
            }
            // $this->CopyPackageCommentReport($model->package_id, $model->version, $newModel->package_id);
            $this->CopyPackageDay($model->package_id, $model->version, $newModel->package_id);
            $this->CopyPackageIncluded($model->package_id, $model->version, $newModel->package_id);
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
        // package_comment_approval;

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

    // private function CopyPackageCommentReport($old_package_id, $old_version, $new_package_id)
    // {
    //     // package_comment_report_approval;

    //     $model = PackageCommentReport::find()->where(['package_id' => $old_package_id, 'version' => $old_version])->all();
    //     if ($model) {
    //         foreach ($model as $comment) {
    //             $newModel = new PackageCommentReport();
    //             $newModel->attributes = $comment->attributes;
    //             $newModel->id = null; // Set the ID to null for the new record
    //             $newModel->package_id = $new_package_id;
    //             $newModel->version = $this->version;

    //             $newModel->save(false);
    //         }
    //     }

    //     return true;
    // }

    private function CopyPackageDay($old_package_id, $old_version, $new_package_id)
    {
        // package_day_approval;

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
        // package_included_approval;
        $model = PackageIncluded::find()->where(['package_id' => $old_package_id, 'version' => $old_version])->all();
        if ($model) {
            foreach ($model as $included) {
                $newModel = new PackageIncluded();
                $newModel->attributes = $included->attributes;
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
        // package_feature_approval;

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
        // package_safari_park_approval;
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
        // package_faq_approval;
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
        return true;
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
            // $model->editable_version = NULL;
            $this->terminatePackage($package_id);
        }
        if ($status == PackageVersion::EDIATBLE_STATUS) {
            $model->editable_version = $version;
        }
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
        // $newModel->package_agenda_id = $model->package_agenda_id;
        // $newModel->no_of_day = $model->no_of_day;
        // $newModel->no_of_night = $model->no_of_night;
        // $newModel->safari_type = $model->safari_type;
        // $newModel->safari_type = $model->safari_type;
        $newModel->editable_version = 'v1';
        $newModel->id = null; // Set the ID to null for the new record
        $newModel->status = Package::STATUS_SUSPEND;
        $newModel->save(false);
        return $newModel->id;
    }

    public function actionView($slug, $version = null)
    {
        $this->layout = \common\interfaces\NewStatusInterface::PACKAGE_API_LAYOUT_FULL_WITH_VERSION;
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        if (empty($version)) {
            $version = $package_model->editable_version;
        }
        $package_version_model['data'] = $this->findPackageVersionModel($package_model->id, $version);
        return Yii::$app->api->sendResponse($data = $package_version_model);
    }
}
