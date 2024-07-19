<?php

namespace frontend\modules\profile\controllers;

use common\models\User;
use frontend\controllers\FrontendBaseController;


/**
 * SearchController.
 */
class SearchController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user_list = User::find()->where(['status' => 10])->all();
        return $this->render('index', ['user_list' => $user_list]);
    }
}
