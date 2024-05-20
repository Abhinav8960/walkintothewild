<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaOperatorCredibility;
use yii\web\Controller;

/**
 * OperatorCredibilityController.
 */
class OperatorCredibilityController extends Controller
{
    /**
     * Lists all OperatorCredibilityController models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaOperatorCredibility::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
