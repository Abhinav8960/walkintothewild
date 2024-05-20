<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaLocation;
use common\models\meta\MetaWildLifeType;

use yii\web\Controller;

/**
 * WildLifeTypeController.
 */
class LocationController extends Controller
{
    /**
     * Lists all MasterAnimal models.
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
