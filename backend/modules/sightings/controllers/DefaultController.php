<?php

namespace backend\modules\sightings\controllers;

use common\models\sighting\Sighting;
use common\models\sighting\SightingSearch;
use Yii;
use yii\web\Controller;

/**
 * DefaultController for the `sightings` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SightingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $sighting = Sighting::find()->where(['id' => $id])->limit(1)->one();
        if (!$sighting) {
            \Yii::$app->session->setFlash('danger', 'Sighting not Found!!!');
            return $this->redirect(['index']);
        }
        return $this->renderAjax('view', [
            'model' => $sighting,
        ]);
    }
}
