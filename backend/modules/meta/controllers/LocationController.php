<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaLocation;

use yii\web\Controller;

/**
 * LocationController.
 */
class LocationController extends Controller
{
    /**
     * Lists all MetaLocation models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaLocation::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
