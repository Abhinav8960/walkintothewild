<?php

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\cms\article\MasterArticleTag;
use common\models\cms\article\MasterArticleTagSearch;
use common\models\cms\article\form\MasterArticleTagForm;

/**
 * ArticleTag Controller for the `blog` module
 */
class ArticleTagController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterArticleTagSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Article Tag
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterArticleTagForm();
        $model->action_url = '/cms/article-tag/create';
        $model->action_validate_url = '/cms/article-tag/validate';
        $model->status = MasterArticleTag::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->master_article_tag_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['/cms/article-tag/index']);
                    }
                }
            }
        } else {
            $model->master_article_tag_model->loadDefaultValues();
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing MasterArticleTag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $master_article_tag_model = $this->findModel($id);
        $model = new MasterArticleTagForm($master_article_tag_model);
        $model->action_url = '/cms/article-tag/update?id=' . $id;
        $model->action_validate_url = '/cms/article-tag/validate?id=' . $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->master_article_tag_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/cms/article-tag/index']);
                    }
                }
            }
        } else {
            $model->master_article_tag_model->loadDefaultValues();
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
        $model = new MasterArticleTagForm();
        if ($id != null) {
            $formmodel = $this->findModel($id);
            $model = new MasterArticleTagForm($formmodel);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Deletes an existing MasterArticleTag model.
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
        $model->status = MasterArticleTag::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterArticleTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterArticleTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterArticleTag::findOne(['id' => $id, 'status' => [MasterArticleTag::STATUS_ACTIVE, MasterArticleTag::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
