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
use yii\web\UploadedFile;

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
        // $model->scenario = ComplianceDocumentsVersionForm::SCENARIO_CREATE;
        if (Yii::$app->request->isPost && $model->load($this->request->post())) {
            // $model->banner_image = UploadedFile::getInstance($model, 'banner_image');
            if ($model->validate()) {
                $model->initializeForm();
                if ($model->cdocument_model->save(false)) {
                    // $model->uploadFile();
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
                // $form_model->banner_image = UploadedFile::getInstance($form_model, 'banner_image');
                if ($form_model->validate()) {
                    $form_model->initializeForm();
                    if ($form_model->cdocument_model->save()) {
                        // $form_model->uploadFile();
                        Yii::$app->session->setFlash('success', 'Document updated successfully.');
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

        $published_version = ComplianceDocumentsVersion::find()->where(['type'=>$model->type])->andWhere(['status'=>1])->limit(1)->one();
        if($published_version)
        {
            $published_version->status = -1;
            $published_version->save(false);
        }

        $main_model = ComplianceDocuments::find()->where(['type' => $model->type])->limit(1)->one();
        $model->status = ComplianceDocuments::STATUS_PUBLISHED;
        $model->effective_date = date('Y-m-d H:i:s');
        if ($model->save(false)) {
            $this->copynewversion($model->id);

            $model_main = $main_model ?? new ComplianceDocuments();
            $model_main->version_id = $model->id;
            $model_main->version = $model->version;
            $model_main->type = $model->type;
            $model_main->content = $model->content;
            $model_main->banner_image = $model->banner_image;
            $model_main->effective_date = $model->effective_date;
            $model_main->status = ComplianceDocuments::STATUS_PUBLISHED;
            $model_main->save(false);
            Yii::$app->session->setFlash('success', 'Published Successfully!');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to publish document.');
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
        $version_model->version = 'v' . (intval(substr($model->version, 1)) + 1);
        $version_model->type = $model->type;
        $version_model->content = $model->content;
        $version_model->effective_date = $model->effective_date;
        $version_model->banner_image = $model->banner_image;
        $version_model->status = ComplianceDocuments::STATUS_UNPUBLISHED;
        $version_model->save(false);
        return true;
    }
}
