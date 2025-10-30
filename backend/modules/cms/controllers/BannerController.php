<?php

namespace backend\modules\cms\controllers;


use common\models\cms\banner\Banner;
use common\models\cms\banner\BannerSearch;
use common\models\cms\banner\form\BannerForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BannerController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new BannerForm();
        $model->status = Banner::STATUS_ACTIVE;
        $model->scenario = 'create';


        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->validate()) {
                    $banner_model = $this->findModelbyPageId($model->page_id);
                    if ($banner_model) {
                        $model->banner_model = $banner_model;
                    }

                    $model->initializeForm();
                    if ($model->banner_model->save(false)) {
                        $model->uploadFile();
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Data Submitted ']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->banner_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $banner_model = $this->findModel($id);
        $model = new BannerForm($banner_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->banner_model->save()) {
                        $model->uploadFile();
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->banner_model->loadDefaultValues();
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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Banner::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.deleted', ['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(Yii::$app->request->referrer); // corrected Yii::$app->request
    }

    protected function findModel($id)
    {
        if (($model = Banner::findOne(['id' => $id])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }


    protected function findModelbyPageId($id)
    {
        if (($model = Banner::findOne(['page_id' => $id])) !== null) {
            return $model;
        }

        // throw new NotFoundHttpException('The requested page does not exist.');
    }
}
