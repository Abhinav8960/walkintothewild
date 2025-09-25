<?php

namespace backend\modules\compliancedocuments\controllers;

use common\models\compliancedocuments\form\ComplianceDocumentsVersionForm;
use common\models\compliancedocuments\ComplianceDocuments;
use common\models\compliancedocuments\ComplianceDocumentsSearch;
use common\models\compliancedocuments\ComplianceDocumentsVersion;
use common\models\compliancedocuments\ComplianceDocumentsVersionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ComplianceDocumentsVersionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Create ComplianceDocuments.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComplianceDocumentsVersionForm();
        if (Yii::$app->request->isPost && $model->load($this->request->post())) {
            if ($model->validate()) {
                $model->initializeForm();
                if ($model->cdocument_model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Document created successfully.');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->cdocument_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ComplianceDocuments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            throw new NotFoundHttpException('Document not found');
        }
        $form_model = new ComplianceDocumentsVersionForm($model);
        if ($this->request->isPost) {
            if ($form_model->load($this->request->post())) {
                if ($form_model->validate()) {
                    $form_model->initializeForm();
                    if ($form_model->cdocument_model->save()) {
                        Yii::$app->session->setFlash('success', 'Document created successfully.');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $form_model->cdocument_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $form_model,
        ]);
    }


    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            throw new NotFoundHttpException('Document not found');
        }

        $lastVersion = ComplianceDocumentsVersion::find()
            ->where(['id' => $model->id])
            ->andWhere(['status' => 1])
            ->one();

        $form_model = new ComplianceDocumentsVersionForm($lastVersion);
        if (Yii::$app->request->isPost && $form_model->load($this->request->post())) {
            if ($form_model->validate()) {
                $form_model->initializeForm();
                if ($form_model->cdocument_model->save(false)) {
                    $this->copynewversion($id);
                    Yii::$app->session->setFlash('success', 'Document created successfully.');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $form_model->cdocument_model->loadDefaultValues();
        }
        return $this->render('update', [
            'model' => $form_model,
        ]);
    }



    public function actionView($id, $version = null)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    protected function findModel($id)
    {
        if (($model = ComplianceDocumentsVersion::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPublish($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            Yii::$app->session->setFlash('error', 'Document not found.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model->status = ComplianceDocuments::STATUS_PUBLISHED;
        $model->effective_date = date('Y-m-d H:i:s');
        if ($model->save(false)) {
            $model_main = new ComplianceDocuments();
            $model_main->version_id = $model->id;
            $model_main->version = $model->version;
            $model_main->title = $model->title;
            $model_main->content = $model->content;
            $model_main->effective_date = $model->effective_date;
            $model_main->status = ComplianceDocuments::STATUS_PUBLISHED;
            $model_main->save(false);
            Yii::$app->session->setFlash('success', 'Published Successfully!');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to publish document.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUnpublish($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            Yii::$app->session->setFlash('error', 'Document not found.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model->status = ComplianceDocuments::STATUS_UNPUBLISHED;
        if ($model->save(false)) {
            $model_document = ComplianceDocuments::find()->where(['version_id'=>$id])->one();
            $model_document->status = ComplianceDocuments::STATUS_UNPUBLISHED;
            $model_document->save(false);
            Yii::$app->session->setFlash('success', 'Unpublished Successfully!');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to unpublish document.');
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }

    private function copynewversion($id)
    {
        $model = $this->findModel($id);
        if (!$model) {
            throw new NotFoundHttpException('Document not found');
        }

        $version_model = new ComplianceDocumentsVersion();
        // $version_model->compliance_documents_id = $model->id;
        $version_model->version = 'v' . (intval(substr($model->version, 1)) + 1);
        $version_model->title = $model->title;
        $version_model->content = $model->content;
        $version_model->effective_date = null;
        $version_model->status = ComplianceDocuments::STATUS_UNPUBLISHED;
        $version_model->save(false);
        return true;
    }
}
