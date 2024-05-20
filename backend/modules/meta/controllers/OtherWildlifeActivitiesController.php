<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaOtherWildlifeActivities;

use yii\web\Controller;

/**
 * OtherWildlifeActivitiesController.
 */
class OtherWildlifeActivitiesController extends Controller
{
    /**
     * Lists all MetaOtherWildlifeActivities models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaOtherWildlifeActivities::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
