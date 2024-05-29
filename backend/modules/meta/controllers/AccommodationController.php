<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaAccommodation;
use yii\web\Controller;

/**
 * AccommodationController.
 */
class AccommodationController extends Controller
{
    /**
     * Lists all MetaAccommodation models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaAccommodation::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
