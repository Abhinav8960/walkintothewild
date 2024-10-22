<?php

namespace api\modules\posts\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\posts\UserPosts;
use api\models\posts\UserPostSearch;
use frontend\models\profile\UserPostsForm;
use Yii;
use yii\filters\AccessControl;

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
                'exclude' => ['index'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
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
                    'user-posts' => ['GET'],
                    'create' => ['POST'],
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


    public function actionCreate()
    {
        $model = new UserPostsForm();
        $model->user_id = $this->userinfoId;
        $model->status = UserPosts::STATUS_ACTIVE;

        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());
        $model->file = \yii\web\UploadedFile::getInstanceByName('file');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_photo_model->save()) {
                $model->uploadFile();
               return Yii::$app->api->sendResponse($data = [$model->user_photo_model->attributes], ['message' => "Post added successfully"]);
            }
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
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
