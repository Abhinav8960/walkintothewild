<?php

namespace frontend\modules\park\controllers;

use Yii;
use yii\web\Controller;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use common\models\RenderedContent;
use yii\web\NotFoundHttpException;
use frontend\models\SafariParkSearch;
use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\park\SafariParkMonth;
use frontend\models\SafariOperatorSearch;
use common\models\master\animal\MasterRareAnimal;
use common\models\suggestions\form\SafariSuggestionsForm;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->view->on(\yii\web\View::EVENT_AFTER_RENDER, function ($event) {
            // Save rendered content and other details to the database
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $renderedContent = new RenderedContent();
                $renderedContent->created_at = date('Y-m-d H:i:s');
                $renderedContent->url = Yii::$app->request->absoluteUrl;
                $renderedContent->title = Yii::$app->view->title;
                $renderedContent->action_url = Yii::$app->request->url;

                // Save query parameters to a separate column
                $queryParams = Yii::$app->request->getQueryParams();
                $renderedContent->query_params = json_encode($queryParams); // Save query parameters as JSON

                // Add device info and IP address
                $renderedContent->user_agent = Yii::$app->request->userAgent;
                $renderedContent->ip_address = Yii::$app->request->userIP;

                if ($renderedContent->save()) {
                    $transaction->commit();
                } else {
                    Yii::error('Failed to save rendered content: ' . json_encode($renderedContent->errors));
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                Yii::error('Exception occurred while saving rendered content: ' . $e->getMessage());
                $transaction->rollBack();
            }
        });
    }

    public function device()
    {
        return (\Yii::$app->mobileDetect->isMobile()) ? 'mobile' : 'desktop';
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariParkSearch();
        $searchModel->master_location_id = 7;
        $searchModel->month_id = GeneralModel::removeLeadingChar(date('m'));
        $searchModel->master_animal_id = 13;
        $searchModel->master_vehicle_id = 5;
        $dataProvider = $searchModel->search($this->request->queryParams, false);

        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();
        $featured_articles = Article::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(8)->orderBy(['sequence' => SORT_ASC])->all();
        $rare_exotics = MasterRareAnimal::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'is_feature_sequence', ''])->limit(10)->orderBy(['is_feature_sequence' => SORT_ASC])->all();
        return $this->render(
            'index',
            [
                'featured_parks' => $featured_parks,
                'featured_articles' => $featured_articles,
                'rare_exotics' => $rare_exotics,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $searchModel = new SafariParkSearch();
        $searchModel->master_location_id = 7;
        $searchModel->month_id = GeneralModel::removeLeadingChar(date('m'));
        $searchModel->master_animal_id = 13;
        $searchModel->master_vehicle_id = 5;
        $dataProvider = $searchModel->search($this->request->queryParams);



        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($model) {
            $operatorsearchModel = new SafariOperatorSearch();
            $operatorsearchModel->status = 1;
            $operatordataProvider = $operatorsearchModel->search($this->request->queryParams, $model->id);
            $operators = $operatordataProvider->getModels();

            $first_month = SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->limit(1)->orderBy(['month_id' => SORT_ASC])->one();
            $last_month = SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->limit(1)->orderBy(['month_id' => SORT_DESC])->one();
            $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();



            $request = Yii::$app->request;
            $ip_address = $request->getRemoteIP();

            $suggestionmodel = new SafariSuggestionsForm();
            $suggestionmodel->status = StatusInterface::STATUS_ACTIVE;
            $suggestionmodel->park_id = isset($model) ? $model->id : '';
            $suggestionmodel->ip_address = $ip_address;
            $suggestionmodel->action_url = '/park/' . $slug . '';
            $suggestionmodel->action_validate_url = '/park/default/validate';

            if ($this->request->isPost) {
                if ($suggestionmodel->load($this->request->post())) {
                    if ($suggestionmodel->validate()) {
                        $suggestionmodel->initializeForm();
                        if ($suggestionmodel->safari_suggestion_model->save(false)) {
                            \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                            return $this->redirect(['/park/' . $slug . '']);
                        }
                    } else {
                        print_r($suggestionmodel->errors);
                        exit;
                    }
                }
            } else {
                $suggestionmodel->safari_suggestion_model->loadDefaultValues();
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render(
            'view',
            [
                'model' => $model,
                'featured_parks' => $featured_parks,
                'first_month' => $first_month,
                'last_month' => $last_month,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'suggestionmodel' => $suggestionmodel,

                'operatorsearchModel' => $operatorsearchModel,
                'operatordataProvider' => $operatordataProvider,
                'operators' => $operators,
                'device' => $this->device(),
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
    public function actionParklist($master_location_id = 7, $month_id = null, $master_animal_id = 13, $master_vehicle_id = 5)
    {
        $searchModel = new SafariParkSearch();
        if ($master_location_id) {
            $searchModel->master_location_id = $master_location_id;
        }
        if ($month_id <> 0) {
            if ($month_id) {
                $searchModel->month_id = $month_id;
            } else {
                $searchModel->month_id = GeneralModel::removeLeadingChar(date('m'));
            }
        }
        if ($master_animal_id) {
            $searchModel->master_animal_id = $master_animal_id;
        }
        if ($master_vehicle_id) {
            $searchModel->master_vehicle_id = $master_vehicle_id;
        }
        $dataProvider = $searchModel->search($this->request->queryParams, false);
        $models = $dataProvider->getModels();
        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();

        return $this->render('parklist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'featured_parks' => $featured_parks,
            'device' => $this->device(),
        ]);
    }


    /**
     * Get Redirect URL
     */
    public function actionGeturl()
    {
        if (Yii::$app->request->isPost) {
            $url = ['/park/default/parklist'];
            if (isset(Yii::$app->request->bodyParams['SafariParkSearch'])) {
                foreach (Yii::$app->request->bodyParams['SafariParkSearch'] as $key => $value) {
                    if (in_array($key, ['master_location_id', 'month_id', 'master_animal_id', 'master_vehicle_id'])) {
                        if ($value) {
                            $url[$key] = $value;
                        } else {
                            $url[$key] = 0;
                        }
                    } else {
                        if ($value) {
                            $url['SafariParkSearch[' . $key . ']'] = $value;
                        }
                    }
                }
            }
            return \yii\helpers\Url::toRoute($url);
        }
    }
}
