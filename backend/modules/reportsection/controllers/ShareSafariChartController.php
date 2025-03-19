<?php

namespace backend\modules\reportsection\controllers;

use yii\web\Controller;

/**
 * ShareSafariChartController.
 */
class ShareSafariChartController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
