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
use api\models\User;
use common\models\GeneralModel;
use common\models\MailLog;
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
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

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

                // $to_mail = Yii::$app->params['adminEmail'];
                // $subject = 'New Fixed Departure | ' . substr($model->shared_safari_departure_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                // $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_OPERATOR_CREATED_NEW_FIXEDDEPARTURE;
                // $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_departure_model->slug, 'organized_slug' => $model->shared_safari_departure_model->organizedslug ? $model->shared_safari_departure_model->organizedslug : '']);
                // $req = ['shared_safari' => $model->shared_safari_departure_model->attributes, 'operator_name' => $safari_operator->business_name, 'shared_safari_url' => $shared_safari_url];
                // $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                // if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                // }

                if (!empty($model->shared_safari_departure_model->safarioperator)) {
                    new \common\events\operator\FixedDepartureCreatedByOperator($this->userinfoId, $model->shared_safari_departure_model->id);
                }
                $message = Yii::$app->api->messageManager->getMessage('common.creation_success',['{var}'=>'Fixed Departure']);
                return Yii::$app->api->sendResponse($data = ['status' => 1, 'created_slug' => $model->shared_safari_departure_model->slug], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.creation_failed',['{var}'=>'Fixed Departure']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionUpdateFixedDeparture($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

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

                // $intrested_users = $shared_safari_departure_model->getIntrested()->where(['share_safari_intrested.status' => 1])->all();
                // if ($intrested_users) {
                //     foreach ($intrested_users as $intrest) {
                //         $user = $intrest->user;
                //         $username = $user->name;
                //         $to_mail = $user->username;
                //         $creator_name = $shared_safari_departure_model->organizedbyname;
                //         $subject = 'Update Fixed Departure | ' . substr($shared_safari_departure_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                //         $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_UPDATE_FIXED_CREATEDBY_USER;
                //         $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $shared_safari_departure_model->slug, 'organized_slug' => $shared_safari_departure_model->organizedslug ? $shared_safari_departure_model->organizedslug : '']);
                //         $req = ['creator_name' => $creator_name, 'shared_safari' => $shared_safari_departure_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                //         $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                //         if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //             GeneralModel::sendmailfromlog($maillog_data['log_id']);
                //         }
                //     }
                // }

                // if ($model->shared_safari_departure_model->mail_sent == 0 && $model->shared_safari_departure_model->status == 1) {
                //     $model->shared_safari_departure_model->mail_sent = 1;
                //     if ($model->shared_safari_departure_model->save(false)) {
                //         $model->shared_safari_departure_model->savehistory();
                //         if ($active_followers = $model->shared_safari_departure_model->fixeddeparturefollowerlist) {
                //             foreach ($active_followers as $follower) {
                //                 /** Creator Info */
                //                 $creator_name = $model->shared_safari_departure_model->organizedbyname;
                //                 /**User Info */
                //                 $to_mail = $follower->user->username;
                //                 /**Template info */
                //                 $subject = 'New Fixed departure | ' . substr($model->shared_safari_departure_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                //                 $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_TO_FOLLOWER;
                //                 /**Url Info */
                //                 $shared_safari_url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_departure_model->slug, 'organized_slug' => $model->shared_safari_departure_model->organizedslug ? $model->shared_safari_departure_model->organizedslug : '']);
                //                 $req = ['shared_safari' => $model->shared_safari_departure_model->attributes, 'shared_safari_url' => $shared_safari_url, 'creator_name' => $creator_name];
                //                 $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                //                 if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                //                     GeneralModel::sendmailfromlog($maillog_data['log_id']);
                //                 }
                //             }
                //         }
                //     }
                // }
                if($shared_safari_departure_model->status == ShareSafari::STATUS_ACTIVE) {                    
                    
                    $operator_followers = $shared_safari_departure_model->getFixeddeparturefollowerlist()->asArray()->all();
                    if ($operator_followers) {
                        new \common\events\operator\FixedDepartureUpdatedByOperator(
                            $operator_followers,
                            $this->userinfoId,
                            $model->shared_safari_departure_model->user->name,
                            $model->shared_safari_departure_model->user->email,
                            $model->shared_safari_departure_model->id
                        );
                    }
                }
                $message = Yii::$app->api->messageManager->getMessage('common.updated',['{var}'=>'Fixed Departure']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed',['{var}'=>'Fixed Departure']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionItinerary($slug, $day = 1)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

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
                $message = Yii::$app->api->messageManager->getMessage('common.updated',['{var}'=>'Itinerary']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed',['{var}'=>'Itinerary']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }



    public function actionInclusion($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

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
                    $model->shared_safari_departure_model->savehistory();
                    foreach (json_decode($model->share_safari_included, true) as $optionId => $selection) {
                        $sharesafariIncluded = ShareSafariIncluded::findOne(['include_id' => $optionId, 'share_safari_id' => $shared_safari_departure_model->id]);
                        if (!$sharesafariIncluded) {
                            $sharesafariIncluded = new ShareSafariIncluded();
                            $sharesafariIncluded->include_id = $optionId;
                            $sharesafariIncluded->share_safari_id = $shared_safari_departure_model->id;
                        }
                        $sharesafariIncluded->selection = $selection;
                        if (!$sharesafariIncluded->save()) {
                            $message = Yii::$app->api->messageManager->getMessage('fixed_departure.inclusion.fail_to_save');
                            throw new \Exception($message . $optionId);
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
                    $message = Yii::$app->api->messageManager->getMessage('common.updated',['{var}'=>'Inclusion']);
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
                } else {
                    $message = Yii::$app->api->messageManager->getMessage('common.update_failed',['{var}'=>'Package Details']);
                    return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                $message = Yii::$app->api->messageManager->getMessage('common.error_occurred');
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
            }
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionGettingThere($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'getting_there';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_departure_model->save(false)) {
                $model->shared_safari_departure_model->savehistory();
                $message = Yii::$app->api->messageManager->getMessage('common.updated',['{var}'=>'Getting there']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed',['{var}'=>'Getting there']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionPolicyInfo($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'policy_info';

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->shared_safari_departure_model->save(false)) {
                $model->shared_safari_departure_model->savehistory();
                $message = Yii::$app->api->messageManager->getMessage('common.updated',['{var}'=>'Policy Info']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed',['{var}'=>'Policy Info']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionFaqs($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $shared_safari_departure_model->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "faqs");
    }

    /**
     * Create ShareSafariFaqForm.
     *
     * @return mixed
     */
    public function actionCreateFaq($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

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
                $message = Yii::$app->api->messageManager->getMessage('common.submitted',['{var}'=>'Faq']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.not_submitted',['{var}'=>'Faq']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionGallery($slug)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new ShareSafariGallerySearch();
        $searchModel->share_safari_id = $shared_safari_departure_model->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "gallery");
    }

    public function actionCreateGallery($slug, $id = null)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

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
                $message = Yii::$app->api->messageManager->getMessage('common.updated',['{var}'=>'Gallery']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed',['{var}'=>'Gallery']);
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => $message]);
        }

        return  Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    public function actionUpdateFaq($slug, $faq_id)
    {
        return Yii::$app->api->sendResponse(['status' => 0], ['message' => 'This action is currently not allowed.']);

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
                $message = Yii::$app->api->messageManager->getMessage('common.updated',['{var}'=>'Faq']);
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
            }
            $message = Yii::$app->api->messageManager->getMessage('common.update_failed',['{var}'=>'Faq']);
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => $message]);
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
        $message = Yii::$app->api->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }

    protected function findModelgallery($id)
    {
        if (($model = ShareSafariGallery::findOne(['id' => $id, 'status' => [ShareSafariGallery::STATUS_ACTIVE, ShareSafariGallery::STATUS_SUSPEND]])) !== null) {
            return $model;
        }
        $message = Yii::$app->api->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
