<?php

namespace backend\modules\master\controllers;

use common\models\master\packagefeature\form\MasterPackagefeatureForm;
use common\models\master\packagefeature\MasterPackagefeature;
use common\models\master\packagefeature\MasterPackagefeatureSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * VehicleController.
 */
class PackagefeatureController extends Controller
{
    /**
     * Lists all MasterCenterSeatType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterPackagefeatureSearch();
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
        $model = new MasterPackagefeatureForm();
        $model->status = MasterPackagefeature::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_feature_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.submitted',['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->package_feature_model->loadDefaultValues();
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
        $package_feature_model = $this->findModel($id);
        $model = new MasterPackagefeatureForm($package_feature_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_feature_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->package_feature_model->loadDefaultValues();
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
        $model->status = MasterPackagefeature::STATUS_DELETE;
        $model->save(false);
        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterCenterSeatType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterPackagefeature the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterPackagefeature::findOne(['id' => $id, 'status' => [MasterPackagefeature::STATUS_ACTIVE, MasterPackagefeature::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
