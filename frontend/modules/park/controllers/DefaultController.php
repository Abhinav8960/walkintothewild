<?php

namespace frontend\modules\park\controllers;

use Yii;
use yii\helpers\Url;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use yii\web\NotFoundHttpException;
use frontend\models\SafariParkSearch;
use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\park\SafariParkMonth;
use common\models\park\SafariParkRating;
use frontend\models\SafariOperatorSearch;
use frontend\models\SafariParkReviewForm;
use common\models\sharesafari\ShareSafari;
use common\models\park\SafariParkRatingSearch;
use common\models\suggestions\SafariSuggestions;
use frontend\controllers\FrontendBaseController;
use common\models\master\animal\MasterRareAnimal;
use common\models\suggestions\form\SafariSuggestionsForm;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{
    public $action_ids = ['index', 'view', 'parklist'];

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        return $this->redirect('/');
        $searchModel = new SafariParkSearch();
        $searchModel->master_location_id = 7;
        $searchModel->session_id = 1;
        $searchModel->master_animal_id = 13;
        $searchModel->master_vehicle_id = 5;
        $dataProvider = $searchModel->search($this->request->queryParams, false);


        $featured_articles = Article::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(8)->orderBy(['sequence' => SORT_ASC])->all();
        $rare_exotics = MasterRareAnimal::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'is_feature_sequence', ''])->limit(10)->orderBy(['is_feature_sequence' => SORT_ASC])->all();
        $shared_safaries = ShareSafari::find()->where(['status' => SafariPark::STATUS_ACTIVE])->limit(2)->orderby("RAND()")->all();

        return $this->render(
            'index',
            [

                'featured_articles' => $featured_articles,
                'rare_exotics' => $rare_exotics,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'shared_safaries' => $shared_safaries,
            ]
        );
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/parklist']);
            // throw new NotFoundHttpException('The requested page does not exist.');
        }
        $searchModel = new SafariParkSearch();
        // $searchModel->master_location_id = 7;
        // $searchModel->session_id = 1;
        // $searchModel->master_animal_id = 13;
        // $searchModel->master_vehicle_id = 5;
        $searchModel->id = $model->slug; // for show Selected Park name in search
        $dataProvider = $searchModel->search($this->request->queryParams);


        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;
        $operatordataProvider = $operatorsearchModel->search($this->request->queryParams, $model->id);
        $operators = $operatordataProvider->getModels();

        // $first_month = SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->limit(1)->orderBy(['month_id' => SORT_ASC])->one();
        // $last_month = SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->limit(1)->orderBy(['month_id' => SORT_DESC])->one();
        $shared_safaries = ShareSafari::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'park_id' => $model->id])->limit(4)->all();




        // $request = Yii::$app->request;
        // $ip_address = $request->getRemoteIP();

        // $suggestionmodel = new SafariSuggestionsForm();
        // $suggestionmodel->name = Yii::$app->user->identity->name;
        // $suggestionmodel->email = Yii::$app->user->identity->email;
        // $suggestionmodel->status = StatusInterface::STATUS_ACTIVE;
        // $suggestionmodel->park_id = isset($model) ? $model->id : '';
        // $suggestionmodel->ip_address = $ip_address;
        // $suggestionmodel->action_url = '/park/' . $slug . '';
        // $suggestionmodel->action_validate_url = '/park/default/validate';

        // if ($this->request->isPost) {
        //     if ($suggestionmodel->load($this->request->post())) {
        //         if ($suggestionmodel->validate()) {
        //             $suggestionmodel->initializeForm();
        //             if ($suggestionmodel->safari_suggestion_model->save(false)) {
        //                 \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
        //                 return $this->redirect(['/park/' . $slug . '']);
        //             }
        //         } else {
        //             print_r($suggestionmodel->errors);
        //             exit;
        //         }
        //     }
        // } else {
        //     $suggestionmodel->safari_suggestion_model->loadDefaultValues();
        // }



        $ratingsearchModel = new SafariParkRatingSearch();
        $ratingsearchModel->safari_park_id = $model->id;
        $ratingsearchModel->status = 1;
        $ratingdataProvider = $ratingsearchModel->search($this->request->queryParams);
        $reviews = $ratingdataProvider->getModels();

        return $this->render(
            'view',
            [
                'model' => $model,
                // 'first_month' => $first_month,
                // 'last_month' => $last_month,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'suggestionmodel' => $suggestionmodel,

                'operatorsearchModel' => $operatorsearchModel,
                'operatordataProvider' => $operatordataProvider,
                'operators' => $operators,
                'shared_safaries' => $shared_safaries,
                'device' => $this->device(),
                'reviews' => $reviews
            ]
        );
    }

    public function actionReviewlist($slug, $sort_by = null)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/parklist']);
            // throw new NotFoundHttpException('The requested page does not exist.');
        }


        $searchModel = new SafariParkRatingSearch();
        $searchModel->safari_park_id = $model->id;
        $searchModel->status = 1;
        $searchModel->custom_sort_by = $sort_by;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $reviews = $dataProvider->getModels();

        return $this->render(
            'reviewlist',
            [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'device' => $this->device(),
                'reviews' => $reviews
            ]
        );
    }

    public function actionContributionlist($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/parklist']);
            // throw new NotFoundHttpException('The requested page does not exist.');
        }


        $suggestions = SafariSuggestions::find()->where(['park_id' => $model->id, 'status' => 1])->all();

        return $this->render(
            'contributionlist',
            [
                'model' => $model,
                'suggestions' => $suggestions
            ]
        );
    }

    /**
     * Suggestion Model
     */
    public function actionSuggestion($park_id)
    {
        $safari_park = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'id' => $park_id])->limit(1)->one();
        $model = new SafariSuggestionsForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->is_approved = 0;
        $model->park_id = $park_id;
        $model->name = Yii::$app->user->identity->name;
        $model->email = Yii::$app->user->identity->email;
        $model->phone = Yii::$app->user->identity->mobile_no;
        $model->ip_address = Yii::$app->request->getRemoteIP();
        $model->action_url = '/park/default/suggestion?park_id=' . $safari_park->id . '';
        $model->action_validate_url = '/park/default/validate';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_suggestion_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/park/' . $safari_park->slug . '']);
                    }
                }
            }
        } else {
            $model->safari_suggestion_model->loadDefaultValues();
        }


        return $this->renderAjax('_suggestion_form', [
            'model' => $model,
            'safari_park' => $safari_park,
        ]);
    }



    /**
     * Validate 
     *
     * @param [type] $id
     * @return void
     */
    public function actionValidate($id = null)
    {
        $suggestionmodel = new SafariSuggestionsForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $suggestionmodel = new SafariSuggestionsForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $suggestionmodel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($suggestionmodel);
        }
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionParklist($master_location_id = null, $session_id = null, $master_animal_id = null, $master_vehicle_id = null)
    {
        $searchModel = new SafariParkSearch();
        if ($master_location_id) {
            $searchModel->master_location_id = $master_location_id;
        }
        if ($session_id) {
            $searchModel->session_id = $session_id;
        }
        if ($master_animal_id) {
            $searchModel->master_animal_id = $master_animal_id;
        }
        if ($master_vehicle_id) {
            $searchModel->master_vehicle_id = $master_vehicle_id;
        }
        $dataProvider = $searchModel->search($this->request->queryParams);
        $models = $dataProvider->getModels();

        return $this->render('parklist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'device' => $this->device(),
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionRareanimal($slug)
    {
        $rare_animal = MasterRareAnimal::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        $searchModel = new SafariParkSearch();
        if ($rare_animal) {
            $searchModel->master_rare_animal_id = $rare_animal->id;
        }

        $dataProvider = $searchModel->search($this->request->queryParams);
        $models = $dataProvider->getModels();

        return $this->render('rareanimal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'device' => $this->device(),
            'slug' => $slug,
        ]);
    }

    /**
     * Get Redirect URL
     */
    public function actionGeturl()
    {
        if (Yii::$app->request->isPost) {
            // Initialize URL with the base route
            $url = ['/parklist'];

            // Loop through the payload parameters
            foreach (Yii::$app->request->post('SafariParkSearch') as $key => $value) {
                // Only add parameters that are not empty
                if (!empty($value)) {
                    $url['SafariParkSearch[' . $key . ']'] = $value;
                } else {
                    // $url['SafariParkSearch[' . $key . ']'] = 0;
                }
            }

            // Construct the redirect URL
            return \yii\helpers\Url::to($url);
        }
    }




    public function actionReview($park_id)
    {
        $safari_park = SafariPark::find()->where(['id' => $park_id])->one();
        if (!$safari_park) {
            return $this->redirect(['/parklist']);
        }

        $model = new SafariParkReviewForm();
        $model->safari_park_id = $park_id;
        $model->status = StatusInterface::STATUS_SUSPEND;
        $model->action_url = '/park/default';
        $model->action_validate_url = '/park/default/validatereview';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->rating_model->save(false)) {
                        $model->updateRatingintoTable($safari_park);
                        Yii::$app->session->setFlash('success', 'Thanks for Review!!');
                        return $this->redirect(Url::toRoute(['/park/default/reviewlist', 'slug' => $safari_park->slug, '#' => 'safari_tour_operator_container']));
                    }
                }
            }
        } else {
            $model->rating_model->loadDefaultValues();
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_review_form', [
                'model' => $model,
                'park_id' => $park_id,
            ]);
        }
    }


    public function actionReviewupdate($park_id, $user_id, $id)
    {
        $safari_park = SafariPark::find()->where(['id' => $park_id])->one();
        $rating_model = SafariParkRating::find()->where(['user_id' => $user_id, 'safari_park_id' => $park_id, 'id' => $id])->one();
        $model = new SafariParkReviewForm($rating_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->rating_model->save(false)) {
                        $model->updateRatingintoTable($safari_park);
                        Yii::$app->session->setFlash('success', 'Thanks for Edit Review!!');
                        return $this->redirect([
                            '/park/' . $safari_park->slug . ''
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
                'park_id' => $park_id,
            ]);
        }
    }


    public function actionValidatereview($id = null)
    {
        $model = new SafariParkReviewForm();
        if ($id != null) {
            $rating_model = $this->findModel($id);
            $model = new SafariParkReviewForm($rating_model);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
}
