<?php

namespace frontend\modules\package\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use common\models\UserWishlist;
use common\models\package\Package;
use yii\web\NotFoundHttpException;
use frontend\models\PackageQuoteForm;
use frontend\models\PackageReplyForm;
use common\interfaces\StatusInterface;
use frontend\models\PackageCommentForm;
use common\models\package\PackageSearch;
use common\models\package\PackageComment;
use common\models\package\PackageFeature;
use common\models\operator\SafariOperator;
use common\models\master\month\MasterMonth;
use common\models\package\form\PackageForm;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageSafariPark;
use frontend\models\form\PackageEnquiryForm;
use frontend\models\PackageCommentReportForm;
use common\Helper\FrontendNotificationHelper;
use common\models\cms\frontendbanner\FrontendBanner;
use common\models\GeneralModel;
use common\models\MailLog;
use common\models\package\PackageEnquiry;
use frontend\controllers\FrontendBaseController;

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
        $searchModel = new PackageSearch();
        $searchModel->status = Package::STATUS_ACTIVE;
        $searchModel->custom_sort_by = 5;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere("owned_by_id IN (SELECT id from safari_operator WHERE status=1)");
        $models = $dataProvider->getModels();

        $package_banner_model = FrontendBanner::find()->where(['type' => FrontendBanner::TYPE_PACKAGE, 'status' => FrontendBanner::STATUS_ACTIVE])->orderBy(['sequence' => SORT_ASC])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'package_banner_model' => $package_banner_model,
            'models' => $models,
            'device' => $this->device(),
        ]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $login_safarioperator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : 0])->limit(1)->one();
        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();


        $model = new PackageCommentForm();
        // $model->action_url = '/package/default/view';
        $model->action_validate_url = '/package/default/validate-comment';


        // $replymodel = new PackageReplyForm();
        // $replymodel->action_url = '/package/default/view';
        // $replymodel->action_validate_url = '/package/default/validate-reply';

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($package)) {
            // Notification for New Comment
            FrontendNotificationHelper::packageNewComment($package, Yii::$app->user->identity);

            Yii::$app->session->setFlash('success', 'Comment successfully submitted');
            return $this->redirect(\yii\helpers\Url::toRoute(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']));
        }


        // if ($replymodel->load(Yii::$app->request->post()) && $replymodel->validate() && $replymodel->reply($package)) {

        //     // Notification for Reply Comment
        //     $reply_comment = $replymodel->commentbyParent();
        //     if ($reply_comment) {
        //         FrontendNotificationHelper::packageCommentReply($package, $reply_comment->user);
        //     }
        //     Yii::$app->session->setFlash('success', 'Reply successfully submitted');
        //     return $this->redirect(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
        // }




        $packagemodel = new PackageQuoteForm();

        $packagemodel->action_validate_url = '/package/default/validate';
        if ($packagemodel->load(Yii::$app->request->post()) && $packagemodel->validate() && $packagemodel->request($package->id)) {
            // Send Notification for Package Quote
            // FrontendNotificationHelper::packageNewQuote($package, Yii::$app->user->identity);

            Yii::$app->session->setFlash('success', 'Quote requested successfully submitted');
            return $this->redirect(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
        }

        return $this->render(
            'view',
            [
                'package' => $package,
                'faqs' => $faqs,
                'model' => $model,
                // 'replymodel' => $replymodel,
                'packagemodel' => $packagemodel,
                'login_safarioperator' => $login_safarioperator,
            ]
        );
    }



    public function actionReply($slug, $parent_id)
    {

        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $replymodel = new PackageReplyForm();
        $replymodel->parent_id = $parent_id;
        // $replymodel->action_url = '/package/default/view';
        $replymodel->action_validate_url = '/package/default/validate-reply';


        if ($replymodel->load(Yii::$app->request->post())) {
            if ($replymodel->validate()) {
                if ($replymodel->reply($package)) {
                    // Notification for Reply Comment
                    $reply_comment = $replymodel->commentbyParent();
                    if ($reply_comment) {
                        FrontendNotificationHelper::packageCommentReply($package, $reply_comment->user);
                    }
                    Yii::$app->session->setFlash('success', 'Reply successfully submitted');
                    return $this->redirect(['/package/default/view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
                }
            }
        }

        return $this->renderAjax('_reply_form', ['replymodel' => $replymodel]);
    }


    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidate($id = null)
    {
        $packagemodel = new PackageQuoteForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $packagemodel = new PackageQuoteForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $packagemodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($packagemodel);
        }
    }


    /**
     * Add To Wishlist Package
     */
    public function actionWishlist($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($package) {
            if (Yii::$app->user->identity) {
                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
                if (!$wishlist) {
                    $wishlist = new UserWishlist();
                }
                $wishlist->user_id = Yii::$app->user->identity->id;
                $wishlist->item_id = $package->id;
                $wishlist->item_type_id = UserWishlist::SAFARI_PACKAGE;
                $wishlist->item_type = 'package';
                $wishlist->status = 1;
                if ($wishlist->save(false)) {
                    Yii::$app->session->setFlash('success', 'You added ' . $package->package_name . ' to wishlist ');
                } else {
                    Yii::$app->session->setFlash('success', 'You can not add this package to wishlist currently!');
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/package/default/wishlist', 'slug' => $package->package_slug])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/package/default/index']));
    }

    public function actionUnwishlist($slug)
    {
        $package = Package::find()->where(['package_slug' => $slug])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($package) {
            if (Yii::$app->user->identity) {
                $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
                if ($wishlist) {
                    $wishlist->status = 0;
                    if ($wishlist->save(false)) {
                        Yii::$app->session->setFlash('success', 'You removed ' . $package->package_name . ' from wishlist ');
                    } else {
                        Yii::$app->session->setFlash('success', 'You can not add this package to wishlist currently!');
                    }
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/package/default/wishlist', 'slug' => $package->package_slug])]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/package/default/index']));
    }


    public function actionEnquiry($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        $model = new PackageEnquiryForm();
        $model->safari_operator_id =  $package->owned_by_id;
        $model->package_id = $package->id;
        $model->status = PackageEnquiry::STATUS_ACTIVE;
        if (Yii::$app->user->identity) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->name = Yii::$app->user->identity->name;
            $model->email_address = Yii::$app->user->identity->email;
            $model->phone = Yii::$app->user->identity->mobile_no;
        }
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_enquiry_model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Request sent successfully!');
                        return $this->redirect(['view', 'slug' => $package->package_slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
                    }
                }
            }
        } else {
            $model->package_enquiry_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_enquiry_form', [
                'model' => $model
            ]);
        } else {
            return $this->renderAjax('_enquiry_form', [
                'model' => $model
            ]);
        }
    }


    public function actionFlag($slug, $package_comment_id)
    {
        $package = Package::find()->where(['package_slug' => $slug])->one();
        if (!$package) {
            return $this->redirect(['/package']);
        }

        $comments = PackageComment::find()->where(['id' => $package_comment_id])->limit(1)->one();

        $model = new PackageCommentReportForm();
        $model->package_id = $package->id;
        $model->package_comment_id = $package_comment_id;

        $model->action_url = '/package/default';
        $model->action_validate_url = '/package/default/validateflag';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->flag_model->save(false)) {
                        $comments->flaged = 1;
                        $comments->save(false);

                        $to_mail = Yii::$app->params['adminEmail'];
                        $subject = 'Flag Raised | Package : ' . substr($package->package_name, 0, 20) . '| Comment : ' . substr($comments->comment, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_FLAGED_RAISEDBY_USER;
                        $req = ['comments' => $comments->attributes, 'report_details' => $model->flag_model->report_detail, 'username' => isset(Yii::$app->user->identity) ? Yii::$app->user->identity->name : ''];
                        $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        if (isset($maillog_data['log_id']) && !empty($maillog_data['log_id'])) {
                            GeneralModel::sendmailfromlog($maillog_data['log_id']);
                        }
                        Yii::$app->session->setFlash('success', 'Review reported successfully!');
                        return $this->redirect(['/package/default/view',  'slug' => $slug, 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '']);
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
        $model = new PackageCommentReportForm();
        if ($id != null) {
            $flag_model = $this->findModel($id);
            $model = new PackageCommentReportForm($flag_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Get Redirect URL
     */
    public function actionGeturl()
    {
        if (Yii::$app->request->isPost) {
            // Initialize URL with the base route
            $url = ['/package'];

            // Loop through the payload parameters
            foreach (Yii::$app->request->post('PackageSearch') as $key => $value) {
                // Only add parameters that are not empty
                if (!empty($value)) {
                    $url['PackageSearch[' . $key . ']'] = $value;
                } else {
                    // $url['SafariParkSearch[' . $key . ']'] = 0;
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
            return $this->redirect(['/package?PackageSearch%5Bmonth_id%5D=' . $is_exist['month']]);
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
        $commentmodel = new PackageCommentForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $commentmodel = new PackageCommentForm($formmodel);
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
        $replymodel = new PackageReplyForm();
        if ($id != null) {
            $formmodel = $this->findReplyModel($id);
            $replymodel = new PackageReplyForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $replymodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($replymodel);
        }
    }

    protected function findReplyModel($id)
    {
        if (($model = PackageComment::findOne(['id' => $id, 'status' => PackageComment::STATUS_ACTIVE])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
