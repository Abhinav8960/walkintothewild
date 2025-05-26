<?php

namespace api\modules\sighting\controllers;

use api\behaviours\Apiauth;
use api\behaviours\Verbcheck;
use api\controllers\RestController;
use api\models\sighting\Sighting;
use api\models\sighting\SightingComment;
use api\models\sighting\SightingCommentLike;
use api\models\sighting\SightingLike;
use api\models\sighting\SightingSearch;
use common\models\operator\SafariOperator;
use common\models\sighting\form\SightingCommentFlagForm;
use common\models\sighting\form\SightingCommentForm;
use common\models\sighting\form\SightingForm;
use common\models\sighting\form\SightingReplyForm;
use common\models\sighting\form\SightingReportForm;
use getID3;
use Yii;
use yii\data\ActiveDataProvider;
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
                'exclude' => ['index', 'view','daily-update'],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'comment', 'reply', 'comment-like', 'sighting-like', 'sighting-report', 'sighting-delete', 'flag'],
                'rules' => [
                    [
                        'actions' => ['comment', 'reply', 'comment-like', 'sighting-like', 'sighting-report', 'sighting-delete', 'flag'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => $this->isSafariOperator(),
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
                    'sighting-report' => ['POST'],
                    'sighting-delete' => ['POST'],
                    'flag' => ['POST'],
                    'daily-update' => ['GET'],
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
        return $this->dataProviderSender($searchModel, $rootIndexName = "sighting");
    }


    public function actionCreate()
    {
        $model = new SightingForm();
        $model->user_id = $this->userinfoId;
        $model->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
        $model->status = Sighting::STATUS_ACTIVE;

        $model->load(\Yii::$app->request->post());
        $model->setAttributes(\Yii::$app->request->post());
        $model->file = \yii\web\UploadedFile::getInstanceByName('file');
        // $model->video_thumbnail = \yii\web\UploadedFile::getInstanceByName('video_thumbnail');

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
            $like->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
            $like->sighting_comment_id = $sighting_comment_id;
            $like->status = SightingCommentLike::STATUS_ACTIVE;
            if ($like->save(false)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => true], ['message' => "Liked Comment or Reply"]);
            }
        } else {
            $like->delete();
            return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => false], ['message' => "Remove Liked Successfully"]);
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
            $like->safari_operator_id = $this->userinfo->partner ? $this->userinfo->partner->id : null;
            $like->sighting_id = $id;
            $like->status = SightingLike::STATUS_ACTIVE;
            if ($like->save(false)) {
                return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => true], ['message' => "Sighting Liked Successfully"]);
            }
        } else {
            $like->delete();
            return  Yii::$app->api->sendResponse($data = ['status' => 1, 'isLike' => false], ['message' => "Remove Liked Successfully"]);
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
                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Sighting Report Submitted"]);
            }
            return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not Submitted"]);
        }

        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }

    public function actionSightingDelete($id)
    {
        $sighting = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }
        if ($this->userinfo) {
            if ($this->userinfoId != $sighting->user_id) {
                return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "You Cannot delete this sighting!!!"]);
            }
        }

        $sighting->status = Sighting::STATUS_DELETE;
        if ($sighting->save(false)) {
            return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Delete Successfully!!!"]);
        }

        return Yii::$app->api->sendResponse($data = ['status' => 0], ['message' => "Not Delete Successfully!!!"]);
    }

    public function actionFlag($id, $sighting_comment_id)
    {
        $sighting_model = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting_model) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }

        $flag_comment = SightingComment::find()->where(['id' => $sighting_comment_id])->limit(1)->one();

        if (!$flag_comment) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Comment Not Found!!!"]);
        }

        if ($flag_comment->user_id == $this->userinfoId) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "You cannot flag your comment/reply yourself!!!"]);
        }

        $model = new SightingCommentFlagForm();
        $model->sighting_id = $sighting_model->id;
        $model->sighting_comment_id = $flag_comment->id;

        $model->attributes = $this->request;

        if ($model->validate()) {
            $model->initializeForm();
            if ($model->sighting_flag_model->save(false)) {
                $flag_comment->flaged = 1;
                $flag_comment->save(false);

                return Yii::$app->api->sendResponse($data = ['status' => 1], ['message' => "Flaged successfully!"]);
            }
        }
        return Yii::$app->api->sendFailedStringResponse($model->firstErrors, 400);
    }


    private function isSafariOperator()
    {
        if ($this->userinfo) {
            $operator = SafariOperator::find()->where(['user_id' => $this->userinfoId, 'status' => SafariOperator::STATUS_ACTIVE])->limit(1)->one();
            if ($operator) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function actionDailyUpdate()
    {
        // $query = Sighting::find()->where(['show_in_front' => 1, 'status' => Sighting::STATUS_ACTIVE])->limit(9);
        $query = Sighting::find()->where(['status' => Sighting::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC])->limit(10);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => false, 
        ]);
        return $this->querySender($dataProvider, $rootIndexName = "sighting");
    }
}
