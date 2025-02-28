<?php

namespace backend\modules\urlshortner\controllers;

use common\models\urlshortner\form\UrlShortnerForm;
use common\models\urlshortner\UrlShortner;
use common\models\urlshortner\UrlShortnerSearch;
use yii\web\Controller;

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
        $searchModel = new UrlShortnerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    public function actionCreate()
    {
        $model = new UrlShortnerForm();
        $model->status = 1;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->url_shortner_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Created Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->url_shortner_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
