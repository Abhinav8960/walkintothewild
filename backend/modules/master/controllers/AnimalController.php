<?php

namespace backend\modules\master\controllers;


use common\models\master\animal\form\MasterAnimalForm;
use common\models\master\animal\MasterAnimal;
use common\models\master\animal\MasterAnimalSearch;
use Yii;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AnimalController.
 */
class AnimalController extends Controller
{
    /**
     * Lists all MasterAnimal models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterAnimalSearch();
        $searchModel->status = 1;
        $searchModel->animal_type = 1;
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
        $model = new MasterAnimalForm();
        $model->status = MasterAnimal::STATUS_ACTIVE;
        $model->scenario = 'create';
        $model->animal_type = MasterAnimal::USUAL_ANIMAL_TYPE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->animal_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.submitted', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->animal_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterAnimal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $animal_model = $this->findModel($id);
        $model = new MasterAnimalForm($animal_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->animal_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->animal_model->loadDefaultValues();
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
     * Deletes an existing MasterAnimal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->name = $model->id . '_' . $model->name;
        $model->status = MasterAnimal::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterAnimal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterAnimal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterAnimal::findOne(['id' => $id, 'status' => [MasterAnimal::STATUS_ACTIVE, MasterAnimal::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
