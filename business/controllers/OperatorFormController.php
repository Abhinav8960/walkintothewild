<?php

namespace business\controllers;

use common\models\OperatorForm;
use common\models\OperatorFormSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * OperatorFormController implements the CRUD actions for OperatorForm model.
 */
class OperatorFormController extends Controller
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
     * Lists all OperatorForm models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OperatorFormSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OperatorForm model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new OperatorForm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new OperatorForm();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreate()
    {
        $model = new OperatorForm();

        if ($this->request->isPost) {
            $model->load($this->request->post());

            $model->business_logo_upload = UploadedFile::getInstance($model, 'business_logo_upload');
            $model->business_kyc_detail = UploadedFile::getInstance($model, 'business_kyc_detail');
            $model->cancle_check = UploadedFile::getInstance($model, 'cancle_check');
            $model->upload_aadhar_front = UploadedFile::getInstance($model, 'upload_aadhar_front');
            $model->upload_aadhar_back = UploadedFile::getInstance($model, 'upload_aadhar_back');
            $model->pan_upload = UploadedFile::getInstance($model, 'pan_upload');
            $model->upload_registration_number = UploadedFile::getInstance($model, 'upload_registration_number');
            $model->upload_registration_cert = UploadedFile::getInstance($model, 'upload_registration_cert');
            $model->upload_document = UploadedFile::getInstance($model, 'upload_document');

            if ($model->validate()) {
                if ($model->save(false)) {
                    $model->saveUploads();
                    $model->save(false);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing OperatorForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionUpdate($id)
    {
        $model = OperatorForm::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException("The requested page does not exist.");
        }

        if ($this->request->isPost) {
            $model->load($this->request->post());

            $fields = [
                'business_logo_upload',
                'business_kyc_detail',
                'cancle_check',
                'upload_aadhar_front',
                'upload_aadhar_back',
                'pan_upload',
                'upload_registration_number',
                'upload_registration_cert',
                'upload_document'
            ];

            foreach ($fields as $field) {
                $file = UploadedFile::getInstance($model, $field);
                if ($file) {
                    $model->$field = $file;
                } else {
                    $model->$field = $model->getOldAttribute($field);
                }
            }

            if ($model->validate()) {
                if ($model->save(false)) {
                    $model->saveUploads();
                    $model->save(false);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



    /**
     * Deletes an existing OperatorForm model.
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
     * Finds the OperatorForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OperatorForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OperatorForm::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
