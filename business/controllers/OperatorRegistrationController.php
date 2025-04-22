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

    public function actionCreate()
    {
        $this->layout = 'registration';

        if (Yii::$app->user->identity) {
            $operator_model = OperatorRegistration::findOne(['user_id' => Yii::$app->user->identity->id]);
            if (!$operator_model) {
                $model = new OperatorRegistrationForm();
            } else {
                $model = new OperatorRegistrationForm($operator_model);
            }
        }
        $model->user_id = Yii::$app->user->identity->id;
        $model->setScenario(OperatorRegistrationForm::SCENARIO_STEP1);
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    $model->operator_model->current_step = 2;
                    if ($model->operator_model->save()) {
                        return $this->redirect(['step-2']);
                    } else {
                        Yii::error($model->operator_model->errors);
                        print_r($model->operator_model->errors);
                    }
                }
            }
        } else {
            $model->operator_model->loadDefaultValues();
        }

        return $this->render('_step1', [
            'model' => $model,
        ]);
    }

    public function actionStep2()
    {
        $this->layout = 'registration';
        $operator_model = $this->findModel();

        if ($operator_model->current_step < 2) {
            return $this->redirect(['create']);
        }

        $model = new OperatorRegistrationForm($operator_model);
        $model->setScenario(OperatorRegistrationForm::SCENARIO_STEP2);
        $model->current_step = 3;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->operator_model->save(false)) {
                        return $this->redirect(['step-3']);
                    } else {
                        Yii::error($model->operator_model->errors);
                        print_r($model->operator_model->errors);
                    }
                }
            }
        } else {
            $model->operator_model->loadDefaultValues();
        }

        return $this->render('_step2', [
            'model' => $model,
        ]);
    }
    public function actionStep3()
    {
        $this->layout = 'registration';
        $operator_model = $this->findModel();

        if ($operator_model->current_step < 3) {
            return $this->redirect(['step-2']);
        }

        $model = new OperatorRegistrationForm($operator_model);
        $model->setScenario(OperatorRegistrationForm::SCENARIO_STEP3);
        $model->current_step = 4;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->operator_model->save(false)) {
                        return $this->redirect(['step-4']);
                    }
                }
            }
        } else {
            $model->operator_model->loadDefaultValues();
        }

        return $this->render('_step3', [
            'model' => $model,
        ]);
    }

    public function actionStep4()
    {
        $this->layout = 'registration';

        $operator_model = $this->findModel();

        if ($operator_model->current_step < 4) {
            return $this->redirect(['step-3']);
        }
        $model = new OperatorRegistrationForm($operator_model);
        $model->setScenario(OperatorRegistrationForm::SCENARIO_STEP4);
        $model->current_step = 5;
        $model->final = 1;
        $model->updated_time_final = date('Y-m-d H:i:s');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->operator_model->save(false)) {
                        return $this->redirect(['view',]);
                    }
                }
            }
        } else {
            $model->operator_model->loadDefaultValues();
        }

        return $this->render('_step4', [
            'model' => $model,
        ]);
    }

    public function actionView()
    {
        $this->layout = 'registration';
        $operator_model = $this->findModel();
        return $this->render('_step5', [
            'operator_model' => $operator_model,
        ]);
    }


    public function actionUpdate()
    {
        $operator_model = $this->findModel();

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
    protected function findModel()
    {
        if (($model = OperatorRegistration::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['id'=>SORT_DESC])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
