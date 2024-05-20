<?php

namespace backend\modules\meta\controllers;

use common\models\meta\MetaPackageRange;
use yii\web\Controller;

/**
 * PackageController.
 */
class PackageController extends Controller
{
    /**
     * Lists all MetaPackageRange models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model =  MetaPackageRange::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'models' => $model,
        ]);
    }
}
