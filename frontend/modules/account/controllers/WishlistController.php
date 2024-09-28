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
     * Actions ids for Save Page Views
     */
    public $action_ids = ['index', 'share-safari'];

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'wishlist_items' => UserWishlist::find()->where(['item_type_id' => UserWishlist::SAFARI_PACKAGE, 'status' => 1, 'user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->all(),
            ]
        );
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionShareSafari()
    {
        return $this->render(
            'shared_safari',
            [
                'wishlist_items' => UserWishlist::find()->where(['item_type_id' => UserWishlist::SHARED_SAFARI, 'status' => 1, 'user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null])->all(),
            ]
        );
    }
}
