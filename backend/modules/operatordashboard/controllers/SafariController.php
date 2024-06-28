<?php

namespace backend\modules\operatordashboard\controllers;

use yii\web\Controller;

/**
 * Safari controller for the `operatordashboard` module
 */
class SafariController extends Controller
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
