<?php

namespace backend\modules\cms\controllers;

use common\interfaces\StatusInterface;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new ContentManagementForm();
        $model->status = StatusInterface::STATUS_ACTIVE;



        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->formModel->save(false)) {
                        //$model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
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
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
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
        if (($model = ContentManagement::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
