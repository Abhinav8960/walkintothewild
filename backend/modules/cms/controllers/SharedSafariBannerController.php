<?php

namespace backend\modules\cms\controllers;

use yii\web\Controller;
use yii\web\UploadedFile;
use common\interfaces\StatusInterface;
use common\models\cms\sharedsafaribanner\form\SharedSafariBannerForm;
use common\models\cms\sharedsafaribanner\SharedSafariBanner;
use common\models\cms\sharedsafaribanner\SharedSafariBannerSearch;
use yii\web\NotFoundHttpException;

class SharedSafariBannerController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new SharedSafariBannerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new SharedSafariBannerForm();
        $model->scenario = 'create';
        $model->status = StatusInterface::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_banner_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->shared_safari_banner_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $package_banner_model = $this->findModel($id);
        $model = new SharedSafariBannerForm($package_banner_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->shared_safari_banner_model->save()) {
                        $model->uploadFile();
                        $model->shared_safari_banner_model->save();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->shared_safari_banner_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->id = $model->id;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = SharedSafariBanner::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
