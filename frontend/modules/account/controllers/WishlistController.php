<?php

namespace frontend\modules\account\controllers;

use common\models\UserWishlist;
use Yii;

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
        $wishlist_items = UserWishlist::find()->where(['item_type_id' => UserWishlist::SAFARI_PACKAGE, 'status' => 1, 'user_id' => Yii::$app->user->identity->id])->all();
        return $this->render(
            'index',
            [
                'wishlist_items' => $wishlist_items,
            ]
        );
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionShareSafari()
    {
        $wishlist_items = UserWishlist::find()->where(['item_type_id' => UserWishlist::SHARED_SAFARI, 'status' => 1, 'user_id' => Yii::$app->user->identity->id])->all();
        return $this->render(
            'shared_safari',
            [
                'wishlist_items' => $wishlist_items,
            ]
        );
    }
}
