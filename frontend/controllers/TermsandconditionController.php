<?php

namespace frontend\controllers;


/**
 * DefaultController.
 */
class TermsandconditionController extends FrontendBaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render(
            'index'
        );
    }
}
