<?php

namespace backend\modules\cms\controllers;


use common\models\cms\faqcategory\FaqCategory;
use common\models\cms\faqs\form\FaqsForm;
use common\models\cms\faqs\Faqs;
use common\models\cms\faqs\FaqsSearch;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FaqsController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new FaqsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $categories = FaqCategory::find()->select(['id', 'name'])->where(['status' => true])->all();
        $categoryList = ArrayHelper::map($categories, 'id', 'name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryList' => $categoryList,
        ]);
    }

    public function actionCreate()
    {
        $model = new FaqsForm();
        $model->status = Faqs::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->faqs_model->save(false)) {
                        //$model->uploadFile();
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Data Submitted ']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->faqs_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $faqs_model = $this->findModel($id);
        $model = new FaqsForm($faqs_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->faqs_model->save()) {
                        $model->faqs_model->save();
                        $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->faqs_model->loadDefaultValues();
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
        $searchModel = new FaqsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, false);
        $dataProvider->pagination = false;
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
            Faqs::updateAll([
                'sequence' => $count
            ], ['id' => $id]);
            $count++;
        }
        return true;
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->category_id = $model->id . '_' . $model->category_id;
        $model->status = Faqs::STATUS_DELETE;
        $model->save();
        $message = Yii::$app->messageManager->getMessage('common.deleted', ['{var}' => 'Data']);
        \Yii::$app->session->setFlash('success', $message);
        return $this->redirect(Yii::$app->request->referrer); // corrected Yii::$app->request
    }

    protected function findModel($id)
    {
        if (($model = Faqs::findOne(['id' => $id, 'status' => [Faqs::STATUS_ACTIVE, Faqs::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        $message = Yii::$app->messageManager->getMessage('page_not_exist');
        throw new NotFoundHttpException($message);
    }
}
