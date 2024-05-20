<?php

namespace backend\modules\meta\controllers;


use common\models\meta\MetaWildLifeType;

use yii\web\Controller;

/**
 * WildLifeTypeController.
 */
class WildLifeTypeController extends Controller
{
    /**
     * Lists all MetaWildLifeType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaWildLifeType::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
