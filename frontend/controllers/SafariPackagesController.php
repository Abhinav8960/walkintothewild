<?php

namespace frontend\controllers;


use common\models\cms\article\Article;
use common\models\master\animal\MasterRareAnimal;
use common\models\package\Package;
use common\models\sharesafari\ShareSafari;
use frontend\models\SafariParkSearch;
use frontend\controllers\FrontendBaseController;

/**
 *  SafariPackagesController
 */
class SafariPackagesController extends FrontendBaseController
{
    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SafariParkSearch();
        $searchModel->master_location_id = 7;
        $searchModel->session_id = 1;
        $searchModel->master_animal_id = 13;
        $searchModel->master_vehicle_id = 5;
        $dataProvider = $searchModel->search($this->request->queryParams, false);


        $packages = Package::find()->where(['status' => Package::STATUS_ACTIVE])->limit(9)->orderby("RAND()")->all();
        $shared_safaries = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE])->limit(3)->orderby("RAND()")->all();

        return $this->render(
            'index',
            [

                'packages' => $packages,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'shared_safaries' => $shared_safaries,
            ]
        );
    }
}
