<?php

namespace frontend\controllers;


/**
 * TermsOfUseController.
 */
class TermsOfUseController extends FrontendBaseController
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
