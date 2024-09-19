<?php

namespace backend\modules\article\controllers;

use common\interfaces\StatusInterface;
use common\models\article\article\Article;
use common\models\article\article\ArticleSearch;
use common\models\article\article\form\ArticleForm;
use common\models\article\articleTag\ArticleTag;
use Yii;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RareAnimalController.
 */
class ArticleController extends Controller
{
    /**
     * Lists all MasterAnimal models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
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
        $model = new ArticleForm();
        $model->status = StatusInterface::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->tag_id = (array)$model->tag_id;

                $model->image = UploadedFile::getInstance($model, 'image');
                $model->video = UploadedFile::getInstance($model, 'video');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->article_model->save(false)) {
                        $model->uploadFile();

                        //$model->article_model->unlinkAll('title', true);
                        $temp = [];
                        foreach ($model->tag_id as $tagId) {
                            $temp[] = $tagId;
                        }
                        $model->tag_id = json_encode($temp);
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $article_model = $this->findModel($id);
        $model = new ArticleForm($article_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->video = UploadedFile::getInstance($model, 'video');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->article_model->save(false)) {
                        $model->uploadFile($model->article_model->id);
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->article_model->loadDefaultValues();
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
        $model->article_title = $model->id . '_' . $model->article_title;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
