<?php

namespace frontend\modules\manage\controllers;

use frontend\controllers\FrontendBaseController;

/**
 * Default controller for the `manage` module
 */
class UserController extends FrontendBaseController
{
    public $action_ids = ['index'];

    /**
     * Park List of Operator
     */
    public function actionIndex()
    {
        $safari_operator = $this->module->operatormodel();

        return $this->render('index', ['safari_operator' => $safari_operator]);

    }
}
