<?php

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\blog\BlogAuthor;
use common\models\cms\blog\BlogAuthorSearch;
use common\models\cms\blog\form\BlogAuthorForm;

/**
 * BlogAuthor Controller for the `blog` module
 */
class BlogAuthorController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BlogAuthorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere("user_id is null");
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Blog Author
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogAuthorForm();
        $model->action_url = '/cms/blog-author/create';
        $model->action_validate_url = '/cms/blog-author/validate';
        $model->status = BlogAuthor::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->blog_author_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/cms/blog-author/index']);
                    }
                }
            }
        } else {
            $model->blog_author_model->loadDefaultValues();
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Blog Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $blog_author_model = $this->findModel($id);
        $model = new BlogAuthorForm($blog_author_model);
        $model->action_url = '/cms/blog-author/update?id=' . $id;
        $model->action_validate_url = '/cms/blog-author/validate?id=' . $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->blog_author_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/cms/blog-author/index']);
                    }
                }
            }
        } else {
            $model->blog_author_model->loadDefaultValues();
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
        $model = new BlogAuthorForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new BlogAuthorForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing BlogAuthor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->author_name = $model->id . '_' . $model->author_name;
        $model->slug = $model->id . '_' . $model->slug;
        $model->status = BlogAuthor::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the BlogAuthor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return BlogAuthor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogAuthor::findOne(['id' => $id, 'status' => [BlogAuthor::STATUS_ACTIVE, BlogAuthor::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
