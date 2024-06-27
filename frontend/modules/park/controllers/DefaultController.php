<?php

namespace frontend\modules\park\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\park\SafariParkMonth;
use common\models\master\animal\MasterRareAnimal;
use common\models\suggestions\form\SafariSuggestionsForm;
use frontend\models\SafariParkSearch;
use frontend\models\SafariOperatorSearch;
use frontend\controllers\FrontendBaseController;

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
        $searchModel = new SafariParkSearch();
        $searchModel->master_location_id = 7;
        $searchModel->session_id = 1;
        $searchModel->master_animal_id = 13;
        $searchModel->master_vehicle_id = 5;
        $dataProvider = $searchModel->search($this->request->queryParams, false);


        $featured_articles = Article::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(8)->orderBy(['sequence' => SORT_ASC])->all();
        $rare_exotics = MasterRareAnimal::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'is_feature_sequence', ''])->limit(10)->orderBy(['is_feature_sequence' => SORT_ASC])->all();
        return $this->render(
            'index',
            [

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
        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if (!$model) {
            return $this->redirect(['/parklist']);
            // throw new NotFoundHttpException('The requested page does not exist.');
        }
        $searchModel = new SafariParkSearch();
        $searchModel->master_location_id = 7;
        $searchModel->session_id = 1;
        $searchModel->master_animal_id = 13;
        $searchModel->master_vehicle_id = 5;
        $dataProvider = $searchModel->search($this->request->queryParams);


        $operatorsearchModel = new SafariOperatorSearch();
        $operatorsearchModel->status = 1;
        $operatordataProvider = $operatorsearchModel->search($this->request->queryParams, $model->id);
        $operators = $operatordataProvider->getModels();

        $first_month = SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->limit(1)->orderBy(['month_id' => SORT_ASC])->one();
        $last_month = SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->limit(1)->orderBy(['month_id' => SORT_DESC])->one();




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


        return $this->render(
            'view',
            [
                'model' => $model,
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
    public function actionParklist($master_location_id = 7, $session_id = 3, $master_animal_id = 13, $master_vehicle_id = 5)
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
        $dataProvider = $searchModel->search($this->request->queryParams, false);
        $models = $dataProvider->getModels();

        return $this->render('parklist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
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
