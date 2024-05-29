<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaSafariSession;
use yii\web\Controller;

/**
 * SagariSessionController.
 */
class SafariSessionController extends Controller
{
    /**
     * Lists all MetaSagariSession models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaSafariSession::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
