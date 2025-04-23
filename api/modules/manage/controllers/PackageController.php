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
use yii\web\NotFoundHttpException;
use common\interfaces\NewStatusInterface;
use common\models\GeneralModel;
use common\models\MailLog;
use common\models\package\form\PackageForm;
use common\models\package\form\PackageFaqForm;
use common\models\package\form\DayItineraryForm;
use common\models\package\form\PackageGalleryForm;
use yii\filters\AccessControl;

/**
 * Default controller for the `manage` module
 */
class PackageController extends RestController
{
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
                    'create',
                    'update',
                    'policy-info',
                    'getting-there',
                    'itinerary',
                    'inclusion',
                    'create-faq',
                    'update-faq',
                    'faqs',
                    'gallery'
                ],
                'rules' => [
                    [
                        'actions' => [
                            'create',
                            'update',
                            'policy-info',
                            'getting-there',
                            'itinerary',
                            'inclusion',
                            'create-faq',
                            'update-faq',
                            'faqs',
                            'gallery'

                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
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
                ],
            ],
        ];
    }

    public function actionCreate()
    {

        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $model = new PackageForm();
        $model->status = Package::APPROVED_AND_LIVE_STATUS;
        $model->owned_by_id = $safari_operator->id;
        $model->scenario = 'create';

        $model->attributes = $this->request;

        $model->package_image = UploadedFile::getInstanceByName('package_image');
        $model->package_banner_image = UploadedFile::getInstanceByName('package_banner_image');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_model->save()) {
                $model->uploadFile();

                $package_feature = explode(",", (string)$model->package_feature);
                if ($package_feature) {
                    PackageFeature::deleteAll(['package_id' => $model->package_model->id]);
                    foreach ($package_feature as $feature) {
                        $packagefeature = new PackageFeature();
                        $packagefeature->package_id = $model->package_model->id;
                        $packagefeature->feature_id = $feature;
                        $packagefeature->save(false);
                    }
                }


                $package_park = explode(",", (string)$model->package_park);
                if ($package_park) {
                    PackageSafariPark::deleteAll(['package_uuid' => $model->package_model->uuid]);
                    foreach ($package_park as $park) {
                        $packagesafaripark = new PackageSafariPark();
                        $packagesafaripark->package_id = $model->package_model->id;
                        $packagesafaripark->package_uuid = $model->package_model->uuid;
                        $packagesafaripark->park_id = $park;
                        $packagesafaripark->save(false);
                    }
                }

                $to_mail = Yii::$app->params['adminEmail'];
                $subject = 'New Package Created | ' . substr($model->package_model->package_name, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_OPERATOR_CREATED_NEW_PACKAGE;
                $package_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/package/default/view', 'slug' => $model->package_model->package_slug, 'operator_slug' => $safari_operator->slug]);

                $req = ['package' => $model->package_model->attributes, 'package_url' => $package_url, 'operator_name' => $safari_operator->business_name];
                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                }

                return Yii::$app->api->sendResponse($data = ['status' => 1, 'created_slug' => $model->package_model->package_slug], ['message' => "Package create successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Package not create successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionUpdate($slug)
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageForm($package_model);
        $model->scenario = 'update';

        $model->attributes = $this->request;


        $model->package_image = UploadedFile::getInstanceByName('package_image');
        $model->package_banner_image = UploadedFile::getInstanceByName('package_banner_image');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_model->save(false)) {
                $model->uploadFile();

                $package_feature = explode(",", (string)$model->package_feature);
                if ($package_feature) {
                    PackageFeature::deleteAll(['package_id' => $model->package_model->id]);
                    foreach ($package_feature as $feature) {
                        $packagefeature = new PackageFeature();
                        $packagefeature->package_id = $model->package_model->id;
                        $packagefeature->feature_id = $feature;
                        $packagefeature->save(false);
                    }
                }



                $package_park = explode(",", (string)$model->package_park);
                if ($package_park) {
                    PackageSafariPark::deleteAll(['package_uuid' => $model->package_model->uuid]);
                    foreach ($package_park as $park) {
                        $packagesafaripark = new PackageSafariPark();
                        $packagesafaripark->package_id = $model->package_model->id;
                        $packagesafaripark->package_uuid = $model->package_model->uuid;
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
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageForm($package_model);
        $model->scenario = 'policy_info';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_model->save(false)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Policy info updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Policy info not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionGettingThere($slug)
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageForm($package_model);
        $model->scenario = 'getting_there';

        $model->attributes = $this->request;


        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_model->save(false)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Getting there updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Getting there not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionInclusion($slug)
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageForm($package_model);
        $model->scenario = 'inclusion';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->package_model->save(false)) {
                    foreach (json_decode($model->package_included, true) as $optionId => $selection) {
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
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
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
        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package_model->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Faqs");
    }

    /**
     * Create PackageFaqForm.
     * 
     * @return mixed
     */
    public function actionCreateFaq($slug)
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $model = new PackageFaqForm();
        $model->package_id =  $package_model->id;
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
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }

        $package_model = $this->findModel($slug, $safari_operator->id);
        $faq_model = PackageFaq::find()->where(['id' => $faq_id])->limit(1)->one();
        $model = new PackageFaqForm($faq_model);
        $model->package_id = $package_model->id;

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


    public function actionGallery($slug)
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new PackageGallerySearch();
        $searchModel->package_id = $package_model->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Gallery");
    }

    public function actionCreateGallery($slug, $id = null)
    {
        $safari_operator = $this->module->operatormodel();
        if ($safari_operator->category_id == 2) {

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You are not operator"]);
        }
        $package_model = $this->findModel($slug, $safari_operator->id);
        if ($id) {
            $package_gallery_model = $this->findModelgallery($id);
            $model = new PackageGalleryForm($package_gallery_model);
        } else {
            $model = new PackageGalleryForm();
            $model->package_id =  $package_model->id;
        }

        $model->attributes = $this->request;

        $model->image = UploadedFile::getInstanceByName('image');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->package_gallery_model->save(false)) {
                $model->uploadFile();
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Gallery updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    /**
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug, $owned_by_id)
    {
        if (($model = Package::findOne(['owned_by_id' => $owned_by_id, 'package_slug' => $slug, 'status' => [Package::APPROVED_AND_LIVE_STATUS, Package::NOT_APPROVED_STATUS]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelfaq($id)
    {
        if (($model = PackageFaq::findOne(['id' => $id, 'status' => [Package::APPROVED_AND_LIVE_STATUS, Package::NOT_APPROVED_STATUS]])) !== null) {
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
        if (($model = PackageGallery::findOne(['id' => $id, 'status' => [Package::APPROVED_AND_LIVE_STATUS, Package::NOT_APPROVED_STATUS]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
