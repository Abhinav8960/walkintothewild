<?php

namespace frontend\modules\profile\controllers;


use frontend\controllers\FrontendBaseController;


/**
 * ShareSafariController.
 */
class ShareSafariController extends FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['user' => $this->module->user()]);
    }
}
