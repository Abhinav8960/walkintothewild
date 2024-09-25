<?php

namespace frontend\controllers;


use common\models\cms\article\Article;
use common\models\master\animal\MasterRareAnimal;
use common\models\package\Package;
use common\models\sharesafari\ShareSafari;
use frontend\models\SafariParkSearch;
use frontend\controllers\FrontendBaseController;

/**
 *  PlanSafariController
 */
class PlanSafariController extends FrontendBaseController
{
    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SafariParkSearch();
        // $searchModel->master_location_id = 7;
        // $searchModel->session_id = 1;
        // $searchModel->master_animal_id = 13;
        // $searchModel->master_vehicle_id = 5;
        $dataProvider = $searchModel->search($this->request->queryParams, false);


        // $featured_articles = Article::find()
        //     ->where(['status' => Article::STATUS_ACTIVE])
        //     ->limit(3)->all();
            
        $shared_safaries = ShareSafari::find()->select("*,(SELECT count(1) FROM `share_safari_intrested` WHERE share_safari_id=share_safari.id and share_safari_intrested.status=1) AS `instreted_user_count`")->where(['status' => ShareSafari::STATUS_ACTIVE])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(6)->orderby(['instreted_user_count' => SORT_DESC])->all();

        $packages = Package::find()->where(['status' => Package::STATUS_ACTIVE])->andWhere("owned_by_id IN (SELECT id from safari_operator WHERE status=1)")->limit(3)->orderby("RAND()")->all();

        return $this->render(
            'index',
            [

                // 'featured_articles' => $featured_articles,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'shared_safaries' => $shared_safaries,
                'packages' => $packages,
            ]
        );
    }
}
