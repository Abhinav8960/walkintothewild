<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaZoneType;
use yii\web\Controller;

/**
 * ZoneTypeController.
 */
class ZoneTypeController extends Controller
{
    /**
     * Lists all MetaZoneType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaZoneType::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
