<?php

namespace backend\modules\master\controllers;

use common\interfaces\StatusInterface;
use common\models\master\vehicle\form\MasterVehicleForm;
use common\models\master\vehicle\MasterVehicle;
use common\models\master\vehicle\MasterVehicleSearch;
use Yii;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * VehicleController.
 */
class VehicleController extends Controller
{
    /**
     * Lists all MasterCenterSeatType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterVehicleSearch();
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
        $model = new MasterVehicleForm();
        $model->status = MasterVehicle::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->icon = UploadedFile::getInstance($model, 'icon');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->vehicle_model->save(false)) {
                        $model->uploadFile();
                        $message = Yii::$app->messageManager->getMessage('common.submitted',['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->vehicle_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterCenterSeatType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $vehicle_model = $this->findModel($id);
        $model = new MasterVehicleForm($vehicle_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->icon = UploadedFile::getInstance($model, 'icon');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->vehicle_model->save()) {
                        $model->uploadFile($model->vehicle_model->id);
                        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->vehicle_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



    public function actionView($id)
    {
        $model = $this->findModel($id);


        return $this->render('view', [
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
        $model->vehicle_name = $model->id . '_' . $model->vehicle_name;
        $model->status = MasterVehicle::STATUS_DELETE;
        $model->save(false);
        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterCenterSeatType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterCenterSeatType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterVehicle::findOne(['id' => $id, 'status' => [MasterVehicle::STATUS_ACTIVE, MasterVehicle::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
