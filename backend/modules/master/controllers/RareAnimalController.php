<?php

namespace backend\modules\master\controllers;

use common\interfaces\StatusInterface;
use common\models\master\animal\form\MasterAnimalForm;
use common\models\master\animal\form\MasterRareAnimalForm;
use common\models\master\animal\MasterAnimal;
use common\models\master\animal\MasterRare;
use common\models\master\animal\MasterRareAnimal;
use common\models\master\animal\MasterRareAnimalSearch;
use common\models\master\animal\MasterAnimalSearch;
use common\models\park\SafariParkAnimal;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RareAnimalController.
 */
class RareAnimalController extends Controller
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
        $searchModel->animal_type = MasterAnimal::RARE_ANIMAL_TYPE;
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
        $model = new MasterRareAnimalForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->scenario = 'create';
        $model->animal_type = MasterAnimal::RARE_ANIMAL_TYPE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                $model->banner = UploadedFile::getInstance($model, 'banner');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->rare_animal_model->save(false)) {
                        $model->uploadFile();
                        $model->assignedpark();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->rare_animal_model->loadDefaultValues();
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
        $rare_animal_model = $this->findModel($id);
        $model = new MasterRareAnimalForm($rare_animal_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                $model->banner = UploadedFile::getInstance($model, 'banner');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->rare_animal_model->save()) {
                        $model->uploadFile($model->rare_animal_model->id);
                        $model->assignedpark();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->rare_animal_model->loadDefaultValues();
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
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();

        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterRareAnimal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterRareAnimal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterAnimal::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
