<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaParkTripSlot;
use yii\web\Controller;

/**
 * ParkTripSlotController.
 */
class ParkTripSlotController extends Controller
{
    /**
     * Lists all MetaParkTripSlot models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaParkTripSlot::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
