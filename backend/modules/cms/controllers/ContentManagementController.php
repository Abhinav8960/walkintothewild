<?php

namespace backend\modules\cms\controllers;


use common\models\cms\contentmanagement\ContentManagement;
use common\models\cms\contentmanagement\ContentManagementSearch;
use common\models\cms\contentmanagement\form\ContentManagementForm;
// use common\models\faq\form\ContentManagementForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ContentManagementController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ContentManagementSearch();
        $searchModel->status = ContentManagement::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new ContentManagementForm();
        $model->status = ContentManagement::STATUS_ACTIVE;



        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->formModel->save(false)) {
                        //$model->uploadFile();
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Data Submitted ']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->formModel->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $formModel = $this->findModel($id);
        $model = new ContentManagementForm($formModel);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->formModel->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->formModel->loadDefaultValues();
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

    // public function actionDelete($id)
    // {
    //     $model = $this->findModel($id);
    //     $model->name = $model->id . '_' . $model->name;
    //     $model->status = StatusInterface::STATUS_DELETE;
    //     $model->save();
    //     Yii::$app->session->setFlash('success', 'Data Updated Successfully');
    //     return $this->redirect(Yii::$app->request->referrer); // corrected Yii::$app->request
    // }

    protected function findModel($id)
    {
        if (($model = ContentManagement::findOne(['id' => $id, 'status' => [ContentManagement::STATUS_ACTIVE, ContentManagement::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
