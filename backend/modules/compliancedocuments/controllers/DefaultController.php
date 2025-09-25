<?php

namespace backend\modules\compliancedocuments\controllers;

use common\models\compliancedocuments\form\ComplianceDocumentsForm;
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
        $searchModel = new ComplianceDocumentsSearch();
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

        $lastVersion = ComplianceDocumentsVersion::find()
            ->where(['compliance_documents_id' => $model->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $form_model = new ComplianceDocumentsVersionForm($lastVersion);
        if ($this->request->isPost) {
            if ($form_model->load($this->request->post())) {
                if ($form_model->validate()) {
                    $form_model->initializeForm();
                    if ($form_model->cdocument_model->save()) {
                        if ($model->status == ComplianceDocuments::STATUS_UNPUBLISHED || $model->status == ComplianceDocuments::STATUS_CREATE) {
                            $model->type = $form_model->type;
                            $model->content = $form_model->content;
                            $model->save(false);
                        }
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
            ->where(['compliance_documents_id' => $model->id])
            ->andWhere(['status'=>1])
            ->orderBy(['id' => SORT_DESC])
            ->one();
       

        $form_model = new ComplianceDocumentsVersionForm($lastVersion);
        if (Yii::$app->request->isPost && $form_model->load($this->request->post())) {
            if ($form_model->validate()) {
                $form_model->initializeForm();
                if ($form_model->cdocument_model->save(false)) {
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

    // public function actionDelete($id)
    // {
    //     $model = $this->findModel($id);
    //     // $model->version = $model->id . '_' . $model->version;
    //     $model->status = ComplianceDocuments::STATUS_DELETE;
    //     $model->save(false);
    //     \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
    //     return $this->redirect(\Yii::$app->request->referrer);
    // }

    protected function findModel($id)
    {
        if (($model = ComplianceDocuments::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelVersion($compliance_documents_id)
    {
        if ($model = ComplianceDocumentsVersion::findOne(['compliance_documents_id' => $compliance_documents_id])) {
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

            $version_model = new ComplianceDocumentsVersion();
            $version_model->compliance_documents_id = $model->id;
            $version_model->version = $model->version;
            $version_model->type = $model->type;
            $version_model->content = $model->content;
            $version_model->effective_date = $model->effective_date;
            $version_model->status = 1;
            $version_model->save(false);

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
        $model->effective_date = null;
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Unpublished Successfully!');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to unpublish document.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}
