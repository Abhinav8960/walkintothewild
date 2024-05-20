<?php

namespace backend\modules\sharesafari\controllers;

use yii\base\Controller;

/**
 * DefaultController.
 */
class DefaultController extends Controller
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
