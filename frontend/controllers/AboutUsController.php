<?php

namespace frontend\controllers;

/**
 * AboutUsController.
 */
class AboutUsController extends FrontendBaseController
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
