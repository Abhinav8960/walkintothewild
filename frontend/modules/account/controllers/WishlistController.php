<?php

namespace frontend\modules\account\controllers;

/**
 * Wishlist controller for the `account` module
 */
class WishlistController extends \frontend\controllers\FrontendBaseController
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
