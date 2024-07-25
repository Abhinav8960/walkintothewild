<?php

namespace frontend\modules\sharedsafari\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use common\interfaces\StatusInterface;
use common\models\MailLog;
use common\models\park\SafariPark;
use frontend\models\ShareSafariSearch;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariComment;
use common\models\sharesafari\ShareSafariCommentReport;
use common\models\sharesafari\ShareSafariFaqSearch;
use frontend\models\form\SharedSafariForm;
use frontend\models\ShareSafariCommentForm;
use frontend\controllers\FrontendBaseController;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\sharesafari\ShareSafariParklist;
use common\models\sharesafari\ShareSafariRequest;
use common\models\sharesafari\ShareSafariRequestContact;
use common\models\UserWishlist;
use frontend\models\form\CreateDepartureForm;
use frontend\models\form\SharedSafariRequestForm;
use frontend\models\form\ShareSafariRequestContactForm;
use frontend\models\ReplyForm;
use frontend\models\ShareSafariCommentReportForm;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

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
        $model = new SharedSafariForm();
        $model->host_user_id = Yii::$app->user->identity->id;
        $model->status = ShareSafari::STATUS_ACTIVE;
        $model->type = 1;
        $model->host_type = 1; //Yii::$app->user->identity->account_type;
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

        $model->action_url = '/sharedsafari/default/organize-safari';
        $model->action_validate_url = '/sharedsafari/default/validate';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->shared_safari_image = \yii\web\UploadedFile::getInstance($model, 'shared_safari_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_model->save(false)) {
                        $model->UploadFiles($model->shared_safari_model->id);
                        if ($model->shared_safari_model->user) {
                            $user = $model->shared_safari_model->user;
                            $to_mail = $user->email;
                            $subject = 'New Safari Request';
                            $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SAFARI_OPERATOR_FREE_QUOTE;
                            $req = ['username' => $user->name];
                            MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        }

                        \Yii::$app->session->setFlash('success', 'Shared Safari Created Successfully');
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
        $shared_safari_model = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
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
                        $model->UploadFiles($model->shared_safari_model->id);
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $shared_safari_model->slug]));
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
        $share_safari = ShareSafari::find()->where(['status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_COMPLETED], 'slug' => $slug])->limit(1)->one();
        $model = new ShareSafariCommentForm();
        $replymodel = new ReplyForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($share_safari)) {
            Yii::$app->session->setFlash('success', 'Comment Successfully submitted');
            return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]));
        }


        if ($replymodel->load(Yii::$app->request->post()) && $replymodel->validate() && $replymodel->reply($share_safari)) {
            Yii::$app->session->setFlash('success', 'Reply Successfully submitted');
            return $this->redirect(['/sharedsafari/default/view', 'slug' => $share_safari->slug, '#' => 'comments_safari']);
        }

        if (!$share_safari) {
            return $this->redirect(['index']);
        }
        if ($share_safari->type == 1) {
            return $this->render('view', [
                'share_safari' => $share_safari,
                'model' => $model,
                'replymodel' => $replymodel,
            ]);
        } else {

            $searchModel = new ShareSafariFaqSearch();
            $searchModel->share_safari_id = $share_safari->id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
            $faqs = $dataProvider->getModels();

            return $this->render('fixed_view', [
                'share_safari' => $share_safari,
                'model' => $model,
                'replymodel' => $replymodel,
                'faqs' => $faqs,
            ]);
        }
    }


    /**
     * Join Safari
     */
    public function actionJoin($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($share_safari) {
            if (Yii::$app->user->identity) {
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
                if ($share_safari_intrested->save()) {
                    Yii::$app->session->setFlash('success', 'You Just Join the Shared Safari!');
                } else {
                    Yii::$app->session->setFlash('error', 'You can not Join this Shared Safari currently!');
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug])]);
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]));
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
    }


    /**
     * Un Join Safari
     */
    public function actionUnjoin($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
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
                    if ($share_safari_intrested->save()) {
                        Yii::$app->session->setFlash('error', 'You are not part of this Shared Safari!');
                    } else {
                        Yii::$app->session->setFlash('error', 'You can not unfollow this Shared Safari currently!');
                    }
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug])]);
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]));
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
    }


    public function actionFlag($slug, $park_id, $share_safari_comment_id)
    {
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
                        Yii::$app->session->setFlash('success', 'Review Reported Successfully!');
                        return $this->redirect([
                            '/sharedsafari/default/view',
                            'slug' => $share_safari->slug,
                            '#' => 'comments_safari'
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

    public function actionValidateflag($id = null)
    {
        $model = new ShareSafariCommentReportForm();
        if ($id != null) {
            $flag_model = $this->findModel($id);
            $model = new ShareSafariCommentReportForm($flag_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    /**
     * Follow Operator
     */
    public function actionRequestContact($slug, $park_id, $share_safari_comment_id)
    {
        $share_safari = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();

        $share_safari_comment = ShareSafariComment::find()->where(['id' => $share_safari_comment_id])->one();
        if ($share_safari && $share_safari_comment->user) {
            $request_contact = ShareSafariRequestContact::find()->where(['user_id' => $share_safari_comment->user->id, 'share_safari_id' => $share_safari->id])->one();
            if (!$request_contact) {
                $request_contact = new ShareSafariRequestContact();
            }
            $agent = new \Jenssegers\Agent\Agent();
            $agent->setUserAgent(Yii::$app->request->userAgent);
            $request_contact->user_ip_address = Yii::$app->getRequest()->getUserIp();
            $request_contact->user_agent =  Yii::$app->request->userAgent;
            $request_contact->user_device  = $agent->device();
            $request_contact->user_platform = $agent->platform();
            $request_contact->user_browser = $agent->browser();
            $request_contact->share_safari_id = $share_safari->id;
            $request_contact->share_safari_comment_id = $share_safari_comment_id;
            $request_contact->park_id = $park_id;
            $request_contact->user_id = $share_safari_comment->user_id;
            $request_contact->host_user_id = Yii::$app->user->identity->id;
            $request_contact->email = $share_safari_comment->user->email;
            $request_contact->name = $share_safari_comment->user->name;
            $request_contact->request_token = Yii::$app->security->generateRandomString() . '_' . time();
            $request_contact->is_filled = 0;
            $request_contact->status = 1;
            if ($request_contact->save(false)) {
                Yii::$app->session->setFlash('success', 'You have requested contact to ' . $share_safari_comment->user->name);

                $to_mail = $request_contact->email;
                $subject = 'Request Contact';
                $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_SHARE_SAFARI_REQUEST_CONTACT;
                $req = ['username' => $request_contact->name, 'token' => $request_contact->request_token];

                MailLog::createMailLog($to_mail, $subject, $template, $req, []);
            } else {
                Yii::$app->session->setFlash('error', 'You can not request this user currently!');
            }

            return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/view', 'slug' => $slug]));
        } else {
            return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
        }
    }


    public function actionUserdetail($token)
    {
        if (Yii::$app->user->identity) {
            $requent_contact = ShareSafariRequestContact::find()->where(['request_token' => $token])->limit(1)->one();
            $share_safari = ShareSafari::find()->where(['id' => $requent_contact->share_safari_id])->limit(1)->one();

            $model = new ShareSafariRequestContactForm($requent_contact);
            $model->share_safari_id = $requent_contact->share_safari_id;
            $model->park_id = $requent_contact->park_id;
            $model->is_filled = 1;
            $model->share_safari_comment_id = $requent_contact->share_safari_comment_id;

            $model->action_url = '/sharedsafari/default/userdetail?token=' . $token . '';
            $model->action_validate_url = '/sharedsafari/default/validateuserdetail?id=' . $requent_contact->id . '';
            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    if ($model->validate()) {
                        $model->initializeForm();
                        if ($model->shared_safari_request_contact_model->save(false)) {
                            Yii::$app->session->setFlash('success', 'Details Updated Successfully!');
                            return $this->redirect([
                                '/sharedsafari/default/view',
                                'slug' => $share_safari->slug,
                                '#' => 'comments_safari'
                            ]);
                        }
                    }
                }
            } else {
                $model->shared_safari_request_contact_model->loadDefaultValues();
            }
        } else {
            return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/sharedsafari/default/userdetail', 'token' => $token])]);
        }

        return $this->render('userdetail_form', [
            'token' => $token,
            'model' => $model
        ]);
    }


    public function actionValidateuserdetail($id = null)
    {
        $model = new ShareSafariCommentReportForm();
        if ($id != null) {
            $shared_safari_request_contact_model = $this->findModel($id);
            $model = new ShareSafariCommentReportForm($shared_safari_request_contact_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    public function actionHistory($share_safari_id)
    {
        $history_model = ShareSafariRequest::find()->where(['share_safari_id' => $share_safari_id, 'status' => 1])->orderBy([
            'id' => SORT_DESC
        ])->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('history_view', [
                'history_model' => $history_model
            ]);
        }
    }


    /**
     * Show Safari List by user or host
     */
    public function actionSafaribyuser($user_id)
    {
    }

    protected function findModel($slug)
    {
        if (($model = ShareSafari::findOne(['slug' => $slug, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_COMPLETED]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionInterestview($share_safari_id)
    {
        $interest_model = ShareSafariIntrested::find()->where(['share_safari_id' => $share_safari_id, 'status' => StatusInterface::STATUS_ACTIVE])->all();
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

    public function actionCompleted($slug)
    {
        $model = ShareSafari::find()->where(['slug' => $slug])->limit(1)->one();
        if ($model) {
            $model->status = 2;
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Thank You!!');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }




    /**
     * Add To Wishlist sharedsafari
     */
    public function actionWishlist($slug)
    {
        $share_safari = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
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
                    Yii::$app->session->setFlash('error', 'You can not add this sharedsafari to wishlist currently!');
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
                        Yii::$app->session->setFlash('error', 'You can not add this sharedsafari to wishlist currently!');
                    }
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/sharedsafari/default/wishlist', 'slug' => $share_safari->slug])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/sharedsafari/default/index']));
    }
}
