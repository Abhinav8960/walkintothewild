<?php

namespace frontend\controllers;

/**
 *  Home controller
 */
class ThankyouController extends FrontendBaseController
{
    /**
     * Displays Safari tour form Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
