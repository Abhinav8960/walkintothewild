<?php

namespace frontend\modules\account\controllers;

/**
 * Privacy controller for the `account` module
 */
class PrivacyController extends \frontend\controllers\FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
