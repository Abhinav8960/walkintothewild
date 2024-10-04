<?php

namespace api\modules\posts\controllers;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\posts\UserPosts;
use api\models\posts\UserPostSearch;
use Yii;

class DefaultController extends RestController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
            'verbs' => [
                'class' => Verbcheck::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'user-posts' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * 
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserPostSearch();
        $searchModel->status = UserPostSearch::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "UserPosts");
    }

    /**
     * 
     * @return string
     */
    public function actionView($id)
    {
        $userpost = UserPosts::find()->where(['id' => $id, 'status' => UserPosts::STATUS_ACTIVE])->limit(1)->one();
        if (!$userpost) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Post Not Found!!!"]);
        }
        $searchModel = new UserPostSearch();
        $searchModel->id = $userpost->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "UserPosts", $additionalSearchQueryParams = [], $singleRecord = true);
    }

    /**
     * 
     * @return string
     */
    public function actionUserPosts($user_id)
    {
        $searchModel = new UserPostSearch();
        $searchModel->user_id = $user_id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "UserPosts");
    }
}
