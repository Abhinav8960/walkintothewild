<?php

namespace backend\modules\article\controllers;

use common\interfaces\StatusInterface;
use common\models\article\article\Article;
use common\models\article\articleSource\ArticleSource;
use common\models\article\articleSource\ArticleSourceSearch;
use common\models\article\articleSource\form\ArticleSourceForm;
//use backend\modules\article\models\ArticleSource;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RareAnimalController.
 */
class ArticleSourceController extends Controller
{
    /**
     * Lists all MasterAnimal models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSourceSearch();
       // $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);
        // echo '<pre>';
        // print_r($dataProvider->getModels());
        // echo '</pre>';
        // die;

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
        $model = new ArticleSourceForm();
        $model->status = StatusInterface::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                //$model->category_id = (array)$model->category_id;
                //$model->frequency_id = (array)$model->frequency_id;

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->article_source_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->article_source_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterAnimal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $article_source_model = $this->findModel($id);
        $model = new ArticleSourceForm($article_source_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->article_source_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->article_source_model->loadDefaultValues();
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
     * Deletes an existing MasterAnimal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->article_source = $model->id . '_' . $model->article_source;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = ArticleSource::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
