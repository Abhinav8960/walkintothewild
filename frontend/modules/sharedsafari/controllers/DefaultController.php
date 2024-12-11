<?php

namespace frontend\modules\sharedsafari\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\MailLog;
use common\models\UserWishlist;
use common\models\park\SafariPark;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use common\models\master\month\MasterMonth;
use common\Helper\FrontendNotificationHelper;
use common\models\sharesafari\ShareSafariComment;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafariFaqSearch;
use common\models\sharesafari\ShareSafariHistory;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\sharesafari\ShareSafariRequestContact;
use frontend\models\form\SharedSafariForm;
use frontend\models\ReplyForm;
use frontend\models\ShareSafariCommentForm;
use frontend\models\ShareSafariSearch;
use frontend\controllers\FrontendBaseController;
use frontend\models\ShareSafariCommentReportForm;
use frontend\models\form\ShareSafariRequestContactForm;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'wishlist' => ['post'],
                    'unwishlist' => ['post'],
                    'join' => ['post'],
                    'unjoin' => ['post'],
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
        $searchModel = new ShareSafariSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $models = $dataProvider->getModels();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'device' => $this->device(),
        ]);
    }


    public function actionOrganizeSafari()
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['index']);
        }
        $model = new SharedSafariForm();
        $model->host_user_id = Yii::$app->user->identity->id;
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->type = ShareSafari::TYPE_SAFARI;
        $model->host_type = 1;
        if ($login_user = Yii::$app->user->identity) {
            if ($login_user->x_url <> '') {
                $model->website_url = $login_user->x_url;
            }
            if ($login_user->insta_url <> '') {
                $model->website_url = $login_user->insta_url;
            }
            if ($login_user->facebook_url <> '') {
                $model->website_url = $login_user->facebook_url;
            }
        }

        $model->action_url = Url::toRoute(['/sharedsafari/default/organize-safari']);
        $model->action_validate_url = Url::toRoute(['/sharedsafari/default/validate']);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_model->save()) {
                        $model->shared_safari_model->savehistory();
                        $model->UploadFiles($model->shared_safari_model->id);
                        if ($model->shared_safari_model->user) {
                            $user = $model->shared_safari_model->user;
                            $username = $user->name;
                            $to_mail = Yii::$app->params['adminEmail'];
                            $subject = 'New Shared Safari | ' . substr($model->shared_safari_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_CREATEDBY_USER;
                            $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_model->slug, 'organized_slug' => $model->shared_safari_model->organizedslug ? $model->shared_safari_model->organizedslug : '']);
                            $req = ['shared_safari' => $model->shared_safari_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                            $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                            if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                                GeneralModel::sendmailfromlog($maillog_data['log_id']);
                            }
                        }

                        if ($active_followers = $model->shared_safari_model->sharesafarifollowerlist) {
                            foreach ($active_followers as $follower) {
                                /** Creator Info */
                                $creator_name = $model->shared_safari_model->organizedbyname;
                                /**User Info */
                                $to_mail = $follower->user->username;
                                /**Template info */
                                $subject = 'New Shared Safari | ' . substr($model->shared_safari_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_TO_FOLLOWER;
                                /**Url Info */
                                $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->shared_safari_model->slug, 'organized_slug' => $model->shared_safari_model->organizedslug ? $model->shared_safari_model->organizedslug : '']);
                                $req = ['shared_safari' => $model->shared_safari_model->attributes, 'shared_safari_url' => $shared_safari_url, 'creator_name' => $creator_name];
                                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                                }
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Shared safari created successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->shared_safari_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('organize_form', [
                'model' => $model,
                'show_banner' => false,
            ]);
        } else {
            return $this->render('organize_form', [
                'model' => $model,
                'show_banner' => true,
            ]);
        }
    }

    public function actionValidate()
    {
        $model = new SharedSafariForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    /**
     * Update Safari
     */
    public function actionUpdate($slug)
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['index']);
        }
        $shared_safari_model = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
        if ($shared_safari_model->host_user_id != Yii::$app->user->identity->id) {
            return $this->redirect(['index']);
        }
        $model = new SharedSafariForm($shared_safari_model);
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->action_url = '/sharedsafari/default/update?slug=' . $slug . '';
        $model->action_validate_url = '/sharedsafari/default/updatevalidate?id=' . $shared_safari_model->id . '';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_model->save(false)) {
                        $model->shared_safari_model->savehistory();
                        $model->UploadFiles($model->shared_safari_model->id);

                        if ($intrested_users = $shared_safari_model->intrested) {
                            foreach ($intrested_users as $intrest) {
                                $user = $intrest->user;
                                $username = $user->name;
                                $to_mail = $user->username;
                                $creator_name = $shared_safari_model->organizedbyname;
                                $subject = 'Update Shared Safari | ' . substr($shared_safari_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_UPDATE_SAFARI_CREATEDBY_USER;
                                $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $shared_safari_model->slug, 'organized_slug' => $shared_safari_model->organizedslug ? $shared_safari_model->organizedslug : '']);
                                $req = ['creator_name' => $creator_name, 'shared_safari' => $shared_safari_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                                }
                            }
                        }
                        FrontendNotificationHelper::sharedSafariUpdate($model->shared_safari_model);
                        \Yii::$app->session->setFlash('success', 'Shared safari updated successfully');
                        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $shared_safari_model->slug, 'organized_slug' => $shared_safari_model->organizedslug ? $shared_safari_model->organizedslug : '']));
                    }
                }
            }
        } else {
            $model->shared_safari_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('organize_form', [
                'model' => $model,
                'show_banner' => false,
            ]);
        } else {
            return $this->render('organize_form', [
                'model' => $model,
                'show_banner' => true,
            ]);
        }
    }

    public function actionUpdatevalidate($id)
    {
        if ($id != null) {
            $shared_safari_model = ShareSafari::find()->where(['id' => $id])->limit(1)->one();
            $model = new SharedSafariForm($shared_safari_model);
        } else {

            $model = new SharedSafariForm();
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    /**
     * Shared Safari Detail View
     */
    public function actionView($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (!$share_safari) {
            return $this->redirect(['index']);
        }
        $login_safarioperator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : 0])->limit(1)->one();

        $model = new ShareSafariCommentForm();
        $model->action_validate_url = '/sharedsafari/default/validate-comment';


        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($share_safari)) {

            /**
             * To Creator
             */
            if (Yii::$app->user->identity && $share_safari->host_user_id != Yii::$app->user->identity->id) {
                $user = Yii::$app->user->identity;
                $username = $user->name;
                if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                    $to_mail = $share_safari->user->username;
                } else {
                    $to_mail = $share_safari->safarioperator->user->username;
                }



                $creator_name = $share_safari->organizedbyname;
                $subject = 'New Comment : Shared Safari | ' . substr($share_safari->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_TO_HOST_ONCOMMENT_SAFARI;
                $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                $req = ['username' => $username, 'creator_name' => $creator_name, 'shared_safari' => $share_safari->attributes, 'shared_safari_url' => $shared_safari_url];
                $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                    GeneralModel::sendmailfromlog($maillog_data['log_id']);
                }

                FrontendNotificationHelper::sharedSafariComment($share_safari);
            }


            /**
             *  To member 
             * */
            if ($intrested_users = $share_safari->intrested) {
                foreach ($intrested_users as $intrest) {
                    $user = $intrest->user;
                    $username = $user->name;
                    $to_mail = $user->username;
                    $subject = 'New Comment : Shared Safari | ' . substr($share_safari->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                    $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_TO_MEMBER_ONCOMMENT_SAFARI;
                    $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                    $req = ['shared_safari' => $share_safari->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                    $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                    if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                        GeneralModel::sendmailfromlog($maillog_data['log_id']);
                    }
                }
            }


            FrontendNotificationHelper::sharedSafariCommentToIntrest($share_safari);
            Yii::$app->session->setFlash('success', 'Comment successfully submitted');

            return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']));
        }

        if ($share_safari->type == 1) {
            return $this->render('view', [
                'share_safari' => $share_safari,
                'model' => $model,
                'login_safarioperator' => $login_safarioperator,
            ]);
        } else {
            $searchModel = new ShareSafariFaqSearch();
            $searchModel->share_safari_id = $share_safari->id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
            $faqs = $dataProvider->getModels();

            return $this->render('fixed_view', [
                'share_safari' => $share_safari,
                'model' => $model,
                'faqs' => $faqs,
                'login_safarioperator' => $login_safarioperator,
            ]);
        }
    }

    public function actionReply($slug, $parent_id)
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['index']);
        }
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE,  ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();

        $replymodel = new ReplyForm();
        $replymodel->parent_id = $parent_id;
        $replymodel->action_validate_url = '/sharedsafari/default/validate-reply';

        $on_comment = ShareSafariComment::find()->where(['id' => $parent_id])->limit(1)->one();
        if ($replymodel->load(Yii::$app->request->post())) {
            if ($replymodel->validate()) {
                if ($replymodel->reply($share_safari)) {

                    if (Yii::$app->user->identity && $share_safari->host_user_id != Yii::$app->user->identity->id) {
                        $user = Yii::$app->user->identity;
                        $username = $user->name;
                        if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                            $to_mail = $share_safari->user->username;
                        } else {
                            $to_mail = $share_safari->safarioperator->user->username;
                        }
                        $creator_name = $share_safari->organizedbyname;
                        $subject = 'New Reply : Shared Safari | ' . substr($share_safari->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_COMMENT_REPLY_SAFARI;
                        $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                        $req = ['username' => $username, 'creator_name' => $creator_name, 'shared_safari' => $share_safari->attributes, 'shared_safari_url' => $shared_safari_url];
                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        }
                        FrontendNotificationHelper::sharedSafariReply($share_safari);
                    }

                    if (Yii::$app->user->identity && $on_comment && $to_comment_user = $on_comment->user) {
                        $reply_user = Yii::$app->user->identity;
                        $reply_username = $reply_user->name;
                        $to_mail = $to_comment_user->username;
                        $safari_creator_name = $share_safari->organizedbyname;
                        $subject = 'New Reply';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_REPLY_BY_USER_TO_COMMENTUSER;
                        $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                        $req = ['username' => $reply_username, 'creator_name' => $safari_creator_name, 'shared_safari' => $share_safari->attributes, 'shared_safari_url' => $shared_safari_url];
                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        }
                    }
                    Yii::$app->session->setFlash('success', 'Reply successfully submitted');
                    return $this->redirect(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                }
            }
        }

        return $this->renderAjax('_reply_form', ['replymodel' => $replymodel]);
    }


    /**
     * Join Safari
     */
    public function actionJoin($slug)
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['index']);
        }
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if ($share_safari) {
            if (Yii::$app->user->identity) {
                if (Yii::$app->user->identity->operator) {
                    Yii::$app->session->setFlash('error', "Only individual users are allowed to join a shared safari. Tour operators cannot participate in shared safaris.");
                    if (Yii::$app->request->referrer) {
                        return $this->redirect(Yii::$app->request->referrer);
                    } else {
                        return $this->redirect([Url::toRoute([
                            '/sharedsafari/default/view',
                            'slug' => $share_safari->slug,
                            'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''
                        ])]);
                    }
                }

                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id])->one();
                if (!$share_safari_intrested) {
                    $share_safari_intrested = new ShareSafariIntrested();
                }
                $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent(Yii::$app->request->userAgent);
                $share_safari_intrested->user_ip_address = Yii::$app->getRequest()->getUserIp();
                $share_safari_intrested->user_agent =  Yii::$app->request->userAgent;
                $share_safari_intrested->user_device  = $agent->device();
                $share_safari_intrested->user_platform = $agent->platform();
                $share_safari_intrested->user_browser = $agent->browser();
                $share_safari_intrested->park_id = $share_safari->park_id;
                $share_safari_intrested->share_safari_id = $share_safari->id;
                $share_safari_intrested->user_id = Yii::$app->user->identity->id;
                $share_safari_intrested->status = 1;
                $share_safari_intrested->intrested_at = time();
                if ($share_safari_intrested->save(false)) {

                    $user = Yii::$app->user->identity;
                    $username = $user->name;
                    if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                        $to_mail = $share_safari->user->username;
                    } else {
                        $to_mail = $share_safari->safarioperator->user->username;
                    }
                    $creator_name = $share_safari->organizedbyname;
                    $subject = 'New Member Alert: Shared Safari | ' . substr($share_safari->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                    $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_TO_HOST_JOIN_SAFARI;
                    $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']);
                    $req = ['username' => $username, 'creator_name' => $creator_name, 'shared_safari' => $share_safari->attributes, 'shared_safari_url' => $shared_safari_url];
                    $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                    if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                        GeneralModel::sendmailfromlog($maillog_data['log_id']);
                    }

                    FrontendNotificationHelper::sharedSafariJoin($share_safari, Yii::$app->user->identity);
                    Yii::$app->session->setFlash('success', 'You joined this shared safari!');
                } else {
                    Yii::$app->session->setFlash('success', 'You can not join this shared safari currently!');
                }
            } else {
                return $this->redirect(['/site/login?authclient=google&referrer=' . Url::toRoute([
                    '/sharedsafari/default/view',
                    'slug' => $share_safari->slug,
                    'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''
                ])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Un Join Safari
     */
    public function actionUnjoin($slug)
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['index']);
        }
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if ($share_safari) {
            if (Yii::$app->user->identity) {
                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id])->one();
                if ($share_safari_intrested) {
                    $agent = new \Jenssegers\Agent\Agent();
                    $agent->setUserAgent(Yii::$app->request->userAgent);
                    $share_safari_intrested->user_ip_address = Yii::$app->getRequest()->getUserIp();
                    $share_safari_intrested->user_agent =  Yii::$app->request->userAgent;
                    $share_safari_intrested->user_device  = $agent->device();
                    $share_safari_intrested->user_platform = $agent->platform();
                    $share_safari_intrested->user_browser = $agent->browser();
                    $share_safari_intrested->park_id = $share_safari->park_id;
                    $share_safari_intrested->share_safari_id = $share_safari->id;
                    $share_safari_intrested->user_id = Yii::$app->user->identity->id;
                    $share_safari_intrested->status = 0; //UNfollow
                    $share_safari_intrested->unintrested_at = time();
                    if ($share_safari_intrested->save(false)) {
                        FrontendNotificationHelper::sharedSafariLeave($share_safari, Yii::$app->user->identity);
                        Yii::$app->session->setFlash('success', 'You left this shared safari!');
                    } else {
                        Yii::$app->session->setFlash('success', 'You can not unfollow this shared safari currently!');
                    }
                }
            } else {
                return $this->redirect(['/site/login?authclient=google&referrer=' . Url::toRoute([
                    '/sharedsafari/default/view',
                    'slug' => $share_safari->slug,
                    'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''
                ])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionFlag($slug, $park_id, $share_safari_comment_id)
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['index']);
        }
        $share_safari = ShareSafari::find()->where(['slug' => $slug])->one();
        if (!$share_safari) {
            return $this->redirect(['/sharedsafari']);
        }

        $comments = ShareSafariComment::find()->where(['id' => $share_safari_comment_id])->limit(1)->one();

        $model = new ShareSafariCommentReportForm();
        $model->share_safari_id = $share_safari->id;
        $model->park_id = $park_id;
        $model->share_safari_comment_id = $share_safari_comment_id;

        $model->action_url = '/sharedsafari/default';
        $model->action_validate_url = '/sharedsafari/default/validateflag';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->flag_model->save(false)) {
                        $comments->flaged = 1;
                        $comments->save(false);

                        /*Send Email*/
                        $to_mail = Yii::$app->params['adminEmail'];
                        $subject = 'Flag Raised | Shared Safari : ' . substr($share_safari->share_safari_title, 0, 20) . '| Comment : ' . substr($comments->comment, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
                        $req = ['comment' => $comments->comment, 'report_details' => $model->flag_model->report_detail, 'username' => isset(Yii::$app->user->identity) ? Yii::$app->user->identity->name : ''];
                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        }
                        Yii::$app->session->setFlash('success', 'Review reported successfully!');
                        return $this->redirect([
                            '/sharedsafari/default/view',
                            'slug' => $share_safari->slug,

                            'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''
                        ]);
                    }
                }
            }
        } else {
            $model->flag_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_flag_form', [
                'model' => $model,
                'slug' => $slug,
                'comments' => $comments,
            ]);
        }
    }

    public function actionValidateflag()
    {
        $model = new ShareSafariCommentReportForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    /**
     * Follow Operator
     */
    // public function actionRequestContact($slug, $park_id, $share_safari_comment_id)
    // {
    //     if (!Yii::$app->user->identity) {
    //         return $this->redirect(['index']);
    //     }
    //     $share_safari = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();

    //     $share_safari_comment = ShareSafariComment::find()->where(['id' => $share_safari_comment_id])->one();
    //     if ($share_safari && $share_safari_comment->user) {
    //         $request_contact = ShareSafariRequestContact::find()->where(['user_id' => $share_safari_comment->user->id, 'share_safari_id' => $share_safari->id])->one();
    //         if (!$request_contact) {
    //             $request_contact = new ShareSafariRequestContact();
    //         }
    //         $agent = new \Jenssegers\Agent\Agent();
    //         $agent->setUserAgent(Yii::$app->request->userAgent);
    //         $request_contact->user_ip_address = Yii::$app->getRequest()->getUserIp();
    //         $request_contact->user_agent =  Yii::$app->request->userAgent;
    //         $request_contact->user_device  = $agent->device();
    //         $request_contact->user_platform = $agent->platform();
    //         $request_contact->user_browser = $agent->browser();
    //         $request_contact->share_safari_id = $share_safari->id;
    //         $request_contact->share_safari_comment_id = $share_safari_comment_id;
    //         $request_contact->park_id = $park_id;
    //         $request_contact->user_id = $share_safari_comment->user_id;
    //         $request_contact->host_user_id = Yii::$app->user->identity->id;
    //         $request_contact->email = $share_safari_comment->user->email;
    //         $request_contact->name = $share_safari_comment->user->name;
    //         $request_contact->request_token = Yii::$app->security->generateRandomString() . '_' . time();
    //         $request_contact->is_filled = 0;
    //         $request_contact->status = 1;
    //         if ($request_contact->save(false)) {
    //             Yii::$app->session->setFlash('success', 'You have requested contact to ' . $share_safari_comment->user->name);

    //             $to_mail = $request_contact->email;
    //             $subject = 'Request Contact';
    //             $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SHARE_SAFARI_REQUEST_CONTACT;
    //             $req = ['username' => $request_contact->name, 'token' => $request_contact->request_token];

    //             MailLog::createMailLog($to_mail, $subject, $template, $req, []);
    //         } else {
    //             Yii::$app->session->setFlash('success', 'You can not request this user currently!');
    //         }

    //         return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']));
    //     } else {
    //         return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
    //     }
    // }


    // public function actionUserdetail($token)
    // {
    //     if (Yii::$app->user->identity) {
    //         $requent_contact = ShareSafariRequestContact::find()->where(['request_token' => $token])->limit(1)->one();
    //         $share_safari = ShareSafari::find()->where(['id' => $requent_contact->share_safari_id])->limit(1)->one();

    //         $model = new ShareSafariRequestContactForm($requent_contact);
    //         $model->share_safari_id = $requent_contact->share_safari_id;
    //         $model->park_id = $requent_contact->park_id;
    //         $model->is_filled = 1;
    //         $model->share_safari_comment_id = $requent_contact->share_safari_comment_id;

    //         $model->action_url = '/sharedsafari/default/userdetail?token=' . $token . '';
    //         $model->action_validate_url = '/sharedsafari/default/validateuserdetail?id=' . $requent_contact->id . '';
    //         if ($this->request->isPost) {
    //             if ($model->load($this->request->post())) {
    //                 if ($model->validate()) {
    //                     $model->initializeForm();
    //                     if ($model->shared_safari_request_contact_model->save(false)) {
    //                         Yii::$app->session->setFlash('success', 'Details updated successfully!');
    //                         return $this->redirect([
    //                             '/sharedsafari/default/view',
    //                             'slug' => $share_safari->slug,
    //                             'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''
    //                         ]);
    //                     }
    //                 }
    //             }
    //         } else {
    //             $model->shared_safari_request_contact_model->loadDefaultValues();
    //         }
    //     } else {
    //         return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/sharedsafari/default/userdetail', 'token' => $token])]);
    //     }

    //     return $this->render('userdetail_form', [
    //         'token' => $token,
    //         'model' => $model
    //     ]);
    // }


    // public function actionValidateuserdetail($id = null)
    // {
    //     $model = new ShareSafariCommentReportForm();
    //     if ($id != null) {
    //         $shared_safari_request_contact_model = $this->findModel($id);
    //         $model = new ShareSafariCommentReportForm($shared_safari_request_contact_model);
    //     }
    //     if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
    //         Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return \yii\widgets\ActiveForm::validate($model);
    //     }
    // }


    public function actionHistory($slug)
    {
        $history_model = ShareSafariHistory::find()->where(['slug' => $slug, 'status' => 1, 'type' => ShareSafari::TYPE_SAFARI])->orderBy([
            'id' => SORT_DESC
        ])->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('history_view', [
                'history_model' => $history_model
            ]);
        }
    }

    public function actionFixedHistory($slug)
    {
        $history_model = ShareSafariHistory::find()->where(['slug' => $slug, 'status' => 1, 'type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'mail_sent' => 1])->orderBy([
            'id' => SORT_DESC
        ])->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('history_fixed_view', [
                'history_model' => $history_model
            ]);
        }
    }


    protected function findModel($slug)
    {
        if (($model = ShareSafari::findOne(['slug' => $slug, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionInterestview($share_safari_id)
    {
        $interest_model = ShareSafariIntrested::find()->where(['share_safari_id' => $share_safari_id, 'status' => ShareSafariIntrested::STATUS_ACTIVE])->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('interest_view', [
                'interest_model' => $interest_model
            ]);
        }
    }

    public function actionGetparkimage($id)
    {
        $model = SafariPark::find()->where(['id' => $id])->limit(1)->one();
        $image = $model->featureimagepath;

        return $image;
    }

    public function actionDynamicsharedseat($total_seat)
    {
        echo "<option value=''>Select Shared Seat</option>";
        if ($total_seat == 2) {
            echo "<option value='1'>1</option>";
        } elseif ($total_seat == 3) {
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
        } elseif ($total_seat == 4) {
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
        } elseif ($total_seat == 5) {
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
        } elseif ($total_seat == 6) {
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
            echo "<option value='5'>5</option>";
        }
    }

    // public function actionCompleted($slug)
    // {
    //     $model = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
    //     if ($model) {
    //         $model->status = 2;
    //         $model->save(false);
    //         Yii::$app->session->setFlash('success', 'Thank You!!');
    //         return $this->redirect(Yii::$app->request->referrer);
    //     }
    // }




    /**
     * Add To Wishlist sharedsafari
     */
    public function actionWishlist($slug)
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['index']);
        }
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT], 'slug' => $slug])->limit(1)->one();
        if (empty($share_safari)) {
            return $this->redirect(['/sharedsafari']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($share_safari) {
            if (Yii::$app->user->identity) {
                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $share_safari->id, 'item_type_id' => UserWishlist::SHARED_SAFARI])->one();
                if (!$wishlist) {
                    $wishlist = new UserWishlist();
                }
                $wishlist->user_id = Yii::$app->user->identity->id;
                $wishlist->item_id = $share_safari->id;
                $wishlist->item_type_id = UserWishlist::SHARED_SAFARI;
                $wishlist->item_type = 'share-safari';
                $wishlist->status = 1;
                if ($wishlist->save(false)) {
                    Yii::$app->session->setFlash('success', 'You added share safari to wishlist ');
                } else {
                    Yii::$app->session->setFlash('success', 'You can not add this sharedsafari to wishlist currently!');
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/sharedsafari/default/wishlist', 'slug' => $share_safari->slug])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
    }

    public function actionUnwishlist($slug)
    {
        if (!Yii::$app->user->identity) {
            return $this->redirect(['index']);
        }
        $share_safari = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
        if (empty($share_safari)) {
            return $this->redirect(['/sharedsafari']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($share_safari) {
            if (Yii::$app->user->identity) {
                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $share_safari->id, 'item_type_id' => UserWishlist::SHARED_SAFARI])->one();
                if ($wishlist) {
                    $wishlist->status = 0;
                    if ($wishlist->save(false)) {
                        Yii::$app->session->setFlash('success', 'You removed share safari from wishlist ');
                    } else {
                        Yii::$app->session->setFlash('error', 'You can not add this shared safari to wishlist currently!');
                    }
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/sharedsafari/default/wishlist', 'slug' => $share_safari->slug])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
    }


    /**
     * Get Redirect URL
     */
    public function actionGeturl()
    {
        if (Yii::$app->request->isPost) {
            // Initialize URL with the base route
            $url = ['/sharedsafari'];

            // Loop through the payload parameters
            foreach (Yii::$app->request->post('ShareSafariSearch') as $key => $value) {
                // Only add parameters that are not empty
                if (!empty($value)) {
                    $url['ShareSafariSearch[' . $key . ']'] = $value;
                } else {
                    // $url['ShareSafariSearch[' . $key . ']'] = 0;
                }
            }

            // Construct the redirect URL
            return \yii\helpers\Url::to($url);
        }
    }

    public function actionMonth($month)
    {
        $is_exist = MasterMonth::find()->where(['month_name' => $month])->one();
        if ($is_exist) {
            //rediret to plan safari search page
            return $this->redirect(['/sharedsafari?ShareSafariSearch%5Bmonth_id%5D=' . $is_exist['month']]);
        } else {
            return $this->redirect(['/']);
        }
    }

    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidateComment($id = null)
    {
        $commentmodel = new ShareSafariCommentForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $commentmodel = new ShareSafariCommentForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $commentmodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($commentmodel);
        }
    }

    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidateReply($id = null)
    {
        $replymodel = new ReplyForm();
        if ($id != null) {
            $formmodel = $this->findReplyModel($id);
            $replymodel = new ReplyForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $replymodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($replymodel);
        }
    }

    protected function findReplyModel($id)
    {
        if (($model = ShareSafariComment::findOne(['id' => $id, 'status' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
