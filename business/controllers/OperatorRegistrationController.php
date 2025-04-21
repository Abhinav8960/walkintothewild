<?php

namespace business\controllers;

use common\models\operatorregistration\form\OperatorRegistrationForm;
use common\models\operatorregistration\OperatorRegistration;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use Yii;



/**
 * OperatorFormController implements the CRUD actions for OperatorForm model.
 */
class OperatorRegistrationController extends Controller
{
    
   
    public function actionView($id)
    {
        $operator_model = $this->findModel($id);

        return $this->render('view', [
            'operator_model' => $operator_model,
        ]);
    }



    /**
     * Creates a new OperatorRegistration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'registration';
        $formModel = new OperatorRegistrationForm();

        if (Yii::$app->request->isPost) {
            $formModel->load(Yii::$app->request->post());

            if ($formModel->validate()) {
                $formModel->initializeForm();

                $formModel->uploadFiles();

                if ($formModel->operator_model->save(false)) {
                    return $this->redirect(['view', 'id' => $formModel->operator_model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save operator data.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Validation failed: ' . json_encode($formModel->getErrors()));
            }
        }

        return $this->render('create', [
            'model' => $formModel
        ]);
    }



    public function actionUpdate($id)
    {
        $operator_model = $this->findModel($id);

        if (!$operator_model) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }

        $formModel = new OperatorRegistrationForm($operator_model);

        $oldAttributes = $operator_model->getAttributes([
            'business_logo_upload',
            'business_kyc_detail',
            'cancle_check',
            'upload_aadhar_front',
            'upload_aadhar_back',
            'pan_upload',
            'upload_registration_number',
            'upload_registration_cert',
            'upload_document',
        ]);

        if (Yii::$app->request->isPost) {
            if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {

                $formModel->initializeForm();

                foreach ($oldAttributes as $key => $value) {
                    if (UploadedFile::getInstance($formModel, $key) === null) {
                        $formModel->operator_model->$key = $value;
                    }
                }

                $formModel->uploadFiles();

                if ($formModel->operator_model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Updated Successfully');
                    return $this->redirect(['view', 'id' => $formModel->operator_model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save operator model.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Validation failed: ' . json_encode($formModel->getErrors()));
            }
        }

        return $this->render('update', [
            'operator_model' => $formModel
        ]);
    }


    /**
     * Finds the OperatorRegistration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OperatorRegistration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OperatorRegistration::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
