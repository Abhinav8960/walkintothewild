<?php

namespace backend\modules\article\controllers;

use common\interfaces\StatusInterface;
use common\models\article\frequency\form\FrequencyForm;
use common\models\article\frequency\FrequencySearch;
use common\models\article\frequency\Frequency;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ArticleFrequency Controller for the `blog` module
 */
class FrequencyController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FrequencySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Article Frequency
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FrequencyForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        // $model->action_url = '/frequency/create';
        // $model->action_validate_url = '/frequency/validate';
        $model->status = Frequency::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->frequency_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/article/frequency/index']);
                    }
                }
            }
        } else {
            $model->frequency_model->loadDefaultValues();
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Frequency model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $frequency_model = $this->findModel($id);
        $model = new FrequencyForm($frequency_model);
        // $model->action_url = '/frequency/update?id=' . $id;
        // $model->action_validate_url = '/frequency/validate?id=' . $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->frequency_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/article/frequency/index']);
                    }
                }
            }
        } else {
            $model->frequency_model->loadDefaultValues();
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }


    /**
     * Validate Form
     */
    public function actionValidate($id = null)
    {
        $model = new FrequencyForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new FrequencyForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing Frequency model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->frequency = $model->id . '_' . $model->frequency;
        $model->status = Frequency::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Frequency model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Frequency the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Frequency::findOne(['id' => $id, 'status' => [Frequency::STATUS_ACTIVE, Frequency::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
