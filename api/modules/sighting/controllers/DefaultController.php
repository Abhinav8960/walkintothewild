<?php

namespace api\modules\sighting\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\sighting\Sighting;
use api\models\sighting\SightingCommentLike;
use api\models\sighting\SightingLike;
use api\models\sighting\SightingSearch;
use common\models\sighting\form\SightingCommentForm;
use common\models\sighting\form\SightingForm;
use common\models\sighting\form\SightingReplyForm;
use common\models\sighting\form\SightingReportForm;
use getID3;
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

        return $behaviors += [
            'apiauth' => [
                'class' => Apiauth::className(),
                'exclude' => ['index', 'view'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'comment', 'reply', 'comment-like', 'sighting-like','sighting-report'],
                'rules' => [
                    [
                        'actions' => ['create', 'comment', 'reply', 'comment-like', 'sighting-like','sighting-report'],
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
                    'create' => ['POST'],
                    'comment' => ['POST'],
                    'reply' => ['POST'],
                    'sighting-like' => ['POST'],
                    'comment-like' => ['POST'],
                    'sighting-report' => ['POST']
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
        $searchModel = new SightingSearch();
        $searchModel->status = Sighting::STATUS_ACTIVE;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Sighting");
    }


    public function actionCreate()
    {
        $model = new SightingForm();
        $model->user_id = $this->userinfoId;
        $model->status = Sighting::STATUS_ACTIVE;

        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());
        $model->file = \yii\web\UploadedFile::getInstanceByName('file');
        $model->video_thumbnail = \yii\web\UploadedFile::getInstanceByName('video_thumbnail');

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->sighting_model->save()) {
                $model->uploadFile();
                $model->sighting_model->v_size = $model->file->size;
                $model->sighting_model->v_duration = $this->getVideoDuration($model->file);
                if ($model->sighting_model->save()) {
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sighting added successfully"]);
                }
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not added successfully"]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }
    /**
     * 
     * @return string
     */
    public function actionView($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }
        $searchModel = new SightingSearch();
        $searchModel->id = $sighting->id;
        return $this->dataProviderSender($searchModel, $rootIndexName = "Sighting", $additionalSearchQueryParams = [], $singleRecord = true);
    }


    public function actionComment($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }

        $model = new SightingCommentForm();
        $model->attributes = $this->request;
        if ($model->validate() && $model->comment($sighting)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Comment Successfully!"]);
        }

        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Comment Not Submitted!"]);
    }


    public function actionReply($id, $parent_id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }

        $replymodel = new SightingReplyForm();
        $replymodel->parent_id = $parent_id;

        $replymodel->attributes = $this->request;

        if ($replymodel->validate()) {
            if ($replymodel->reply($sighting)) {
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply submitted Successfully!"]);
            }
        }

        return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Reply Not Submitted!"]);
    }


    public function actionCommentLike($sighting_comment_id)
    {

        $like = SightingCommentLike::find()->where(['user_id' => $this->userinfoId, 'sighting_comment_id' => $sighting_comment_id, 'status' => SightingCommentLike::STATUS_ACTIVE])->one();
        if (!$like) {
            $like = new SightingCommentLike();
            $like->user_id = $this->userinfoId;
            $like->sighting_comment_id = $sighting_comment_id;
            $like->status = SightingCommentLike::STATUS_ACTIVE;
            if ($like->save(false)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Liked Comment or Reply"]);
            }
        } else {
            $like->delete();
            return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Remove Liked Successfully"]);
        }
    }


    public function actionSightingLike($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }

        $like = SightingLike::find()->where(['user_id' => $this->userinfoId, 'sighting_id' => $id, 'status' => SightingLike::STATUS_ACTIVE])->one();
        if (!$like) {
            $like = new SightingLike();
            $like->user_id = $this->userinfoId;
            $like->sighting_id = $id;
            $like->status = SightingLike::STATUS_ACTIVE;
            if ($like->save(false)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sighting Liked Successfully"]);
            }
        } else {
            $like->delete();
            return  Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Remove Liked Successfully"]);
        }
    }

    private function getVideoDuration($tempFile)
    {
        $tempFilePath = $tempFile->tempName;
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($tempFilePath);
        if (isset($fileInfo['playtime_seconds'])) {
            return (int) $fileInfo['playtime_seconds'];
        }
        return 0;
    }

    public function actionSightingReport($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }

        $model = new SightingReportForm();
        $model->user_id = $this->userinfoId;
        $model->status = Sighting::STATUS_ACTIVE;
        $model->sighting_id = $sighting->id;
        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());
        if ($model->validate()) {
            $model->initializeForm();
           
                if ($model->sighting_model->save()) {
                    return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "SightingReport Submitted"]);
                }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not Submitted"]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }
}
