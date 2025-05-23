<?php

namespace backend\modules\sightings\controllers;

use common\models\sighting\form\SightingDeleteForm;
use common\models\sighting\form\SightingThumbnailForm;
use common\models\sighting\Sighting;
use common\models\sighting\SightingComment;
use common\models\sighting\SightingSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * DefaultController for the `sightings` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SightingSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $sighting = Sighting::find()->where(['id' => $id])->limit(1)->one();
        if (!$sighting) {
            \Yii::$app->session->setFlash('danger', 'Sighting not Found!!!');
            return $this->redirect(['index']);
        }
        return $this->render('view', [
            'model' => $sighting,
        ]);
    }

    public function actionCommentListing($id)
    {
        $sighting = Sighting::find()->where(['id' => $id])->limit(1)->one();
        if (!$sighting) {
            \Yii::$app->session->setFlash('danger', 'Sighting not Found!!!');
            return $this->redirect(['index']);
        }

        $query = SightingComment::find()->where(['sighting_id' => $sighting->id, 'status' => 1])->andWhere(['parent_id' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('_comment_list', ['dataProvider' => $dataProvider]);
    }

    public function actionReplyListing($parent_id)
    {
        $query = SightingComment::find()->where(['parent_id' => $parent_id, 'status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->renderAjax('_reply_list', ['dataProvider' => $dataProvider]);
    }


    public function actionSightingDelete($id)
    {
        $sighting_delete_model = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting_delete_model) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }

        $model = new SightingDeleteForm($sighting_delete_model);
        $model->status = Sighting::STATUS_DELETE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->sighting_delete_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->sighting_delete_model->loadDefaultValues();
        }

        return $this->renderAjax('_delete_form', [
            'model' => $model,
        ]);
    }

    public function actionCommentDelete($id)
    {
        $comment = SightingComment::find()->where(['id' => $id, 'status' => 1])->limit(1)->one();

        if (!$comment) {
            Yii::$app->session->setFlash('error', 'Comment not found');
            return $this->redirect(['index']);
        }

        $replies = SightingComment::find()->where(['parent_id' => $id, 'status' => 1])->all();
        $comment->status = SightingComment::STATUS_DELETE;

        if ($comment->save(false)) {
            if ($replies) {
                foreach ($replies as $rep) {
                    $rep->status = SightingComment::STATUS_DELETE;
                    $rep->save(false);
                }
            }
            Yii::$app->session->setFlash('success', 'Comment and Replies related to it has been deleted successfully.');
            return $this->redirect(['view', 'id' => $comment->sighting_id]);
        }

        Yii::$app->session->setFlash('danger', 'Not deleted successfully.');
        return $this->redirect(['index']);
    }

    public function actionReplyDelete($id)
    {
        $reply = SightingComment::find()->where(['id' => $id, 'status' => 1])->limit(1)->one();
        if (!$reply) {
            Yii::$app->session->setFlash('error', 'Reply not found');
            return $this->redirect(['index']);
        }
        $reply->status = SightingComment::STATUS_DELETE;

        if ($reply->save(false)) {
            Yii::$app->session->setFlash('success', 'Reply has been deleted successfully.');
            return $this->redirect(['view', 'id' => $reply->sighting_id]);
        }

        Yii::$app->session->setFlash('danger', 'Not deleted successfully.');
        return $this->redirect(['index']);
    }

    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        $model->status = Sighting::STATUS_SUSPEND;
        $model->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $model->status = Sighting::STATUS_ACTIVE;
        $model->save();
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMarkAsDaily($id)
    {
        $model = $this->findModel($id);
        if ($model->show_in_front == 1) {
            $model->show_in_front = 0;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Sighting Remove from Daily Update !!!');
        } else {
            $model->show_in_front = 1;
            $model->save(false);
            \Yii::$app->getSession()->setFlash('success', 'Sighting Add to Daily Update !!!');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdateThumbnail($id)
    {
        $sighting_thumbnail_model = Sighting::find()->where(['id' => $id, 'status' => Sighting::STATUS_ACTIVE])->limit(1)->one();
        if (!$sighting_thumbnail_model) {
            return Yii::$app->api->sendResponse($data = [], ['message' => "Sighting Not Found!!!"]);
        }

        $model = new SightingThumbnailForm($sighting_thumbnail_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->video_thumbnail = UploadedFile::getInstance($model, 'video_thumbnail');
                if ($model->validate()) {
                    $model->uploadFile();
                    \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->sighting_thumbnail_model->loadDefaultValues();
        }

        return $this->renderAjax('_update_thumbnail_form', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Sighting::findOne(['id' => $id, 'status' => [Sighting::STATUS_ACTIVE, Sighting::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
