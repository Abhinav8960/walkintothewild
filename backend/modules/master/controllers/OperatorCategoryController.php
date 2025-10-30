<?php

namespace backend\modules\master\controllers;


use common\models\master\operatorcategory\form\MasterOperatorCategoryForm;
use common\models\master\operatorcategory\MasterOperatorCategory;
use common\models\master\operatorcategory\MasterOperatorCategorySearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OperatorCategoryController.
 */
class OperatorCategoryController extends Controller
{
    /**
     * Lists all MasterOperatorCategory models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterOperatorCategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Create MasterOperatorCategory.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterOperatorCategoryForm();
        $model->status = MasterOperatorCategory::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->operator_category_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.submitted',['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->operator_category_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterOperatorCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $operator_category_model = $this->findModel($id);
        $model = new MasterOperatorCategoryForm($operator_category_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->operator_category_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->operator_category_model->loadDefaultValues();
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


    /**
     * Deletes an existing MasterOperatorCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // $model->vehicle_name = $model->id . '_' . $model->vehicle_name;
        $model->status = MasterOperatorCategory::STATUS_DELETE;
        $model->save(false);
        $message = Yii::$app->messageManager->getMessage('common.updated',['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterOperatorCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterOperatorCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterOperatorCategory::findOne(['id' => $id, 'status' => [MasterOperatorCategory::STATUS_ACTIVE, MasterOperatorCategory::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
