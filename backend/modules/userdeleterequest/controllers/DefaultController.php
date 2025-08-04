<?php

namespace backend\modules\userdeleterequest\controllers;

use common\models\UserDeleteRequest;
use common\models\UserDeleteRequestSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserDeleteRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());
    
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

}
