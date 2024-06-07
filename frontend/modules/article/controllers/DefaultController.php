<?php

namespace frontend\modules\article\controllers;

use common\interfaces\StatusInterface;
use common\models\park\SafariPark;
use frontend\models\ArticleSearch;
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
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $models = $dataProvider->getModels();


        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();
        return $this->render('index', [
            'featured_parks' => $featured_parks,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
        ]);
    }
}
