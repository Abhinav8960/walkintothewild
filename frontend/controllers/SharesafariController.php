<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * DefaultController.
 */
class SharesafariController extends Controller
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
