<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaTermConditionType;
use yii\web\Controller;

/**
 * TermConditionTypeController.
 */
class TermConditionTypeController extends Controller
{
    /**
     * Lists all MetaTermConditionType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaTermConditionType::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
