<?php

namespace backend\modules\userdeleterequest\controllers;

use common\models\UserDeleteRequest;
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
        $dataProvider = new ActiveDataProvider([
            'query' => UserDeleteRequest::find(),
            'pagination' => [
                'pageSize' => 20, 
            ],
        ]);
    
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
