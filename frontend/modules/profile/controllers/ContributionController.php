<?php

namespace frontend\modules\profile\controllers;

use common\models\User;
use frontend\controllers\FrontendBaseController;


/**
 * ContributionController.
 */
class ContributionController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = User::find()->where(['user_handle' => $user_handle])->limit(1)->one();
        return $this->render('index', ['user' => $user]);
    }
}
