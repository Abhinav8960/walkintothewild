<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 *  Home controller
 */
class BirdingtourRegistrationController extends Controller
{
    /**
     * Displays profile Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
