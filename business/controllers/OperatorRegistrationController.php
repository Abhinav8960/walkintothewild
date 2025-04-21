<?php

namespace business\controllers;

use common\models\operatorregistration\form\OperatorRegistrationForm;
// use common\models\operatorregistration\form\OperatorRegistrationForm;
use common\models\operatorregistration\OperatorRegistration;
use common\models\operatorregistration\OperatorRegistrationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use Yii;



/**
 * OperatorFormController implements the CRUD actions for OperatorForm model.
 */
class OperatorRegistrationController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all OperatorRegistration models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OperatorRegistrationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OperatorRegistration model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //      $operator_model = $this->findModel($id);
    //     return $this->render('view', [
    //         'operator_model' => $operator_model,
    //     ]);
    // }
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



    // public function actionCreate()
    // {
    //     $model = new OperatorRegistration();

    //     if (Yii::$app->request->isPost) {
    //         $model->load(Yii::$app->request->post());

    //         $model->uploadFiles();

    //         if ($model->validate()) {
    //             if ($model->save(false)) {
    //                 return $this->redirect(['view', 'id' => $model->id]);
    //             }
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Validation failed: ' . json_encode($model->getErrors()));
    //         }
    //     }

    //     return $this->render('create', ['model' => $model]);
    // }



    /**
     * Updates an existing OperatorRegistration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $operator_model = $this->findModel($id);

    //     if (!$operator_model) {
    //         throw new NotFoundHttpException("The requested page does not exist.");
    //     }

    //     $formModel = new OperatorRegistrationForm($operator_model);


    //     $oldAttributes = $operator_model->getAttributes([
    //         'business_logo_upload',
    //         'business_kyc_detail',
    //         'cancle_check',
    //         'upload_aadhar_front',
    //         'upload_aadhar_back',
    //         'pan_upload',
    //         'upload_registration_number',
    //         'upload_registration_cert',
    //         'upload_document',
    //     ]);

    //     if (Yii::$app->request->isPost) {

    //         if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {


    //             $formModel->initializeForm();

    //             foreach ($oldAttributes as $key => $value) {
    //                 if (UploadedFile::getInstance($formModel->operator_model, $key) === null) {
    //                     $formModel->operator_model->$key = $value;
    //                 }
    //             }


    //             $formModel->operator_model->uploadFiles();



    //             if ($formModel->operator_model->save(false)) {
    //                 Yii::$app->session->setFlash('success', 'Updated Successfully');
    //                 return $this->redirect(['view', 'id' => $formModel->operator_model->id]);
    //             }
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Validation failed: ' . json_encode($formModel->getErrors()));
    //         }
    //     }

    //     return $this->render('update', [
    //         'operator_model' => $formModel
    //     ]);
    // }

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
     * Deletes an existing OperatorRegistration model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID    
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

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
