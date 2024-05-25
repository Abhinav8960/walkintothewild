<?php

namespace backend\modules\master\controllers;

use common\interfaces\StatusInterface;
use common\models\master\airport\form\MasterAirportForm;
use common\models\master\airport\MasterAirport;
use common\models\master\airport\MasterAirportSearch;
use Yii;
use yii\web\UploadedFile;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\FileHelper;

/**
 * AirportController.
 */
class AirportController extends Controller
{
    /**
     * Lists all MasterCenterSeatType models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterAirportSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Create SeatType.
     * 
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterAirportForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->airport_model->save(false)) {
                        //$model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->airport_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterCenterSeatType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $airport_model = $this->findModel($id);
        $model = new MasterAirportForm($airport_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->airport_model->save()) {
                        $model->airport_model->save();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->airport_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }




    public function actionAirportfromfile()
    {

        $model = new MasterAirportForm();
        $model->scenario = 'uploadfile';
        if ($model->load(Yii::$app->request->post())) {
            $uploadedfile = UploadedFile::getInstance($model, 'uploadfile');
            if ($uploadedfile) {
                $time = date("Y/m/d");
                $path = Yii::$app->params['datapath'] . '/csv/' . $time;
                FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
                $filepath =  $uploadedfile;
                $uploadedfile->saveAs($path . '/' . $uploadedfile);
                $uploadedfile->saveAs($filepath);
                $uploadFileName = $uploadedfile->name;
                $uploadFilePath = $filepath;
                $fullpath = $path . '/' . $uploadFileName;
                $csv = array();
                $rowcount = 0;
                if (($handle = fopen($fullpath, "r")) !== FALSE) {
                    $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
                    while (($row = fgetcsv($handle, $max_line_length)) !== FALSE) {
                        $row_colcount = count($row);
                        $csv[] = $row;
                        $rowcount++;
                    }
                    fclose($handle);
                }
                // Remove first row from count
                $rowcount = $rowcount - 1;
                if (!empty($csv)) {
                    $countsuccess = 0;
                    foreach (array_slice($csv, 1) as $key => $value) {
                        $model = new MasterAirportForm();
                        $model->scenario = 'create';
                        $model->airport_model->name = $value[1];
                        $model->airport_model->country_id = 1;
                        $model->airport_model->state_id = $value[0];
                        $model->airport_model->iata_code = $value[2];
                        $model->airport_model->icao_code = $value[3];
                        $model->airport_model->status = 1;
                        $model->airport_model->save(false);
                    }
                    \Yii::$app->getSession()->setFlash('success', $rowcount . ' out of ' . $countsuccess . ' airport Successfully Imported');
                    return $this->redirect(['/master/airport/index']);
                }
            }
        }


        return $this->render('airportfromfile', [
            'model' => $model
        ]);
    }


    /**
     * Deletes an existing MasterCenterSeatType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->name = $model->id . '_' . $model->name;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterCenterSeatType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterCenterSeatType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterAirport::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
