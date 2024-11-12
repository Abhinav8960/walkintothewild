<?php

namespace api\modules\package\controllers;

use api\behaviours\Apiauth;
use Yii;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\package\Package;
use api\models\package\PackageSearch;
use api\models\UserWishlist;
use frontend\models\PackageCommentForm;
use frontend\models\PackageReplyForm;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class DefaultController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['index', 'view'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['comment', 'reply', 'wishlist', 'unwishlist'],
                'rules' => [
                    [
                        'actions' => ['comment', 'reply', 'wishlist', 'unwishlist'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'comment' => ['POST'],
                    'reply' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $searchModel->status = Package::STATUS_ACTIVE;
        $searchModel->custom_sort_by = 5;
        $condition = "owned_by_id IN (SELECT id from safari_operator WHERE status=1)";

        return $this->dataProviderSenderWithCondition($searchModel, $rootIndexName = "Packages", $condition);
    }


    public function actionView($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        $searchModel = new PackageSearch();
        $searchModel->id = $package->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = 0, $additionalSearchQueryParams = [], $singleRecord = true);
    }

  



    public function actionComment($slug)
    {

        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        $model = new PackageCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($package)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment Successfully!"]);
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }


    public function actionReply($slug, $parent_id)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }

        $replymodel = new PackageReplyForm();
        $replymodel->parent_id = $parent_id;
        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($package)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply submitted Successfully!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    public function actionWishlist($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        if ($package) {
            $wishlist = UserWishlist::find()->where(['user_id' => $this->userinfoId, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
            if (!$wishlist) {
                $wishlist = new UserWishlist();
            }
            $wishlist->user_id = $this->userinfoId;
            $wishlist->item_id = $package->id;
            $wishlist->item_type_id = UserWishlist::SAFARI_PACKAGE;
            $wishlist->item_type = 'package';
            $wishlist->status = 1;
            if ($wishlist->save(false)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You added Package to wishlist!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }

    public function actionUnwishlist($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (!$package) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Package Not Found!!!"]);
        }
        if ($package) {
            $wishlist = UserWishlist::find()->where(['user_id' => $this->userinfoId, 'item_id' => $package->id, 'item_type_id' => UserWishlist::SAFARI_PACKAGE])->one();
            if ($wishlist) {
                $wishlist->status = 0;
                if ($wishlist->save(false)) {
                    return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "You removed Package to wishlist!"]);
                }
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not removed Package from wishlist!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($package->firstErrors, 400);
    }
}
