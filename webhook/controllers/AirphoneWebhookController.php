<?php

namespace webhook\controllers;


use yii\web\Controller;
/**
 * Site controller
 */
class AirphoneWebhookController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {        
       return $this->render('index');
    }

}
