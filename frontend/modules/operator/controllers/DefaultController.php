<?php

namespace frontend\modules\operator\controllers;

use Yii;
use yii\helpers\Url;
use common\models\MailLog;
use common\models\GeneralModel;
use yii\data\ActiveDataProvider;
use common\models\package\Package;
use yii\web\NotFoundHttpException;
use frontend\models\SafariParkSearch;
use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use frontend\models\OperatorQuoteForm;
use frontend\models\SafariOperatorSearch;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use common\Helper\FrontendNotificationHelper;
use frontend\models\SafariOperatorReviewForm;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;
use frontend\controllers\FrontendBaseController;
use frontend\models\SafariOperatorRatingReportForm;
use frontend\models\SafariOperatorRatingCommentForm;
use common\models\operator\SafariOperatorRatingSearch;
use common\models\operator\form\SafariOperatorReportProfileForm;
use common\models\User;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{
    public $enableCsrfValidation = false;

    public $action_ids = ['index', 'view', 'follow', 'unfollow', 'reviewlist', 'sharedsafari', 'review', 'flag'];


    /**
     * All Operator List
     */
    public function actionIndex()
    {
        return $this->redirect(['/']);

        $searchModel = new SafariParkSearch();
        $searchModel->master_location_id = 7;
        $searchModel->month_id = GeneralModel::removeLeadingChar(date('m'));
        $searchModel->master_animal_id = 13;
        $searchModel->master_vehicle_id = 5;
        $dataProvider = $searchModel->search($this->request->queryParams);


        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;
        $operatordataProvider = $operatorsearchModel->search($this->request->queryParams);
        $operators = $operatordataProvider->getModels();

        return $this->render('index', [
            'operatorsearchModel' => $operatorsearchModel,
            'operatordataProvider' => $operatordataProvider,
            'operators' => $operators,
            'device' => $this->device(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->limit(6)->all();
        $model = new OperatorQuoteForm();

        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/view',  'slug' => $slug]);
            }
        }

        return $this->render(
            'view',
            [
                'operator' => $operator,
                'model' => $model,
                'operator_parks' => $operator_parks,
            ]
        );
    }

    public function actionPackage($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $operator_packages = Package::find()->where(['owned_by_id' => $operator->id, 'status' => Package::STATUS_ACTIVE])->limit(6)->all();
        $model = new OperatorQuoteForm();
        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/sharedsafari',  'slug' => $slug]);
            }
        }

        return $this->render(
            'package',
            [
                'operator' => $operator,
                'model' => $model,
                'operator_packages' => $operator_packages,
            ]
        );
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionReviewlist($slug, $sort_by = null)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        $replymodel = new SafariOperatorRatingCommentForm();

        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $ratingsearchModel = new SafariOperatorRatingSearch();
        $ratingsearchModel->custom_sort_by = $sort_by;
        $ratingsearchModel->safari_operator_id = $operator->id;
        $ratingsearchModel->is_deleted = 0;
        $ratingsearchModel->status = 1;
        $ratingdataProvider = $ratingsearchModel->search($this->request->queryParams);
        $reviews = $ratingdataProvider->getModels();

        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->all();
        $model = new OperatorQuoteForm();
        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/reviewlist',  'slug' => $slug]);
            }
        }

        if ($replymodel->load(Yii::$app->request->post()) && $replymodel->validate()) {
            $post_data =  \Yii::$app->request->post('SafariOperatorRatingCommentForm');

            $safari_operator_rating = SafariOperatorRating::find()->where(['id' => $post_data['safari_operator_rating_id']])->limit(1)->one();
            $new_safari_operator_rating = new SafariOperatorRating();
            $new_safari_operator_rating->safari_operator_id = $safari_operator_rating->safari_operator_id;
            $new_safari_operator_rating->park_id = $safari_operator_rating->park_id;
            $new_safari_operator_rating->user_id = Yii::$app->user->identity->id;
            $new_safari_operator_rating->rating = 0;
            $new_safari_operator_rating->review = $post_data['comment'];
            $new_safari_operator_rating->parent_id = $safari_operator_rating->id;
            $new_safari_operator_rating->status = 1;
            if ($new_safari_operator_rating->save(false)) {
                Yii::$app->session->setFlash('success', 'Reply successfully submitted');
                return $this->redirect(['/operator/default/reviewlist',  'slug' => $slug]);
            }

            /*
            $new_safari_operator_rating->safari_operator_rating_id = $post_data['safari_operator_rating_id'];
            $rating_comment->comment = $post_data['comment'];
            if ($rating_comment->save(false)) {
                Yii::$app->session->setFlash('success', 'Reply successfully submitted');
                return $this->redirect(['/operator/default/reviewlist',  'slug' => $slug]);
            }
                */
        }

        $organized_by = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'host_user_id' => $operator->user_id])->all();

        return $this->render(
            'reviewlist',
            [
                'operator' => $operator,
                'model' => $model,
                'operator_parks' => $operator_parks,
                'reviews' => $reviews,
                'ratingsearchModel' => $ratingsearchModel,
                'ratingdataProvider' => $ratingdataProvider,
                'organized_by' => $organized_by,
                'replymodel' => $replymodel
            ]
        );
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSharedsafari($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $shared_safaries = ShareSafari::find()->where([
            'status' => ShareSafari::STATUS_ACTIVE,
            'host_user_id' => $operator->id,
            'type' => ShareSafari::TYPE_FIXED_DEPARTURE
        ])->andWhere(['>=', 'start_date', date("Y-m-d")])->all();


        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->all();
        $model = new OperatorQuoteForm();
        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/sharedsafari',  'slug' => $slug]);
            }
        }

        return $this->render(
            'sharedsafari',
            [
                'operator' => $operator,
                'model' => $model,
                'operator_parks' => $operator_parks,
                'shared_safaries' => $shared_safaries,
            ]
        );
    }


    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidate($id = null)
    {
        $model = new OperatorQuoteForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new OperatorQuoteForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    /**
     * Follow Operator
     */
    public function actionFollow($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($operator) {
            if (Yii::$app->user->identity) {
                $operator_follow = SafariOperatorFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'safari_operator_id' => $operator->id])->one();
                if (!$operator_follow) {
                    $operator_follow = new SafariOperatorFollow();
                }
                $agent = new \Jenssegers\Agent\Agent();
                $agent->setUserAgent(Yii::$app->request->userAgent);
                $operator_follow->user_ip_address = Yii::$app->getRequest()->getUserIp();
                $operator_follow->user_agent =  Yii::$app->request->userAgent;
                $operator_follow->user_device  = $agent->device();
                $operator_follow->user_platform = $agent->platform();
                $operator_follow->user_platform_version = $agent->version($operator_follow->user_platform);
                $operator_follow->user_browser = $agent->browser();
                $operator_follow->user_browser_version = $agent->version($operator_follow->user_browser);
                $operator_follow->safari_operator_id = $operator->id;
                $operator_follow->user_id = Yii::$app->user->identity->id;
                $operator_follow->status = 1;
                $operator_follow->follow_datetime = date('Y-m-d h:i:s');
                if ($operator_follow->save(false)) {

                    $to_mail = $operator->email;
                    $subject = 'Follow Request';
                    $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_FOLLOW_REQUEST;
                    $req = ['username' => $operator->business_name, 'name' => Yii::$app->user->identity->name, 'is_email_sending' => true];

                    MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                    FrontendNotificationHelper::operatorNewFollower($operator, Yii::$app->user->identity);

                    Yii::$app->session->setFlash('success', 'You are start following ' . $operator->business_name);
                } else {
                    Yii::$app->session->setFlash('success', 'You can not follow this operator currently!');
                }
            } else {
                return $this->redirect(['/site/login?authclient=google&referrer=' . Url::toRoute(['/operator/default/follow', 'slug' => $slug])]);
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/view', 'slug' => $slug]));
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/index']));
    }


    /**
     * Follow Operator
     */
    public function actionUnfollow($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($operator) {
            if (Yii::$app->user->identity) {
                $operator_follow = SafariOperatorFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'safari_operator_id' => $operator->id])->one();
                if ($operator_follow) {
                    $agent = new \Jenssegers\Agent\Agent();
                    $agent->setUserAgent(Yii::$app->request->userAgent);
                    $operator_follow->user_ip_address = Yii::$app->getRequest()->getUserIp();
                    $operator_follow->user_agent =  Yii::$app->request->userAgent;
                    $operator_follow->user_device  = $agent->device();
                    $operator_follow->user_platform = $agent->platform();
                    $operator_follow->user_platform_version = $agent->version($operator_follow->user_platform);
                    $operator_follow->user_browser = $agent->browser();
                    $operator_follow->user_browser_version = $agent->version($operator_follow->user_browser);
                    $operator_follow->safari_operator_id = $operator->id;
                    $operator_follow->user_id = Yii::$app->user->identity->id;
                    $operator_follow->status = 0; //UNfollow
                    $operator_follow->unfollow_datetime = date('Y-m-d h:i:s');
                    if ($operator_follow->save(false)) {

                        $to_mail = $operator->email;
                        $subject = 'UnFollow Request';
                        $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_UNFOLLOW_REQUEST;
                        $req = ['username' => $operator->business_name, 'name' => Yii::$app->user->identity->name, 'is_email_sending' => true];

                        MailLog::createMailLog($to_mail, $subject, $template, $req, []);
                        Yii::$app->session->setFlash('success', 'You unfollowed ' . $operator->business_name);
                    } else {
                        Yii::$app->session->setFlash('success', 'You can not unfollow this operator currently!');
                    }
                }
            } else {
                return $this->redirect(['/site/login?authclient=google&referrer=' . Url::toRoute(['/operator/default/unfollow', 'slug' => $slug])]);
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/view', 'slug' => $slug]));
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/index']));
    }

    public function actionReview($operator_id)
    {
        $operator = SafariOperator::find()->where(['id' => $operator_id])->one();
        if (!$operator) {
            return $this->redirect(['/operator']);
        }

        $model = new SafariOperatorReviewForm();
        $model->safari_operator_id = $operator_id;

        $model->action_url = '/operator/default';
        $model->action_validate_url = '/operator/default/validatereview';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->rating_model->save(false)) {
                        $model->updateRatingintoTable($operator);
                        FrontendNotificationHelper::operatorNewReview($operator, $model->rating_model, Yii::$app->user->identity);
                        Yii::$app->session->setFlash('success', 'Thanks for review!!');
                        return $this->redirect([
                            '/operator/default/reviewlist',
                            'slug' => $operator->slug
                        ]);
                    }
                }
            }
        } else {
            $model->rating_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_review_form', [
                'model' => $model,
                'operator_id' => $operator_id,
            ]);
        }
    }


    public function actionReviewupdate($operator_id, $user_id, $id)
    {
        $operator = SafariOperator::find()->where(['id' => $operator_id])->one();
        $rating_model = SafariOperatorRating::find()->where(['user_id' => $user_id, 'safari_operator_id' => $operator_id, 'id' => $id])->one();
        $model = new SafariOperatorReviewForm($rating_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->rating_model->save(false)) {
                        $model->updateRatingintoTable($operator);
                        Yii::$app->session->setFlash('success', 'Thanks for edit review!!');
                        return $this->redirect([
                            '/operator/default/reviewlist',
                            'slug' => $operator->slug
                        ]);
                    }
                }
            }
        } else {
            $model->rating_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_review_form', [
                'model' => $model,
                'operator_id' => $operator_id,
            ]);
        }
    }

    public function actionValidatereview($id = null)
    {
        $model = new SafariOperatorReviewForm();
        if ($id != null) {
            $rating_model = $this->findModel($id);
            $model = new SafariOperatorReviewForm($rating_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }



    public function actionFlag($operator_id, $park_id, $safari_operator_rating_id)
    {
        $operator = SafariOperator::find()->where(['id' => $operator_id])->one();
        if (!$operator) {
            return $this->redirect(['/operator']);
        }

        $rating = SafariOperatorRating::find()->where(['id' => $safari_operator_rating_id])->limit(1)->one();

        $model = new SafariOperatorRatingReportForm();
        $model->safari_operator_id = $operator_id;
        $model->park_id = $park_id;
        $model->safari_operator_rating_id = $safari_operator_rating_id;

        $model->action_url = '/operator/default';
        $model->action_validate_url = '/operator/default/validateflag';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->flag_model->save(false)) {
                        $rating->flaged = 1;
                        $rating->save(false);
                        Yii::$app->session->setFlash('success', 'Review reported successfully!');
                        return $this->redirect([
                            '/operator/default/reviewlist',
                            'slug' => $operator->slug
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
                'operator_id' => $operator_id,
                'rating' => $rating,
            ]);
        }
    }

    public function actionValidateflag($id = null)
    {
        $model = new SafariOperatorRatingReportForm();
        if ($id != null) {
            $flag_model = $this->findModel($id);
            $model = new SafariOperatorRatingReportForm($flag_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }


    public function findModel($id)
    {
        if (($model = SafariOperatorRating::find(['id' => $id, 'status' => 1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // public function actionArticle($slug)
    // {
    //     $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (empty($operator)) {
    //         return $this->redirect(['/operator']);
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }


    //     $model = new OperatorQuoteForm();
    //     if (Yii::$app->user->identity) {
    //         $model->email = Yii::$app->user->identity->email;
    //         $model->full_name = Yii::$app->user->identity->name;
    //         $model->phone_no = Yii::$app->user->identity->mobile_no;
    //     }
    //     $model->action_validate_url = '/operator/default/validate';
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($model->validate()) {
    //             if ($operator_quote = $model->request($operator)) {
    //                 FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
    //                 Yii::$app->session->setFlash('success', 'Quote request sent!');
    //                 return $this->redirect(['/operator/default/article',  'slug' => $slug]);
    //             }
    //         }
    //     }

    //     $query = Article::find()->where([
    //         'user_type' => Article::USER_TYPE_SAFARI_OPERATOR,
    //         'status' => Article::STATUS_ACTIVE,
    //         // 'is_approved' => 1,
    //         'user_status' => 1,
    //         'user_id' => $operator->id
    //     ]);
    //     $articledataProvider = new \yii\data\ActiveDataProvider([
    //         'query' => $query,
    //         'pagination' => [
    //             'pageSize' => 20,
    //         ],
    //         'sort' => ['defaultOrder' => [
    //             'id' => SORT_DESC
    //         ]]
    //     ]);
    //     $articles = $articledataProvider->getModels();

    //     return $this->render(
    //         'article',
    //         [
    //             'operator' => $operator,
    //             'model' => $model,
    //             'articles' => $articles,
    //         ]
    //     );
    // }

    public function actionContact($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }


        $model = new OperatorQuoteForm();
        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/sharedsafari',  'slug' => $slug]);
            }
        }

        $ratingsearchModel = new SafariOperatorRatingSearch();
        $ratingsearchModel->safari_operator_id = $operator->id;
        $ratingsearchModel->status = 1;
        $ratingdataProvider = $ratingsearchModel->search($this->request->queryParams);
        $reviews = $ratingdataProvider->getModels();
        $organized_by = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'host_user_id' => $operator->user_id])->limit(3)->all();

        return $this->render(
            'contact',
            [
                'operator' => $operator,
                'model' => $model,
                'organized_by' => $organized_by,
                'reviews' => $reviews,
            ]
        );
    }


    public function actionReportOperator($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new SafariOperatorReportProfileForm();
        $model->user_id = Yii::$app->user->identity->id;
        $model->safari_operator_id = $operator->id;
        $model->status = StatusInterface::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->report_model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Reported successfully!');
                        return $this->redirect(['/operator/default/sharedsafari',  'slug' => $slug]);
                    }
                }
            }
        } else {
            $model->report_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_operator_report', [
                'model' => $model
            ]);
        } else {
            return $this->render('_operator_report', [
                'model' => $model
            ]);
        }
    }


    public function actionSharedsafariseeall($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new OperatorQuoteForm();
        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/sharedsafari',  'slug' => $slug]);
            }
        }

        $shared_safaries = ShareSafari::find()->where([
            'status' => ShareSafari::STATUS_ACTIVE,
            'host_user_id' => $operator->id,
            'type' => ShareSafari::TYPE_FIXED_DEPARTURE
        ])
            ->andWhere(['>=', 'start_date', date("Y-m-d")]);
        $dataProvider = new ActiveDataProvider([
            'query' => $shared_safaries,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        return $this->render(
            'sharedsafariseeall',
            [
                'operator' => $operator,
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]
        );
    }


    public function actionPackageseeall($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new OperatorQuoteForm();
        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/sharedsafari',  'slug' => $slug]);
            }
        }

        $operator_packages = Package::find()->where(['owned_by_id' => $operator->id, 'status' => Package::STATUS_ACTIVE]);
        $dataProvider = new ActiveDataProvider([
            'query' => $operator_packages,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);


        return $this->render(
            'packageseeall',
            [
                'operator' => $operator,
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    public function actionParkseeall($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $operator_parks,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        $model = new OperatorQuoteForm();

        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/view',  'slug' => $slug]);
            }
        }

        return $this->render(
            'viewall',
            [
                'operator' => $operator,
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    // public function actionArticleall($slug)
    // {
    //     $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (empty($operator)) {
    //         return $this->redirect(['/operator']);
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }


    //     $model = new OperatorQuoteForm();
    //     if (Yii::$app->user->identity) {
    //         $model->email = Yii::$app->user->identity->email;
    //         $model->full_name = Yii::$app->user->identity->name;
    //         $model->phone_no = Yii::$app->user->identity->mobile_no;
    //     }
    //     $model->action_validate_url = '/operator/default/validate';
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($model->validate()) {
    //             if ($operator_quote = $model->request($operator)) {
    //                 FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
    //             }
    //             Yii::$app->session->setFlash('success', 'Quote request sent!');
    //             return $this->redirect(['/operator/default/article',  'slug' => $slug]);
    //         }
    //     }

    //     $query = Article::find()->where([
    //         'user_type' => Article::USER_TYPE_SAFARI_OPERATOR,
    //         'status' => Article::STATUS_ACTIVE,
    //         //'is_approved' => 1,
    //         'user_status' => 1,
    //         'user_id' => $operator->id
    //     ]);
    //     $dataProvider = new \yii\data\ActiveDataProvider([
    //         'query' => $query,
    //         'pagination' => [
    //             'pageSize' => 6,
    //         ],
    //         'sort' => ['defaultOrder' => [
    //             'id' => SORT_DESC
    //         ]]
    //     ]);


    //     return $this->render(
    //         'article',
    //         [
    //             'operator' => $operator,
    //             'model' => $model,
    //             'dataProvider' => $dataProvider,
    //         ]
    //     );
    // }

    /**
     * Operator Follower
     */
    public function actionFollower($slug)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }


        $model = new OperatorQuoteForm();
        if (Yii::$app->user->identity) {
            $model->email = Yii::$app->user->identity->email;
            $model->full_name = Yii::$app->user->identity->name;
            $model->phone_no = Yii::$app->user->identity->mobile_no;
        }
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($operator_quote = $model->request($operator)) {
                    // FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
                }
                Yii::$app->session->setFlash('success', 'Quote request sent!');
                return $this->redirect(['/operator/default/article',  'slug' => $slug]);
            }
        }

        $user = User::find()->where(['id' => $operator->user_id])->limit(1)->one();

        return $this->render(
            'follower',
            [
                'operator' => $operator,
                'model' => $model,
                'user' => $user,
            ]
        );
    }


    // public function actionArticleview($article_slug, $slug)
    // {
    //     $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
    //     if (empty($operator)) {
    //         return $this->redirect(['/operator']);
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }


    //     $model = new OperatorQuoteForm();
    //     if (Yii::$app->user->identity) {
    //         $model->email = Yii::$app->user->identity->email;
    //         $model->full_name = Yii::$app->user->identity->name;
    //         $model->phone_no = Yii::$app->user->identity->mobile_no;
    //     }
    //     $model->action_validate_url = '/operator/default/validate';
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($model->validate()) {
    //             if ($operator_quote = $model->request($operator)) {
    //                 FrontendNotificationHelper::operatorNewQuote($operator, $operator_quote, Yii::$app->user->identity);
    //             }
    //             Yii::$app->session->setFlash('success', 'Quote request sent!');
    //             return $this->redirect(['/operator/default/article',  'slug' => $slug]);
    //         }
    //     }
    //     $article = Article::findOne(['slug' => $article_slug, 'user_type' => Article::USER_TYPE_SAFARI_OPERATOR]);

    //     return $this->render(
    //         'articleview',
    //         [
    //             'article' => $article,
    //             'operator' => $operator,
    //             'model' => $model,
    //         ]
    //     );
    // }
}
