<?php

namespace developer\modules\code\controllers;

use yii\web\Controller;
use yii;

/**
 * Default controller for the `transactioninfo` module
 */
class DefaultController extends Controller
{
    
    public function actionIndex()
    {
        return $this->render('index');
    }

}
