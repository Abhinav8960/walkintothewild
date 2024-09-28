<?php

namespace frontend\modules\account\controllers;

/**
 * Notification Setting controller for the `account` module
 */
class NotificationSettingController extends \frontend\controllers\FrontendBaseController
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
