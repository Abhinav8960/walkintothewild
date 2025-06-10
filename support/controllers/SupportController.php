<?php

namespace support\controllers;


use yii\web\Controller;
/**
 * Site controller
 */
class SupportController extends Controller
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
