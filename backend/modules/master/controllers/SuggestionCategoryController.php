<?php

namespace backend\modules\master\controllers;


use common\models\master\suggetioncategory\form\MasterSuggestionCategoryForm;
use common\models\master\suggetioncategory\MasterSuggestionCategory;
use common\models\master\suggetioncategory\MasterSuggestionCategorySearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SuggestionCategoryController.
 */
class SuggestionCategoryController extends Controller
{
    /**
     * Lists all MasterSuggestionCategory models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterSuggestionCategorySearch();
        $searchModel->status = 1;
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
        $model = new MasterSuggestionCategoryForm();
        $model->status = MasterSuggestionCategory::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->suggestion_category_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->suggestion_category_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterSuggestionCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $suggestion_category_model = $this->findModel($id);
        $model = new MasterSuggestionCategoryForm($suggestion_category_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->suggestion_category_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->suggestion_category_model->loadDefaultValues();
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
     * Set Sequence of Privacy Policy
     *
     * @return void
     */
    public function actionSetsequence()
    {
        $searchModel = new MasterSuggestionCategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams, false);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('setsequence', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('setsequence', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
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
            MasterSuggestionCategory::updateAll([
                'sequence' => $count
            ], ['id' => $id]);
            $count++;
        }
        return true;
    }


    /**
     * Deletes an existing MasterSuggestionCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->title = $model->id . '_' . $model->title;
        $model->status = MasterSuggestionCategory::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterSuggestionCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterSuggestionCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterSuggestionCategory::findOne(['id' => $id, 'status' => [MasterSuggestionCategory::STATUS_ACTIVE, MasterSuggestionCategory::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
