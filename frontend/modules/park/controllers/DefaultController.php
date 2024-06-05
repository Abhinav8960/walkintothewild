<?php

namespace frontend\modules\park\controllers;

use common\models\park\SafariPark;
use frontend\models\SafariParkSearch;
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

        $searchModel = new SafariParkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();
        return $this->render(
            'index',
            [
                'featured_parks' => $featured_parks,
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
        $featured_parks = SafariPark::find()->where(['status' => SafariPark::STATUS_ACTIVE])->andWhere(['!=', 'sequence', ''])->limit(5)->orderBy(['sequence' => SORT_ASC])->all();

        return $this->render(
            'view',
            [
                'model' => $model,
                'featured_parks' => $featured_parks,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
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
