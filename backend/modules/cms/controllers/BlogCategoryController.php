<?php

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\blog\MasterBlogTopic;
use common\models\cms\blog\MasterBlogTopicSearch;
use common\models\cms\blog\form\MasterBlogTopicForm;

/**
 * BlogCategory Controller for the `blog` module
 */
class BlogCategoryController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterBlogTopicSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Blog Category
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterBlogTopicForm();
        $model->action_url = '/cms/blog-category/create';
        $model->action_validate_url = '/cms/blog-category/validate';
        $model->status = MasterBlogTopic::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->master_blog_topic_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/cms/blog-category/index']);
                    }
                }
            }
        } else {
            $model->master_blog_topic_model->loadDefaultValues();
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing MasterBlogTopic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $master_blog_topic_model = $this->findModel($id);
        $model = new MasterBlogTopicForm($master_blog_topic_model);
        $model->action_url = '/cms/blog-category/update?id=' . $id;
        $model->action_validate_url = '/cms/blog-category/validate?id=' . $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->master_blog_topic_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/cms/blog-category/index']);
                    }
                }
            }
        } else {
            $model->master_blog_topic_model->loadDefaultValues();
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
        $model = new MasterBlogTopicForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new MasterBlogTopicForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing MasterBlogTopic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->title = $model->id . '_' . $model->title;
        $model->slug = $model->id . '_' . $model->slug;
        $model->status = MasterBlogTopic::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterBlogTopic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterBlogTopic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterBlogTopic::findOne(['id' => $id, 'status' => [MasterBlogTopic::STATUS_ACTIVE, MasterBlogTopic::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
