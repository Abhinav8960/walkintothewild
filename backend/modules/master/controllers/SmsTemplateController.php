<?php

namespace backend\modules\master\controllers;

use common\models\master\smstemplate\form\MasterSmsTemplateForm;
use common\models\master\smstemplate\MasterSmsTemplate;
use common\models\master\smstemplate\MasterSmsTemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SmsTemplateController.
 */
class SmsTemplateController extends Controller
{
    /**
     * Lists all MasterShareSafariReason models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterSmsTemplateSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Create
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterSmsTemplateForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->sms_template_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Created');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->sms_template_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterSmsTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $sms_template_model = $this->findModel($id);
        $model = new MasterSmsTemplateForm($sms_template_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->sms_template_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Successfully Updated');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->sms_template_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing MasterSmsTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = MasterSmsTemplate::STATUS_DELETE;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterSmsTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterSmsTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterSmsTemplate::findOne(['id' => $id, 'status' => [MasterSmsTemplate::STATUS_ACTIVE, MasterSmsTemplate::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
