<?php

namespace backend\modules\home\controllers;

use common\models\UserPosts;
use common\models\UserPostSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new UserPostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSuspend($id)
    {
        $model = $this->findModel($id);
        if ($model->status == 0) {
            $model->status = UserPosts::STATUS_ACTIVE;
            $model->save(false);
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Published ']);
            \Yii::$app->session->setFlash('success', $message);
        } else {
            $model->status = UserPosts::STATUS_SUSPEND;
            $model->save(false);
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Suspend ']);
            \Yii::$app->session->setFlash('success', $message);
        }

        return $this->redirect(['index']);
    }



    protected function findModel($id)
    {
        if (($model = UserPosts::findOne(['id' => $id, 'status' => [UserPosts::STATUS_ACTIVE, UserPosts::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
