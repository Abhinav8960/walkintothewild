<?php

namespace frontend\modules\account\controllers;


/**
 * Blocked Members controller for the `account` module
 */
class BlockedMemberController extends \frontend\controllers\FrontendBaseController
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
