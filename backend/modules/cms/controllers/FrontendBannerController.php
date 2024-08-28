<?php

namespace backend\modules\cms\controllers;

use yii\web\Controller;
use yii\web\UploadedFile;
use common\interfaces\StatusInterface;
use common\models\cms\frontendbanner\form\FrontendBannerForm;
use common\models\cms\frontendbanner\FrontendBanner;
use common\models\cms\frontendbanner\FrontendBannerSearch;
use Yii;
use yii\web\NotFoundHttpException;

class FrontendBannerController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new FrontendBannerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new FrontendBannerForm();
        $model->scenario = 'create';
        $model->status = StatusInterface::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->frontend_banner_model->save(false)) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->frontend_banner_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $frontend_banner_model = $this->findModel($id);
        $model = new FrontendBannerForm($frontend_banner_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->frontend_banner_model->save()) {
                        $model->uploadFile();
                        $model->frontend_banner_model->save();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->frontend_banner_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSetsequence()
    {

        $types = FrontendBanner::find()->select('type')->distinct()->all();
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('setsequence', [
                'types' => $types,
            ]);
        } else {
            return $this->render('setsequence', [
                'types' => $types,
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
            FrontendBanner::updateAll([
                'sequence' => $count
            ], ['id' => $id]);
            $count++;
        }
        return true;
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
        if (($model = FrontendBanner::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
