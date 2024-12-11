<?php

namespace frontend\modules\manage\controllers;

use common\Helper\FrontendNotificationHelper;
use common\models\GeneralModel;
use common\models\MailLog;
use common\models\master\faq\MasterFaq;
use common\models\sharesafari\form\DayItineraryForm;
use common\models\sharesafari\form\ShareSafariCommentActionForm;
use common\models\sharesafari\form\ShareSafariFaqForm;
use common\models\sharesafari\form\ShareSafariFaqSelectForm;
use common\models\sharesafari\form\ShareSafariGalleryForm;
use Yii;
use yii\data\ActiveDataProvider;
use frontend\controllers\FrontendBaseController;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\sharesafari\ShareSafariCommentSearch;
use common\models\sharesafari\ShareSafariDay;
use common\models\sharesafari\ShareSafariFaq;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariGallery;
use common\models\sharesafari\ShareSafariGallerySearch;
use common\models\sharesafari\ShareSafariIncluded;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\sharesafari\ShareSafariParklist;
use frontend\models\form\CreateDepartureForm;
use frontend\models\ShareSafariSearch;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `manage` module
 */
class SharedsafariController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        $searchModel = new ShareSafariSearch();
        $dataProvider = $searchModel->managesearch($this->request->queryParams, [
            'safari_operator_id' => $safari_operator->id
        ]);
        return $this->render(
            'index',
            [
                'safari_operator' => $safari_operator,
                'searchModel' => $searchModel,
                'fixed_safari_provider' => $dataProvider,
            ]
        );
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
            $model->host_type = Yii::$app->user->identity->account_type;
        }

        $model->status = ShareSafari::STATUS_SUSPEND;
        $model->action_url = '/manage/sharedsafari/create-fixed-departure';
        $model->action_validate_url = '/manage/sharedsafari/departure-validate';
        $model->rand_text = substr(sha1(mt_rand()), 17, 6) . '-' . $model->host_user_id . time();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save()) {
                        $model->shared_safari_departure_model->savehistory();
                        $parks = $model->park_list;
                        if ($parks) {
                            foreach ($parks as $park) {
                                $park_model = new ShareSafariParklist();
                                $park_model->share_safari_id = $model->shared_safari_departure_model->id;
                                $park_model->park_id = $park;
                                $park_model->save(false);
                            }
                        }


                        $to_mail = Yii::$app->params['adminEmail'];
                        $subject = 'New Fixed Departure | ' . substr($model->shared_safari_departure_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_OPERATOR_CREATED_NEW_FIXEDDEPARTURE;
                        $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_departure_model->slug, 'organized_slug' => $model->shared_safari_departure_model->organizedslug ? $model->shared_safari_departure_model->organizedslug : '']);
                        $req = ['shared_safari' => $model->shared_safari_departure_model->attributes, 'operator_name' => $safari_operator->business_name, 'shared_safari_url' => $shared_safari_url];
                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        }

                        \Yii::$app->session->setFlash('success', 'Fixed departure created successfully');
                        return $this->redirect(['update-fixed-departure', 'slug' => $model->shared_safari_departure_model->slug]);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_fixed_departure_form', [
                'model' => $model,
            ]);
        } else {
            return $this->render('_fixed_departure_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionDepartureValidate()
    {
        $model = new CreateDepartureForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionUpdateFixedDeparture($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->action_url = '/manage/sharedsafari/update-fixed-departure?slug=' . $slug . '';
        $model->action_validate_url = '/manage/sharedsafari/update-departure-validate?id=' . $shared_safari_departure_model->id . '';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save(false)) {
                        $model->shared_safari_departure_model->savehistory();
                        $parks = $model->park_list;
                        if ($parks) {
                            ShareSafariParklist::deleteAll(['share_safari_id' => $shared_safari_departure_model->id]);
                            foreach ($parks as $park) {
                                $park_model = new ShareSafariParklist();
                                $park_model->share_safari_id = $model->shared_safari_departure_model->id;
                                $park_model->park_id = $park;
                                $park_model->save(false);
                            }
                        }

                        if ($intrested_users = $shared_safari_departure_model->intrested) {
                            foreach ($intrested_users as $intrest) {
                                $user = $intrest->user;
                                $username = $user->name;
                                $to_mail = $user->username;
                                $creator_name = $shared_safari_departure_model->organizedbyname;
                                $subject = 'Update Fixed Departure | ' . substr($shared_safari_departure_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_UPDATE_FIXED_CREATEDBY_USER;
                                $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $shared_safari_departure_model->slug, 'organized_slug' => $shared_safari_departure_model->organizedslug ? $shared_safari_departure_model->organizedslug : '']);
                                $req = ['creator_name' => $creator_name, 'shared_safari' => $shared_safari_departure_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                                }
                            }
                        }

                        if ($model->shared_safari_departure_model->mail_sent == 0 && $model->shared_safari_departure_model->status == 1) {
                            $model->shared_safari_departure_model->mail_sent = 1;
                            if ($model->shared_safari_departure_model->save(false)) {
                                $model->shared_safari_departure_model->savehistory();
                                if ($active_followers = $model->shared_safari_departure_model->fixeddeparturefollowerlist) {
                                    foreach ($active_followers as $follower) {
                                        /** Creator Info */
                                        $creator_name = $model->shared_safari_departure_model->organizedbyname;
                                        /**User Info */
                                        $to_mail = $follower->user->username;
                                        /**Template info */
                                        $subject = 'New Fixed departure | ' . substr($model->shared_safari_departure_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_TO_FOLLOWER;
                                        /**Url Info */
                                        $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_departure_model->slug, 'organized_slug' => $model->shared_safari_departure_model->organizedslug ? $model->shared_safari_departure_model->organizedslug : '']);
                                        $req = ['shared_safari' => $model->shared_safari_departure_model->attributes, 'shared_safari_url' => $shared_safari_url, 'creator_name' => $creator_name];
                                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                                        }
                                    }
                                }
                            }
                        }
                        FrontendNotificationHelper::fixedDepartureUpdate($shared_safari_departure_model);


                        \Yii::$app->session->setFlash('success', 'Fixed departure updated successfully');
                        return $this->redirect(\yii\helpers\Url::toRoute(['/manage/sharedsafari/update-fixed-departure', 'slug' => $slug]));
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'safari_operator' => $safari_operator
        ]);
    }

    public function actionUpdateDepartureValidate($id)
    {
        if ($id != null) {
            $shared_safari_model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
            $model = new CreateDepartureForm($shared_safari_model);
        } else {

            $model = new CreateDepartureForm();
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
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
        // Validate and save each day's itinerary entries

        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $model->day_image = UploadedFile::getInstance($model, 'day_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_day_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Itinerary updated successfully');
                        return $this->redirect(['itinerary', 'slug' => $slug, 'day' => $day]);
                    }
                }
            }
        } else {
            $model->share_safari_day_model->loadDefaultValues();
        }

        return $this->render('itinerary', [
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'model' => $model,
            'safari_operator' => $safari_operator
        ]);
    }



    public function actionInclusion($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'inclusion';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->shared_safari_departure_model->save(false)) {
                            foreach ($model->share_safari_included as $optionId => $selection) {
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

            $model->shared_safari_departure_model->loadDefaultValues();
            $includedOptions = [];
            foreach ($shared_safari_departure_model->sharesafariIncludeds as $includedOption) {
                $includedOptions[$includedOption->include_id] = $includedOption->selection;
            }
            $model->share_safari_included = $includedOptions;
        }

        return $this->render('inclusion', [
            'model' => $model,
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'safari_operator' => $safari_operator
        ]);
    }

    public function actionGettingThere($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'getting_there';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Getting there updated successfully');
                        return $this->redirect(['getting-there', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
        }

        return $this->render('getting_there', [
            'model' => $model,
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'safari_operator' => $safari_operator,
        ]);
    }


    public function actionPolicyInfo($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new CreateDepartureForm($shared_safari_departure_model);
        $model->scenario = 'policy_info';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_departure_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Policy info updated successfully');
                        return $this->redirect(['policy-info', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->shared_safari_departure_model->loadDefaultValues();
        }

        return $this->render('policy_info', [
            'model' => $model,
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'safari_operator' => $safari_operator,
        ]);
    }


    public function actionFaq($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new ShareSafariFaqSearch();
        $searchModel->share_safari_id = $shared_safari_departure_model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('faq', [
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'safari_operator' => $safari_operator,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
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
                        \Yii::$app->session->setFlash('success', 'Faq submitted successfully');
                        return $this->redirect(['faq', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->share_safari_faq_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'shared_safari_departure_model' => $shared_safari_departure_model,
                'safari_operator' => $safari_operator,
            ]);
        }
    }


    /**
     * Create ShareSafariFaqForm.
     * 
     * @return mixed
     */
    public function actionSelectFaq($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $model = new ShareSafariFaqSelectForm();
        $model->share_safari_id = $shared_safari_departure_model->id;
        $model->status = ShareSafariFaq::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_faq_select_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data submitted successfully');
                        return $this->redirect(['faq', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->share_safari_faq_select_model->loadDefaultValues();
        }


        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('select_faq', [
                'model' => $model,
                'shared_safari_departure_model' => $shared_safari_departure_model,
                'safari_operator' => $safari_operator,
            ]);
        }
    }

    public function actionGallery($slug)
    {
        $safari_operator = $this->module->operatormodel();

        $shared_safari_departure_model = $this->findModel($slug, $safari_operator->id);
        $searchModel = new ShareSafariGallerySearch();
        $searchModel->share_safari_id = $shared_safari_departure_model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('gallery', [
            'shared_safari_departure_model' => $shared_safari_departure_model,
            'safari_operator' => $safari_operator,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_gallery_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Gallery updated successfully');
                        return $this->redirect(['gallery', 'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->share_safari_gallery_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_gallery', [
                'model' => $model,
                'shared_safari_departure_model' => $shared_safari_departure_model,
                'safari_operator' => $safari_operator,
            ]);
        }
    }


    protected function findModelgallery($id)
    {
        if (($model = ShareSafariGallery::findOne(['id' => $id, 'status' => [ShareSafariGallery::STATUS_ACTIVE, ShareSafariGallery::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionView($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_model = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();



        $safari_interested = ShareSafariIntrested::find()->where(['share_safari_id' => $shared_safari_model->id, 'status' => ShareSafariIntrested::STATUS_ACTIVE]);
        $safari_interested_provider = new ActiveDataProvider([
            'query' => $safari_interested,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view', [
            'safari_operator' => $safari_operator,
            'shared_safari_model' => $shared_safari_model,
            'safari_interested_provider' => $safari_interested_provider,
        ]);
    }

    public function actionComment($slug)
    {
        $safari_operator = $this->module->operatormodel();
        $shared_safari_model = $this->findModel($slug, $safari_operator->id);



        $searchModel = new ShareSafariCommentSearch();
        $searchModel->share_safari_id = $shared_safari_model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('comment', [
            'safari_operator' => $safari_operator,
            'shared_safari_model' => $shared_safari_model,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionEdit($id)
    {
        $comment_action_model = ShareSafariCommentReport::find()->where(['id' => $id])->limit(1)->one();
        $model = new ShareSafariCommentActionForm($comment_action_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->comment_action_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Action taken Successfully');
                        return $this->redirect(['/manage/sharedsafari/comment?id=' . $comment_action_model->share_safari_id . '']);
                    }
                }
            }
        } else {
            $model->comment_action_model->loadDefaultValues();
        }
        return $this->renderAjax('edit', [
            'model' => $model,
        ]);
    }


    public function actionFlag($id)
    {

        $dataProvider = new ActiveDataProvider([
            'query' =>  ShareSafariCommentReport::find()->where(['share_safari_comment_id' => $id, 'status' => [1, 20]]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('flag', [
            'dataProvider' => $dataProvider,
        ]);
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

    public function actionUpdateFaq($share_safari_id, $faq_id)
    {
        $shared_safari_departure_model = ShareSafari::find()->where(['id' => $share_safari_id])->limit(1)->one();
        $safari_operator = $this->module->operatormodel();
        $faq_model = ShareSafariFaq::find()->where(['id' => $faq_id])->one();
        $model = new ShareSafariFaqForm($faq_model);
        $model->share_safari_id = $share_safari_id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
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
                        \Yii::$app->session->setFlash('success', 'Faq submitted successfully');
                        return $this->redirect(['faq', 'slug' => $shared_safari_departure_model->slug]);
                    }
                }
            }
        } else {
            $model->share_safari_faq_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_faq', [
                'model' => $model,
                'shared_safari_departure_model' => $shared_safari_departure_model,
                'safari_operator' => $safari_operator,
            ]);
        }
    }
}
