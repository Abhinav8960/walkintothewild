<?php

namespace frontend\modules\park\controllers;

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\park\SafariPark;
use common\models\park\SafariParkMonth;
use common\models\suggestions\form\SafariSuggestionsForm;
use frontend\models\SafariParkSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

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
