<?php

namespace frontend\modules\park\controllers;

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\park\SafariPark;
use common\models\park\SafariParkMonth;
use common\models\RenderedContent;
use common\models\suggestions\form\SafariSuggestionsForm;
use frontend\models\SafariOperatorSearch;
use frontend\models\SafariParkSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SafariParkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();
        $featured_articles = Article::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(8)->orderBy(['sequence' => SORT_ASC])->all();
        $rare_exotics = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'animal_type_sequence', ''])->limit(5)->orderBy(['animal_type_sequence' => SORT_ASC])->all();
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
        $dataProvider = $searchModel->search($this->request->queryParams);



        $model = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE, 'slug' => $slug])->limit(1)->one();
        if ($model) {
            $operatorsearchModel = new SafariOperatorSearch();
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
    public function actionParklist()
    {
        $searchModel = new SafariParkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $models = $dataProvider->getModels();
        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();

        return $this->render('parklist', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
            'featured_parks' => $featured_parks,
        ]);
    }
}
