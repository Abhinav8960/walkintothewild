<?php

namespace backend\modules\master\controllers;

use yii\web\Controller;

/**
 * DefaultController.
 */
class DefaultController extends Controller
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
