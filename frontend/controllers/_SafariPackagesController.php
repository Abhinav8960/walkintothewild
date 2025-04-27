<?php

namespace frontend\controllers;


use common\models\cms\article\Article;
use common\models\master\animal\MasterRareAnimal;
use common\models\package\Package;
use common\models\package\PackageSearch;
use common\models\sharesafari\ShareSafari;
use frontend\models\SafariParkSearch;
use frontend\controllers\FrontendBaseController;
use Yii;

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
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, false);


        $packages = Package::find()->where(['status' => PackageVersion::APPROVED_AND_LIVE_STATUS])->limit(9)->orderby("RAND()")->all();
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


    /**
     * Get Redirect URL
     */
    public function actionGeturl()
    {
        if (Yii::$app->request->isPost) {
            // Initialize URL with the base route
            $url = ['/package'];

            // Loop through the payload parameters
            foreach (Yii::$app->request->post('PackageVersionSearch') as $key => $value) {
                // Only add parameters that are not empty
                if (!empty($value)) {
                    $url['PackageVersionSearch[' . $key . ']'] = $value;
                } else {
                    $url['PackageVersionSearch[' . $key . ']'] = '';
                }
            }

            // Construct the redirect URL
            return \yii\helpers\Url::to($url);
        }
    }
}
