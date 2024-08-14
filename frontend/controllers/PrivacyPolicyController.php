<?php

namespace frontend\controllers;

/**
 * DefaultController.
 */
class PrivacyPolicyController extends FrontendBaseController
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
