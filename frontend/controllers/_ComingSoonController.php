<?php

namespace frontend\controllers;

/**
 *  Home controller
 */
class ComingSoonController extends FrontendBaseController
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
