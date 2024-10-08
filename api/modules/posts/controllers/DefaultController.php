<?php

namespace api\modules\posts\controllers;

use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\posts\UserPosts;
use api\models\posts\UserPostSearch;
use frontend\models\profile\UserPostsForm;
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


    public function actionCreate()
    {
        $model = new UserPostsForm();
        $model->user_id = $this->userinfoId;
        $model->status = UserPosts::STATUS_ACTIVE;

        $model->attributes = $this->request;
        $model->file = \yii\web\UploadedFile::getInstance($model, 'file');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->user_photo_model->save()) {
                $model->UploadFiles($model->user_photo_model->id);
                if ($model->user_photo_model->user) {
                    $user = $model->user_photo_model->user;
                    $username = $user->name;
                    $to_mail = Yii::$app->params['adminEmail'];
                    $subject = 'New Shared Safari | ' . substr($model->user_photo_model->share_safari_title, 0, 20) . ' - ' . date('Y-m-d H:i:s');
                    $template = \common\Helper\EmailTemplate::EMAIL_TEMPLATE_NEW_SAFARI_CREATEDBY_USER;
                    $shared_safari_url = Yii::$app->urlManager->createAbsoluteUrl(['/sharedsafari/default/view', 'slug' => $model->user_photo_model->slug, 'organized_slug' => $model->user_photo_model->organizedslug ?: '']);

                    $req = ['shared_safari' => $model->user_photo_model->attributes, 'shared_safari_url' => $shared_safari_url, 'username' => $username];
                    $maillog_data = MailLog::createMailLog($to_mail, $subject, $template, $req, []);

                    if (!empty($maillog_data['log_id'])) {
                        GeneralModel::sendmailfromlog($maillog_data['log_id']);
                    }
                }
                Yii::$app->api->sendResponse($data = [$model->user_photo_model->attributes], ['message' => "Shared safari created successfully"]);
            }
        }

        Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
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
