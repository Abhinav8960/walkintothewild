<?php

namespace backend\modules\master\controllers;

use common\interfaces\StatusInterface;
use common\models\master\email\form\MasterMailTemplateForm;
use common\models\master\email\MasterMailTemplate;
use common\models\master\email\MasterMailTemplateSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MailTemplateController.
 */
class MailTemplateController extends Controller
{
    /**
     * Lists all MasterMailTemplate models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterMailTemplateSearch();
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
        $model = new MasterMailTemplateForm();
        $model->status = MasterMailTemplate::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->mail_template_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.submitted', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->mail_template_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterMailTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $mail_template_model = $this->findModel($id);
        $model = new MasterMailTemplateForm($mail_template_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->mail_template_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->mail_template_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }





    /**
     * Deletes an existing MasterMailTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->name = $model->id . '_' . $model->name;
        $model->status = MasterMailTemplate::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterMailTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterMailTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterMailTemplate::findOne(['id' => $id, 'status' => [MasterMailTemplate::STATUS_ACTIVE, MasterMailTemplate::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
