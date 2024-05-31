<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaBirdType;
use yii\web\Controller;

/**
 * BirdTypeController.
 */
class BirdTypeController extends Controller
{
    /**
     * Lists all MetaBirdType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaBirdType::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
