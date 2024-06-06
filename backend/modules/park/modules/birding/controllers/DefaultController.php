<?php

namespace backend\modules\park\modules\birding\controllers;

use common\interfaces\StatusInterface;
use common\models\park\form\BirdingParkForm;
use common\models\park\BirdingParkBonusExperience;
use common\models\park\BirdingPark;
use common\models\park\BirdingParkAccomodation;
use common\models\park\BirdingParkAnimal;
use common\models\park\BirdingParkGallerySearch;
use common\models\park\BirdingParkMonth;
use common\models\park\BirdingParkSearch;
use common\models\park\BirdingParkSession;
use common\models\park\BirdingParkVehicle;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\FileHelper;
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
        $searchModel = new BirdingParkSearch();
        $searchModel->status = BirdingPark::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        $model = new BirdingParkForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_model->save(false)) {
                        $model->uploadFile();
                        $birdingaccomodation = $model->accomodation;
                        if ($birdingaccomodation) {
                            foreach ($birdingaccomodation as $birding_accomodation) {
                                $birdingparkAccomodation = new BirdingParkAccomodation();
                                $birdingparkAccomodation->birding_park_id = $model->birding_park_model->id;
                                $birdingparkAccomodation->master_accomodation_id = $birding_accomodation;
                                $birdingparkAccomodation->save(false);
                            }
                        }

                        $sessions = $model->birding_session;
                        if ($sessions) {
                            foreach ($sessions as $session) {
                                $birdingparkSession = new BirdingParkSession();
                                $birdingparkSession->birding_park_id = $model->birding_park_model->id;
                                $birdingparkSession->session_id = $session;
                                $birdingparkSession->save(false);
                            }
                        }

                        $months = $model->month;
                        if ($months) {
                            foreach ($months as $birding_month) {
                                $birdingparkMonth = new BirdingParkMonth();
                                $birdingparkMonth->birding_park_id = $model->birding_park_model->id;
                                $birdingparkMonth->month_id = $birding_month;
                                $birdingparkMonth->save(false);
                            }
                        }

                        $bonusexperience = $model->master_bonus_experience_id;
                        if ($bonusexperience) {
                            foreach ($bonusexperience as $bonus) {
                                $birdingparkBonus = new BirdingParkBonusExperience();
                                $birdingparkBonus->birding_park_id = $model->birding_park_model->id;
                                $birdingparkBonus->master_bonus_experience_id = $bonus;
                                $birdingparkBonus->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->birding_park_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $birding_park_model = $this->findModel($id);
        $model = new BirdingParkForm($birding_park_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_model->save()) {
                        $birdingvehicles = $model->vehicle_id;
                        if ($birdingvehicles) {
                            BirdingParkVehicle::updateAll(['status' => 2], ['birding_park_id' => $id]);
                            foreach ($birdingvehicles as $birdingvehicle) {
                                $birdingparkVehicle = new BirdingParkVehicle();
                                $birdingparkVehicle->birding_park_id = $model->birding_park_model->id;
                                $birdingparkVehicle->vehicle_id = $birdingvehicle;
                                $birdingparkVehicle->save(false);
                            }
                        }

                        $animals = $model->master_animal_id;
                        if ($animals) {
                            BirdingParkAnimal::updateAll(['status' => 2], ['birding_park_id' => $id]);
                            foreach ($animals as $animal) {
                                $birdingparkAnimal = new BirdingParkAnimal();
                                $birdingparkAnimal->birding_park_id = $model->birding_park_model->id;
                                $birdingparkAnimal->master_animal_id = $animal;
                                $birdingparkAnimal->save(false);
                            }
                        }

                        $bonusexperience = $model->master_bonus_experience_id;
                        if ($bonusexperience) {
                            BirdingParkBonusExperience::updateAll(['status' => 2], ['birding_park_id' => $id]);
                            foreach ($bonusexperience as $bonus) {
                                $birdingparkBonus = new BirdingParkBonusExperience();
                                $birdingparkBonus->birding_park_id = $model->birding_park_model->id;
                                $birdingparkBonus->master_bonus_experience_id = $bonus;
                                $birdingparkBonus->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->birding_park_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        // return $this->render('view', [
        //     'model' => $model,
        // ]);

        $searchModel = new BirdingParkGallerySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionParkfromfile()
    {

        $model = new BirdingParkForm();
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
                        $model = new BirdingParkForm();
                        $model->scenario = 'create';
                        $model->birding_park_model->title = $value[0];
                        $model->birding_park_model->slug = $value[1];
                        $model->birding_park_model->status = 1;
                        $model->birding_park_model->save(false);
                    }
                    \Yii::$app->getSession()->setFlash('success', $rowcount . ' out of ' . $countsuccess . ' park Successfully Imported');
                    return $this->redirect(['/park/birding/default/index']);
                }
            }
        }


        return $this->render('parkfromfile', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $birdingparkVehicle = BirdingParkVehicle::findAll(['birding_park_id' => $model->id]);
        if (!empty($birdingparkVehicle)) {
            // ParkVehicle::deleteAll(['birding_park_id' => $model->id]);
            foreach ($birdingparkVehicle as $birdingvehicle) {
                $birdingvehicle->status = StatusInterface::STATUS_DELETE;
                $birdingvehicle->save();
            }
        }

        $birdingparkAnimal = BirdingParkAnimal::findAll(['birding_park_id' => $model->id]);
        if (!empty($birdingparkAnimal)) {
            foreach ($birdingparkAnimal as $animal) {
                $animal->status = StatusInterface::STATUS_DELETE;
                $animal->save();
            }
        }

        $birdingparkBonus = BirdingParkBonusExperience::findAll(['birding_park_id' => $model->id]);
        if (!empty($birdingparkBonus)) {
            foreach ($birdingparkBonus as $bonus) {
                $bonus->status = StatusInterface::STATUS_DELETE;
                $bonus->save();
            }
        }

        $model->title = $model->id . '_' . $model->title;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(['/park/birding/default/index']);
    }


    public function actionPublish($id)
    {
        $model = BirdingPark::find()->where(['id' => $id])->limit(1)->one();
        $model->is_published = 1;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    /**
     * Suspend Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionUnpublish($id)
    {
        $model = BirdingPark::find()->where(['id' => $id])->limit(1)->one();
        $model->is_published = 2;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionActive($id)
    {
        $model = BirdingPark::find()->where(['id' => $id])->limit(1)->one();
        $model->status = BirdingPark::STATUS_ACTIVE;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    /**
     * Suspend Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionSuspend($id)
    {
        $model = BirdingPark::find()->where(['id' => $id])->limit(1)->one();
        $model->status = BirdingPark::STATUS_SUSPEND;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }


    protected function findModel($id)
    {
        if (($model = BirdingPark::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
