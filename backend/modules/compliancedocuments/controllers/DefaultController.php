<?php

namespace backend\modules\compliancedocuments\controllers;

use common\models\compliancedocuments\ComplianceDocuments;
use common\models\compliancedocuments\ComplianceDocumentsSearch;
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
            'dataProvider' => $dataProvider,
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
        $model->status = ComplianceDocuments ::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->cdocument_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
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
        $cdocument_model = $this->findModel($id);
        $model = new ComplianceDocumentsForm($cdocument_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->cdocument_model->save()) {
                        $model->cdocument_model->save();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->cdocument_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->version = $model->id . '_' . $model->version;
        $model->status = ComplianceDocuments ::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = ComplianceDocuments::findOne(['id' => $id, 'status' => [ComplianceDocuments::STATUS_ACTIVE, ComplianceDocuments::STATUS_INACTIVE]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionVersionUpgrade($id)
    {

        $m = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $this->upgradeNow($id);
            // $this->updatePackageStatus($m->uuid, $m->version, $m->status);
            Yii::$app->session->setFlash('success', 'Upgraded successfully');
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred !' . $e->getMessage());
            echo "<pre>";
            print_r($e->getMessage());
            die();
        }
        $transaction->commit();

        return $this->redirect(Yii::$app->request->referrer);
    }
    private function upgradeNow($id)
    {
        $model = ComplianceDocuments::findOne($id);

        if ($model) {
            $newModel = new ComplianceDocuments();
            $newModel->attributes = $model->attributes;
            $newModel->version = 'v' . (intval(substr($this->latestVersion($model->uuid), 1)) + 1);

            
            $newModel->id = null; // Set the ID to null for the new record
            $newModel->status = ComplianceDocuments::STATUS_ACTIVE;
            $newModel->save(false);
            return $newModel;
        }
        return true;
    }

    private function latestVersion($uuid){
       $cd = ComplianceDocuments::find()->where(['uuid'=>$uuid])->orderBy(['id'=>SORT_DESC])->one();
       return $cd->version;
    }
}
