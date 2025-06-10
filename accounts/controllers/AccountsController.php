<?php

namespace accounts\controllers;


use yii\web\Controller;
/**
 * Site controller
 */
class AccountsController extends Controller
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
