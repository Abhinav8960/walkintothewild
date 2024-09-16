<?php

namespace backend\modules\master\controllers;

use common\models\master\railwaystation\form\MasterRailwayStationForm;
use common\models\master\railwaystation\MasterRailwayStation;
use common\models\master\railwaystation\MasterRailwayStationSearch;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RailwayStationController.
 */
class RailwayStationController extends Controller
{
    /**
     * Lists all MasterRailwayStation models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MasterRailwayStationSearch();
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
        $model = new MasterRailwayStationForm();
        $model->status = MasterRailwayStation::STATUS_ACTIVE;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->railway_station_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->railway_station_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MasterRailwayStation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $railway_station_model = $this->findModel($id);
        $model = new MasterRailwayStationForm($railway_station_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->railway_station_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->railway_station_model->loadDefaultValues();
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }



    public function actionRailwayfromfile()
    {

        $model = new MasterRailwayStationForm();
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
                        $model = new MasterRailwayStationForm();
                        $model->scenario = 'create';
                        $model->railway_station_model->country_id = 1;
                        $model->railway_station_model->state_id = $value[0];
                        $model->railway_station_model->title = $value[1];
                        $model->railway_station_model->status = MasterRailwayStation::STATUS_ACTIVE;
                        $model->railway_station_model->save(false);
                    }
                    \Yii::$app->getSession()->setFlash('success', $rowcount . ' out of ' . $countsuccess . ' railway station Successfully Imported');
                    return $this->redirect(['/master/railway-station']);
                }
            }
        }


        return $this->render('railwayfromfile', [
            'model' => $model
        ]);
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);


        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing MasterRailwayStation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->title = $model->id . '_' . $model->title;
        $model->status = MasterRailwayStation::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Finds the MasterRailwayStation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MasterRailwayStation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterRailwayStation::findOne(['id' => $id, 'status' => [MasterRailwayStation::STATUS_ACTIVE, MasterRailwayStation::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
