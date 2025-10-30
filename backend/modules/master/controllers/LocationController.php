<?php

namespace backend\modules\master\controllers;


use common\models\master\location\form\MasterLocationForm;
use common\models\master\location\MasterLocation;
use common\models\master\location\MasterLocationSearch;
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LocationController.
 */
class LocationController extends Controller
{
    /**
     * Lists all MasterLocation models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterLocationSearch();
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
        $model = new MasterLocationForm();
        $model->status = MasterLocation::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->location_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.submitted', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->location_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MasterLocation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $location_model = $this->findModel($id);
        $model = new MasterLocationForm($location_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->location_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->location_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);


        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * Set Sequence of Privacy Policy
     *
     * @return void
     */
    public function actionSetsequence()
    {
        $searchModel = new MasterLocationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, false);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('setsequence', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('setsequence', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        }
    }
    /**
     * Save Sequence
     *
     * @return void
     */
    public function actionSavesequence()
    {
        $id_array = explode(",", Yii::$app->request->post('ids'));
        $count = 1;
        foreach ($id_array as $id) {
            MasterLocation::updateAll([
                'sequence' => $count
            ], ['id' => $id]);
            $count++;
        }
        return true;
    }



    /**
     * Deletes an existing MasterLocation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->title = $model->id . '_' . $model->title;
        $model->status = MasterLocation::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterLocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterLocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterLocation::findOne(['id' => $id, 'status' => [MasterLocation::STATUS_ACTIVE, MasterLocation::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
