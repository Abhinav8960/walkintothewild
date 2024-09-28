<?php

namespace frontend\controllers;


use common\models\cms\article\Article;
use common\models\master\animal\MasterRareAnimal;
use common\models\sharesafari\ShareSafari;
use frontend\controllers\FrontendBaseController;
use frontend\models\ShareSafariSearch;
use Yii;

/**
 *  SharedSafariController
 */
class SharedSafariController extends FrontendBaseController
{
    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShareSafariSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, false);


        $shared_safaries = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE])->limit(12)->orderby("RAND()")->all();

        return $this->render(
            'index',
            [
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
            $url = ['/sharedsafari'];

            // Loop through the payload parameters
            foreach (Yii::$app->request->post('ShareSafariSearch') as $key => $value) {
                // Only add parameters that are not empty
                if (!empty($value)) {
                    $url['ShareSafariSearch[' . $key . ']'] = $value;
                } else {
                    $url['ShareSafariSearch[' . $key . ']'] = '';
                }
            }

            // Construct the redirect URL
            return \yii\helpers\Url::to($url);
        }
    }
}
