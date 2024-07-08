<?php

namespace frontend\modules\operator\controllers;

use Yii;
use yii\helpers\Url;
use common\models\GeneralModel;
use yii\web\NotFoundHttpException;
use frontend\models\SafariParkSearch;
use frontend\models\OperatorQuoteForm;
use frontend\models\SafariOperatorSearch;
use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use frontend\models\SafariOperatorReviewForm;
use common\models\operator\SafariOperatorPark;
use common\models\operator\SafariOperatorFollow;
use common\models\operator\SafariOperatorRating;
use frontend\controllers\FrontendBaseController;
use frontend\models\SafariOperatorRatingReportForm;
use common\models\operator\SafariOperatorRatingSearch;

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

        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->all();
        $model = new OperatorQuoteForm();
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->request($operator)) {
            Yii::$app->session->setFlash('success', 'quote Requested Successfully submitted');
            return $this->redirect(['/operator/default/view',  'slug' => $slug]);
        }


        return $this->render(
            'view',
            [
                'operator' => $operator,
                'model' => $model,
                'operator_parks' => $operator_parks
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
        if (empty($operator)) {
            return $this->redirect(['/operator']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $ratingsearchModel = new SafariOperatorRatingSearch();
        $ratingsearchModel->custom_sort_by = $sort_by;
        $ratingsearchModel->safari_operator_id = $operator->id;
        $ratingsearchModel->status = 1;
        $ratingdataProvider = $ratingsearchModel->search($this->request->queryParams);
        $reviews = $ratingdataProvider->getModels();

        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->all();
        $model = new OperatorQuoteForm();
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->request($operator)) {
            Yii::$app->session->setFlash('success', 'quote Requested Successfully submitted');
            return $this->redirect(['/operator/default/reviewlist',  'slug' => $slug]);
        }


        return $this->render(
            'reviewlist',
            [
                'operator' => $operator,
                'model' => $model,
                'operator_parks' => $operator_parks,
                'reviews' => $reviews,
                'ratingsearchModel' => $ratingsearchModel,
                'ratingdataProvider' => $ratingdataProvider,
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
        $shared_safaries = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'host_user_id' => $operator->user_id])->all();


        $operator_parks = SafariOperatorPark::find()->where(['safari_operator_id' => $operator->id, 'status' => 1])->all();
        $model = new OperatorQuoteForm();
        $model->action_validate_url = '/operator/default/validate';
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->request($operator)) {
            Yii::$app->session->setFlash('success', 'quote Requested Successfully submitted');
            return $this->redirect(['/operator/default/sharedsafari',  'slug' => $slug]);
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
    public function actionFollow($id)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if ($operator) {
            if (Yii::$app->user->identity) {
                $operator_follow = SafariOperatorFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'safari_operator_id' => $id])->one();
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
                $operator_follow->safari_operator_id = $id;
                $operator_follow->user_id = Yii::$app->user->identity->id;
                $operator_follow->status = 1;
                $operator_follow->follow_datetime = date('Y-m-d h:i:s');
                if ($operator_follow->save()) {
                    Yii::$app->session->setFlash('success', 'You are start following ' . $operator->business_name);
                } else {
                    Yii::$app->session->setFlash('error', 'You can not follow this operator currently!');
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/operator/default/follow', 'id' => $operator->id])]);
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/view', 'slug' => $operator->slug]));
        }
        return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/index']));
    }


    /**
     * Follow Operator
     */
    public function actionUnfollow($id)
    {
        $operator = SafariOperator::find()->where(['status' => SafariOperator::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if ($operator) {
            if (Yii::$app->user->identity) {
                $operator_follow = SafariOperatorFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'safari_operator_id' => $id])->one();
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
                    $operator_follow->safari_operator_id = $id;
                    $operator_follow->user_id = Yii::$app->user->identity->id;
                    $operator_follow->status = 0; //UNfollow
                    $operator_follow->unfollow_datetime = date('Y-m-d h:i:s');
                    if ($operator_follow->save()) {
                        Yii::$app->session->setFlash('error', 'You UnFollowed ' . $operator->business_name);
                    } else {
                        Yii::$app->session->setFlash('error', 'You can not unfollow this operator currently!');
                    }
                }
            } else {
                return $this->redirect(['/site/auth?authclient=google&referrer=' . Url::toRoute(['/operator/default/unfollow', 'id' => $operator->id])]);
            }
            return $this->redirect(\yii\helpers\Url::toRoute(['/operator/default/view', 'slug' => $operator->slug]));
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
                        Yii::$app->session->setFlash('success', 'Thanks for Review!!');
                        return $this->redirect([
                            '/operator/default/reviewlist',
                            'slug' => $operator->slug,
                            '#' => 'viewcontent'
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


    // public function actionReviewupdate($operator_id, $user_id)
    // {
    //     $rating_model = SafariOperatorRating::find()->where(['user_id' => $user_id, 'safari_operator_id' => $operator_id])->one();
    //     $model = new SafariOperatorReviewForm($rating_model);
    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->rating_model->save(false)) {
    //                     $model->updateRatingintoTable($rating_model);
    //                     Yii::$app->session->setFlash('success', 'Thanks for Review!!');
    //                     return $this->redirect([
    //                         '/operator/default/reviewlist',
    //                         'slug' => $rating_model->slug,
    //                         '#' => 'viewcontent'
    //                     ]);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->rating_model->loadDefaultValues();
    //     }
    //     if (Yii::$app->request->isAjax) {
    //         return $this->renderAjax('_review_form', [
    //             'model' => $model,
    //             'operator_id' => $operator_id,
    //         ]);
    //     }
    // }

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
                        Yii::$app->session->setFlash('success', 'Review Reported Successfully!');
                        return $this->redirect([
                            '/operator/default/reviewlist',
                            'slug' => $operator->slug,
                            '#' => 'viewcontent'
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
}
