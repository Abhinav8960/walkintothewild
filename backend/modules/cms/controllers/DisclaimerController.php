<?php

namespace backend\modules\cms\controllers;

use common\interfaces\StatusInterface;
use common\models\cms\disclaimer\Disclaimer;
use common\models\cms\disclaimer\DisclaimerSearch;
use common\models\cms\disclaimer\form\DisclaimerForm;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DisclaimerController.
 */
class DisclaimerController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new DisclaimerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionCreate()
    {
        $model = new DisclaimerForm();
        $model->status = StatusInterface::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->disclaimer_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->disclaimer_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $disclaimer_model = $this->findModel($id);
        $model = new DisclaimerForm($disclaimer_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->disclaimer_model->save()) {
                        // $model->disclaimer_model->save();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->disclaimer_model->loadDefaultValues();
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
        $model->title = $model->id . '_' . $model->title;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Disclaimer::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
