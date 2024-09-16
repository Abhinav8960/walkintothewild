<?php

namespace backend\modules\cms\controllers;


use common\models\cms\flagreason\form\FlagreasonSearch;
use common\models\cms\flagreason\Flagreason;
use common\models\cms\flagreason\form\FlagreasonForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * FlagReasonController implements the CRUD actions for FlagReason model.
 */
class FlagReasonController extends Controller
{
    /**
     * Lists all FlagReason models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FlagreasonSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create FlagReason.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FlagreasonForm();
        $model->status = Flagreason::STATUS_ACTIVE;;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->reason_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->reason_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Flagreason model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $reason_model = $this->findModel($id);
        $model = new FlagreasonForm($reason_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->reason_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->reason_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FlagReason model.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->reason = $model->id . '_' . $model->reason;
        $model->status = Flagreason::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(['index']);
    }

    /**
     * Finds the FlagReason model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FlagReason the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Flagreason::findOne(['id' => $id, 'status' => [Flagreason::STATUS_ACTIVE, Flagreason::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
