<?php

namespace backend\modules\sharesafari\controllers;

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
