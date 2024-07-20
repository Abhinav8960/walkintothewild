<?php

namespace frontend\modules\profile\controllers;

use common\models\User;
use frontend\controllers\FrontendBaseController;


/**
 * PhotoController.
 */
class PhotoController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($user_handle)
    {
        $user = $this->findUserbyHandle($user_handle);
        return $this->render('index', ['user' => $user]);
    }
}
