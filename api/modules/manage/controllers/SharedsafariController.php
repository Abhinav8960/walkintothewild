<?php

namespace api\modules\manage\controllers;

use Yii;
use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\master\faq\MasterFaq;
use api\models\sharesafari\form\CreateDepartureForm;
use api\models\sharesafari\ShareSafari;
use api\models\sharesafari\ShareSafariDay;
use api\models\sharesafari\ShareSafariFaq;
use api\models\sharesafari\ShareSafariFaqSearch;
use api\models\sharesafari\ShareSafariGallery;
use api\models\sharesafari\ShareSafariGallerySearch;
use api\models\sharesafari\ShareSafariIncluded;
use api\models\sharesafari\ShareSafariParklist;
use common\models\sharesafari\form\DayItineraryForm;
use common\models\sharesafari\form\ShareSafariFaqForm;
use common\models\sharesafari\form\ShareSafariGalleryForm;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `manage` module
 */
class SharedsafariController extends RestController
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
                    'create-fixed-departure',
                    'update-fixed-departure',
                    'getting-there',
                    'policy-info',
                    'inclusion',
                    'create-faq',
                    'update-faq',
                    'create-gallery',
                    'faqs',
                    'gallery'
                ],
                'rules' => [
                    [
                        'actions' => [
                            'create-fixed-departure',
                            'update-fixed-departure',
                            'getting-there',
                            'policy-info',
                            'inclusion',
                            'create-faq',
                            'update-faq',
                            'create-gallery',
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
                    'create-fixed-departure' => ['POST'],
                    'update-fixed-departure' => ['POST'],
                    'getting-there' => ['POST'],
                    'policy-info' => ['POST'],
                    'inclusion' => ['POST'],
                    'create-faq' => ['POST'],
                    'update-faq' => ['POST'],
                    'create-gallery' => ['POST'],
                    'faqs' => ['GET'],
                    'gallery' => ['GET'],
                ],
            ],
        ];
    }

    public function actionCreateFixedDeparture()
    {
        $safari_operator = $this->module->operatormodel();
        $model = new CreateDepartureForm();
        $model->host_user_id =  $safari_operator->id;
        $model->type = 2;

        if ($safari_operator->category_id == 1) {
            $model->host_type = 3;
        } elseif ($safari_operator->category_id == 2) {
            $model->host_type = 2;
        } else {
            $model->host_type = $this->userinfo->account_type;
        }

        $model->status = ShareSafari::STATUS_SUSPEND;
        $model->rand_text = substr(sha1(mt_rand()), 17, 6) . '-' . $model->host_user_id . time();

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_departure_model->save()) {
                $model->shared_safari_departure_model->savehistory();
                $parks = explode(",", (string)$model->park_list);
                if ($parks) {
                    foreach ($parks as $park) {
                        $park_model = new ShareSafariParklist();
                        $park_model->share_safari_id = $model->shared_safari_departure_model->id;
                        $park_model->park_id = $park;
                        $park_model->save(false);
                    }
                }

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Fixed Departure created successfully"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Fixed Departure not created successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionUpdateFixedDeparture($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_departure_model->save(false)) {
                $model->shared_safari_departure_model->savehistory();
                $parks = explode(",", (string)$model->park_list);
                if ($parks) {
                    ShareSafariParklist::deleteAll(['share_safari_id' => $shared_safari_departure_model->id]);
                    foreach ($parks as $park) {
                        $park_model = new ShareSafariParklist();
                        $park_model->share_safari_id = $model->shared_safari_departure_model->id;
                        $park_model->park_id = $park;
                        $park_model->save(false);
                    }
                }

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Fixed Departure updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Fixed Departure not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionItinerary($slug, $day = 1)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
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

        $model->attributes = $this->request;
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->share_safari_day_model->save(false)) {

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Itinerary updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Itinerary not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }



    public function actionInclusion($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'inclusion';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->shared_safari_departure_model->save(false)) {
                    foreach (json_decode($model->share_safari_included, true) as $optionId => $selection) {
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

    public function actionGettingThere($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'getting_there';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_departure_model->save(false)) {

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Getting there updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Getting there not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionPolicyInfo($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'policy_info';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_departure_model->save(false)) {

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Policy info updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Policy info not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionFaqs($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $shared_safari_departure_model->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Faqs");
    }

    /**
     * Create ShareSafariFaqForm.
     * 
     * @return mixed
     */
    public function actionCreateFaq($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new ShareSafariFaqForm();
        $model->share_safari_id = $shared_safari_departure_model->id;
        $model->status = ShareSafariFaq::STATUS_ACTIVE;

        $model->attributes = $this->request;

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

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Faq submitted successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Faq not submitted successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionGallery($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new ShareSafariGallerySearch();
        $searchModel->share_safari_id = $shared_safari_departure_model->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Gallery");
    }

    public function actionCreateGallery($slug, $id = null)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        if ($id) {
            $share_safari_gallery_model = $this->findModelgallery($id);
            $model = new ShareSafariGalleryForm($share_safari_gallery_model);
        } else {
            $model = new ShareSafariGalleryForm();
            $model->share_safari_id = $shared_safari_departure_model->id;
        }

        $model->attributes = $this->request;

        $model->image = UploadedFile::getInstanceByName('image');
        if ($model->validate()) {
            $model->initializeForm();
            if ($model->share_safari_gallery_model->save(false)) {
                $model->uploadFile();
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Gallery updated successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Gallery not updated successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionUpdateFaq($slug, $faq_id)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $faq_model = ShareSafariFaq::find()->where(['id' => $faq_id])->limit(1)->one();
        $model = new ShareSafariFaqForm($faq_model);
        $model->share_safari_id = $shared_safari_departure_model->id;

        $model->attributes = $this->request;

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

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Faq update successfully"]);
            }

            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Faq not update successfully"]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    protected function findModelDay($share_safari_id, $day)
    {
        if (($model = ShareSafariDay::findOne(['share_safari_id' => $share_safari_id, 'day' => $day, 'status' => [ShareSafariDay::STATUS_ACTIVE, ShareSafariDay::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
    }

    protected function findModel($slug, $host_user_id)
    {
        if (($model = ShareSafari::findOne(['slug' => $slug, 'host_user_id' => $host_user_id, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_SUSPEND, ShareSafari::STATUS_FULL_SEAT]])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelgallery($id)
    {
        if (($model = ShareSafariGallery::findOne(['id' => $id, 'status' => [ShareSafariGallery::STATUS_ACTIVE, ShareSafariGallery::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
