<?php

namespace backend\modules\master\controllers;


use common\models\master\sharesafarireason\form\MasterShareSafariReasonForm;
use common\models\master\sharesafarireason\MasterShareSafariReason;
use common\models\master\sharesafarireason\MasterShareSafariReasonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * VehicleController.
 */
class ShareSafariReasonController extends Controller
{
    /**
     * Lists all MasterShareSafariReason models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterShareSafariReasonSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Create SeatType.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterShareSafariReasonForm();
        $model->status = MasterShareSafariReason::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_reason_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->share_safari_reason_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterShareSafariReason model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $share_safari_reason_model = $this->findModel($id);
        $model = new MasterShareSafariReasonForm($share_safari_reason_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->share_safari_reason_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->share_safari_reason_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing MasterCenterSeatType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->title = $model->id . '_' . $model->title;
        $model->status = MasterShareSafariReason::STATUS_DELETE;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterCenterSeatType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterShareSafariReason the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterShareSafariReason::findOne(['id' => $id, 'status' => [MasterShareSafariReason::STATUS_ACTIVE, MasterShareSafariReason::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
