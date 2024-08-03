<?php

namespace frontend\controllers;


/**
 * DefaultController.
 */
class FaqController extends FrontendBaseController
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
