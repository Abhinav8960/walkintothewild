<?php

namespace backend\modules\master\controllers;

use common\models\master\userflag\form\MasterUserFlagForm;
use common\models\master\userflag\MasterUserFlag;
use common\models\master\userflag\MasterUserFlagSearch;
use Yii;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserFlagController
 */
class UserFlagController extends Controller
{
    /**
     * Lists all MasterUserFlag models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterUserFlagSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Create UserFlag.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterUserFlagForm();
        $model->status = MasterUserFlag::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_flag_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.submitted',['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_flag_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterUserFlag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $user_flag_model = $this->findModel($id);
        $model = new MasterUserFlagForm($user_flag_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->user_flag_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->user_flag_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing MasterUserFlag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = MasterUserFlag::STATUS_DELETE;
        $model->save(false);
        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterUserFlag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterUserFlag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterUserFlag::findOne(['id' => $id, 'status' => [MasterUserFlag::STATUS_ACTIVE, MasterUserFlag::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
