<?php

namespace backend\modules\cms\controllers;

use common\interfaces\StatusInterface;
use common\models\cms\privacypolicy\form\PrivacypolicyForm;
use common\models\cms\privacypolicy\Privacypolicy;
use common\models\cms\privacypolicy\PrivacypolicySearch;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PrivacypolicyController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new PrivacypolicySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new PrivacypolicyForm();
        $model->status = StatusInterface::STATUS_ACTIVE;



        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->privacypolicy_model->save(false)) {
                        //$model->uploadFile();
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Data Submitted ']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->privacypolicy_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $privacypolicy_model = $this->findModel($id);
        $model = new PrivacypolicyForm($privacypolicy_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->privacypolicy_model->save()) {
                        $model->privacypolicy_model->save();
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->privacypolicy_model->loadDefaultValues();
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
        $model->name = $model->id . '_' . $model->name;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.deleted', ['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(Yii::$app->request->referrer); // corrected Yii::$app->request
    }

    protected function findModel($id)
    {
        if (($model = Privacypolicy::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
