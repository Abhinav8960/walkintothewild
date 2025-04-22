<?php

namespace frontend\modules\park\controllers;

use Yii;
use yii\helpers\Url;
use common\models\GeneralModel;
use yii\data\ActiveDataProvider;
use common\models\package\Package;
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
use common\models\package\PackageSafariPark;
use common\models\master\animal\MasterAnimal;
use common\models\park\SafariParkRatingSearch;
use common\models\suggestions\SafariSuggestions;
use frontend\controllers\FrontendBaseController;
use common\models\suggestions\form\SafariSuggestionsForm;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{
    public $action_ids = ['index', 'view'];



    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariParkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, false);
        $models = $dataProvider->getModels();

        return $this->render('index', [
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
    public function actionView($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/park']);
            // throw new NotFoundHttpException('The requested page does not exist.');
        }
        $searchModel = new SafariParkSearch();
        $searchModel->id = $model->slug; // for show Selected Park name in search
        $dataProvider = $searchModel->search($this->request->queryParams);


        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;
        $operatordataProvider = $operatorsearchModel->search($this->request->queryParams, $model->id);
        $operators = $operatordataProvider->getModels();

        $shared_safaries = ShareSafari::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'park_id' => $model->id])->limit(4)->all();

        $ratingsearchModel = new SafariParkRatingSearch();
        $ratingsearchModel->safari_park_id = $model->id;
        $ratingsearchModel->status = 1;
        $ratingdataProvider = $ratingsearchModel->search($this->request->queryParams);
        $reviews = $ratingdataProvider->getModels();

        return $this->render(
            'view',
            [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'operatorsearchModel' => $operatorsearchModel,
                'operatordataProvider' => $operatordataProvider,
                'operators' => $operators,
                'shared_safaries' => $shared_safaries,
                'device' => $this->device(),
                'reviews' => $reviews
            ]
        );
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionOperator($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/park']);
        }
        $searchModel = new SafariParkSearch();
        $searchModel->id = $model->slug; // for show Selected Park name in search
        $dataProvider = $searchModel->search($this->request->queryParams);


        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;
        $operatordataProvider = $operatorsearchModel->search($this->request->queryParams, $model->id);
        $operators = $operatordataProvider->getModels();

        $shared_safaries = ShareSafari::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'park_id' => $model->id])->limit(4)->all();

        $ratingsearchModel = new SafariParkRatingSearch();
        $ratingsearchModel->safari_park_id = $model->id;
        $ratingsearchModel->status = 1;
        $ratingdataProvider = $ratingsearchModel->search($this->request->queryParams);
        $reviews = $ratingdataProvider->getModels();

        return $this->render(
            'view',
            [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
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
            return $this->redirect(['/park']);
        }

        $my_review = SafariParkRating::find()->where(['safari_park_id' => $model->id, 'user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->one();

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
                'reviews' => $reviews,
                'my_review' => $my_review
            ]
        );
    }

    public function actionContributionlist($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/park']);
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
        if (Yii::$app->user->identity) {
            $model = new SafariSuggestionsForm();
            $model->status = SafariSuggestions::STATUS_ACTIVE;
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
                            \Yii::$app->session->setFlash('success', 'Suggestion Submitted Successfully');
                            return $this->redirect(['/park/' . $safari_park->slug . '']);
                        }
                    }
                }
            } else {
                $model->safari_suggestion_model->loadDefaultValues();
            }
        } else {
            $model = null;
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
    public function actionRareanimal($slug)
    {
        $rare_animal = MasterAnimal::find()->where(['status' => MasterAnimal::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        $searchModel = new SafariParkSearch();
        if ($rare_animal) {
            $searchModel->master_rare_animal_id = $rare_animal->id;
            $searchModel->master_animal_id = $rare_animal->id;
        }

        $dataProvider = $searchModel->search($this->request->queryParams, false);
        $models = $dataProvider->getModels();

        return $this->render('rareanimal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'device' => $this->device(),
            'slug' => $slug,
            'rare_animal' => $rare_animal
        ]);
    }

    /**
     * Get Redirect URL
     */
    public function actionGeturl()
    {
        if (Yii::$app->request->isPost) {
            // Initialize URL with the base route
            $url = ['/park'];

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
            return $this->redirect(['/park']);
        }

        $model = new SafariParkReviewForm();
        $model->safari_park_id = $park_id;
        $model->status = SafariParkRating::STATUS_SUSPEND;
        $model->action_url = '/park/default';
        $model->action_validate_url = '/park/default/validatereview';
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->rating_model->save(false)) {
                        $model->updateRatingintoTable($safari_park);
                        Yii::$app->session->setFlash('success', 'Thanks for Review! Your review sent for approval');
                        return $this->redirect(Url::toRoute(['/park/default/reviewlist', 'slug' => $safari_park->slug]));
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


    public function actionSharedsafari($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/park']);
        }
        $shared_safaries_query = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'park_id' => $model->id])->andWhere(['>=', 'start_date', date("Y-m-d")]);

        $dataProvider = new ActiveDataProvider([
            'query' => $shared_safaries_query,
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        return $this->render(
            '_shared_safari',
            [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    public function actionDiscussion($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/park']);
        }

        return $this->render(
            '_discussion',
            [
                'model' => $model,
            ]
        );
    }

    public function actionUpdate($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/park']);
        }
        return $this->render(
            '_update',
            [
                'model' => $model,
            ]
        );
    }

    public function actionPackage($slug)
    {
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/park']);
        }

        $park_id = $model->id;
        $query = Package::find()->where(['package.status' => Package::APPROVED_AND_LIVE_STATUS]);
        $query->joinwith(['packagepark' => function ($query) use ($park_id) {
            $query->andWhere(['park_id' => $park_id, 'package_safari_park.status' => 1]);
        }]);

        return $this->render(
            '_package',
            [
                'model' => $model,
                'packages' => $query->all(),
            ]
        );
    }
}
