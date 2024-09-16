<?php

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


use common\models\cms\faqcategory\FaqCategory;
use common\models\cms\faqcategory\FaqCategorySearch;
use common\models\cms\faqcategory\form\FaqCategoryForm;

class FaqcategoryController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new FaqCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new FaqCategoryForm();
        $model->status = FaqCategory::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->faq_model->save(false)) {
                        //$model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->faq_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $faq_model = $this->findModel($id);
        $model = new FaqCategoryForm($faq_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->faq_model->save()) {
                        $model->faq_model->save();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->faq_model->loadDefaultValues();
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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->name = $model->id . '_' . $model->name;
        $model->status = FaqCategory::STATUS_DELETE;
        $model->save();
        Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(Yii::$app->request->referrer); // corrected Yii::$app->request
    }

    protected function findModel($id)
    {
        if (($model = FaqCategory::findOne(['id' => $id, 'status' => [FaqCategory::STATUS_ACTIVE, FaqCategory::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
