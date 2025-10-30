<?php

namespace backend\modules\master\controllers;

use common\models\master\notification\form\MasterNotificationTemplateForm;
use common\models\master\notification\MasterNotificationTemplate;
use common\models\master\notification\MasterNotificationTemplateSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * NotificationTemplateController.
 */
class NotificationTemplateController extends Controller
{
    /**
     * Lists all MasterShareSafariReason models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterNotificationTemplateSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Create
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterNotificationTemplateForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->notification_template_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.created');
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->notification_template_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterNotificationTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $notification_template_model = $this->findModel($id);
        $model = new MasterNotificationTemplateForm($notification_template_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->notification_template_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated');
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->notification_template_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing MasterNotificationTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = MasterNotificationTemplate::STATUS_DELETE;
        $model->save(false);
        $message = Yii::$app->messageManager->getMessage('common.deleted');
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterNotificationTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterNotificationTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterNotificationTemplate::findOne(['id' => $id, 'status' => [MasterNotificationTemplate::STATUS_ACTIVE, MasterNotificationTemplate::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
