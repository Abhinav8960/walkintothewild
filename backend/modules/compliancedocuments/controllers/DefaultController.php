<?php

namespace backend\modules\compliancedocuments\controllers;

use common\models\compliancedocuments\ComplianceDocuments;
use common\models\compliancedocuments\ComplianceDocumentsSearch;
use common\models\compliancedocuments\ComplianceDocumentsVersion;
use common\models\compliancedocuments\ComplianceDocumentsVersionSearch;
use common\models\compliancedocuments\form\ComplianceDocumentsForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        $model = new ComplianceDocumentsForm();
        $model_version = new ComplianceDocumentsVersion();
        $model->status = ComplianceDocuments::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model_version->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->cdocument_model->save(false)) {
                        $model_version->compliance_documents_id = $model->cdocument_model->id;
                        if ($model_version->save(false)) {
                            \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                            return $this->redirect(['index']);
                        }
                    }
                }
            }
        } else {
            $model->cdocument_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'model_version' => $model_version
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
        $cdocument_model = $this->findModel($id);
        $model = new ComplianceDocumentsForm($cdocument_model);
        $model_version = $this->findModelVersion($id);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())  && $model_version->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->cdocument_model->save(false)) {
                        if ($model_version->save()) {
                            \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                            return $this->redirect(['index']);
                        }
                    }
                }
            }
        } else {
            $model->cdocument_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'model_version' => $model_version
        ]);
    }

    public function actionView($id, $version = null)
    {
        $model = $this->findModel($id);

        if ($version === null) {
            $model_version = ComplianceDocumentsVersion::find()
                ->where(['compliance_documents_id' => $id, 'is_live' => 1])
                ->one();
        } else {
            $model_version = ComplianceDocumentsVersion::find()
                ->where(['compliance_documents_id' => $id, 'version' => $version])
                ->one();
        }
        if (!$model_version) {
            throw new NotFoundHttpException("Version not found");
        }

        return $this->render('view', [
            'model' => $model,
            'model_version' => $model_version,
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // $model->version = $model->id . '_' . $model->version;
        $model->status = ComplianceDocuments::STATUS_DELETE;
        $model->save(false);
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    // protected function findModel($id)
    // {
    //     if (($model = ComplianceDocuments::findOne(['id' => $id, 'status' => [ComplianceDocuments::STATUS_ACTIVE, ComplianceDocuments::STATUS_INACTIVE]])) !== null) {
    //         return $model;
    //     }

    //     throw new NotFoundHttpException('The requested page does not exist.');
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


    // public function actionVersionUpgrade($compliance_documents_id)
    // {
    //     $transaction = Yii::$app->db->beginTransaction();
    //     try {
    //         $this->upgradeNow($compliance_documents_id);
    //         Yii::$app->session->setFlash('success', 'Upgraded successfully');
    //     } catch (\Exception $e) {
    //         Yii::error($e->getMessage());
    //         $transaction->rollBack();
    //         Yii::$app->session->setFlash('error', 'An error occurred !' . $e->getMessage());
    //         echo "<pre>";
    //         print_r($e->getMessage());
    //         die();
    //     }
    //     $transaction->commit();
    //     return $this->redirect(Yii::$app->request->referrer);
    // }


    // private function upgradeNow($compliance_documents_id)
    // {
    //     $model = ComplianceDocumentsVersion::findOne($compliance_documents_id);

    //     if ($model) {
    //         $newModel = new ComplianceDocumentsVersion();
    //         $newModel->attributes = $model->attributes;
    //         $newModel->version = 'v' . (intval(substr($this->latestVersion($model->compliance_documents_id), 1)) + 1);            
    //         $newModel->id = null; // Set the ID to null for the new record
    //         // $newModel->status = ComplianceDocuments::STATUS_ACTIVE;
    //         $newModel->save(false);
    //         return $newModel;
    //     }
    //     return true;
    // }


    // private function upgradeNow($compliance_documents_id)
    // {
    //     $latest = ComplianceDocumentsVersion::find()
    //         ->where(['compliance_documents_id' => $compliance_documents_id])
    //         ->orderBy(['id' => SORT_DESC])
    //         ->one();

    //     if ($latest) {
    //         $newModel = new ComplianceDocumentsVersion();
    //         $newModel->attributes = $latest->attributes;
    //         $newModel->id = null; // Ensure it's treated as a new record
    //         $newModel->version = 'v' . (intval(substr($latest->version, 1)) + 1); // Increment version
    //         $newModel->compliance_documents_id = $compliance_documents_id; // Important!
    //         $newModel->save(false);
    //         return $newModel;
    //     } else {
    //         throw new \Exception("No previous version found for compliance_documents_id: $compliance_documents_id");
    //     }

    //     $docModel = ComplianceDocuments::findOne($id);

    //     if ($docModel) {
    //         $docModel->attributes = $newModel->attributes;
    //         $docModel->id = null;
    //         $docModel->save(false);
    //         return $docModel;
    //         if (!$docModel->save(false)) {
    //             throw new \Exception("Failed to update ComplianceDocuments record.");
    //         }
    //     }

    //     return $newModel;
    // }
    // private function latestVersion($compliance_documents_id){
    //    $cd = ComplianceDocumentsVersion::find()->where(['compliance_documents_id'=>$compliance_documents_id])->orderBy(['compliance_documents_id'=>SORT_DESC])->one();
    //    return $cd->version;
    // }
}
