<?php

namespace cms\controllers;


use yii\web\Controller;
/**
 * Site controller
 */
class CmsController extends Controller
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
