<?php

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\article\MasterArticleAuthor;
use common\models\cms\article\form\MasterArticleAuthorForm;
use common\models\cms\article\MasterArticleAuthorSearch;
use common\models\cms\article\MasterArticleTag;

/**
 * MasterArticleAuthor Controller for the `article` module
 */
class MasterArticleAuthorController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterArticleAuthorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Article Author
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterArticleAuthorForm();
        $model->status = MasterArticleAuthor::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->master_article_author_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Data Submitted ']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['/cms/master-article-author/index']);
                    }
                }
            }
        } else {
            $model->master_article_author_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Article Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $master_article_author_model = $this->findModel($id);
        $model = new MasterArticleAuthorForm($master_article_author_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->master_article_author_model->save()) {
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['/cms/master-article-author/index']);
                    }
                }
            }
        } else {
            $model->master_article_author_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }




    /**
     * Deletes an existing MasterArticleAuthor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = MasterArticleAuthor::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.deleted', ['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterArticleAuthor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterArticleAuthor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterArticleAuthor::findOne(['id' => $id, 'status' => [MasterArticleAuthor::STATUS_ACTIVE, MasterArticleAuthor::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
