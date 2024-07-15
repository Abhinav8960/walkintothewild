<?php

namespace frontend\modules\profile\controllers;


use frontend\controllers\FrontendBaseController;


/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFollow()
    {
    }
}
