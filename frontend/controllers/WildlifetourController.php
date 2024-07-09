<?php

namespace frontend\controllers;


/**
 * DefaultController.
 */
class WildlifetourController extends FrontendBaseController
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
