<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaStayCategory;
use yii\web\Controller;

/**
 * StayCategoryController.
 */
class StayCategoryController extends Controller
{
    /**
     * Lists all MetaStayCategory models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaStayCategory::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
