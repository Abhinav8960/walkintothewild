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
        $package = UserWishlist::find()->where(['item_type_id' => 1, 'status' => 1, 'user_id' => Yii::$app->user->identity->id])->all();
        return $this->render(
            'index',
            [
                'packages' => $package,
            ]
        );
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionShareSafari()
    {
        $share_safaries = UserWishlist::find()->where(['item_type_id' => 2, 'status' => 1, 'user_id' => Yii::$app->user->identity->id])->all();
        return $this->render(
            'shared_safari',
            [
                'share_safaries' => $share_safaries,
            ]
        );
    }
}
