<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaAnimalType;
use yii\web\Controller;

/**
 * AnimalTypeController.
 */
class AnimalTypeController extends Controller
{
    /**
     * Lists all MetaAnimalType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaAnimalType::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
