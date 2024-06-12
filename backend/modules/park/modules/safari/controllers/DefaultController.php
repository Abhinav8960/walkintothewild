<?php

namespace backend\modules\park\modules\safari\controllers;

use common\interfaces\StatusInterface;
use common\models\GeneralModel;
use common\models\park\form\SafariParkForm;
use common\models\park\ParkAnimal;
use common\models\park\ParkVehicle;
use common\models\park\SafariParkBonusExperience;
use common\models\park\SafariPark;
use common\models\park\SafariParkAccomodation;
use common\models\park\SafariParkAnimal;
use common\models\park\SafariParkGallerySearch;
use common\models\park\SafariParkMonth;
use common\models\park\SafariParkRareAnimal;
use common\models\park\SafariParkSearch;
use common\models\park\SafariParkSession;
use common\models\park\SafariParkVehicle;
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
        $searchModel = new SafariParkSearch();
        $searchModel->status = SafariPark::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new SafariParkForm();
        $model->status = StatusInterface::STATUS_ACTIVE;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_model->save(false)) {
                        $model->uploadFile();
                        $safariaccomodation = $model->accomodation;
                        if ($safariaccomodation) {
                            foreach ($safariaccomodation as $safari_accomodation) {
                                $safariparkAccomodation = new SafariParkAccomodation();
                                $safariparkAccomodation->safari_park_id = $model->safari_park_model->id;
                                $safariparkAccomodation->master_accomodation_id = $safari_accomodation;
                                $safariparkAccomodation->save(false);
                            }
                        }

                        $sessions = $model->safari_session;
                        if ($sessions) {
                            foreach ($sessions as $session) {
                                $safariparkSession = new SafariParkSession();
                                $safariparkSession->safari_park_id = $model->safari_park_model->id;
                                $safariparkSession->session_id = $session;
                                $safariparkSession->save(false);
                            }
                        }

                        $months = $model->month;
                        if ($months) {
                            foreach ($months as $safari_month) {
                                $safariparkMonth = new SafariParkMonth();
                                $safariparkMonth->safari_park_id = $model->safari_park_model->id;
                                $safariparkMonth->month_id = $safari_month;
                                $safariparkMonth->save(false);
                            }
                        }

                        $bonusexperience = $model->master_bonus_experience_id;
                        if ($bonusexperience) {
                            foreach ($bonusexperience as $bonus) {
                                $safariparkBonus = new SafariParkBonusExperience();
                                $safariparkBonus->safari_park_id = $model->safari_park_model->id;
                                $safariparkBonus->master_bonus_experience_id = $bonus;
                                $safariparkBonus->save(false);
                            }
                        }


                        $vehicles = $model->vehicle_id;
                        if ($vehicles) {
                            SafariParkVehicle::deleteAll(['safari_park_id' => $model->id]);

                            foreach ($vehicles as $vehicle) {
                                $parkVehicle = new SafariParkVehicle();
                                $parkVehicle->safari_park_id = $model->safari_park_model->id;
                                $parkVehicle->vehicle_id = $vehicle;
                                $parkVehicle->save(false);
                            }
                        }

                        $animals = $model->master_animal_id;
                        if ($animals) {
                            foreach ($animals as $animal) {
                                $parkAnimal = new SafariParkAnimal();
                                $parkAnimal->safari_park_id = $model->safari_park_model->id;
                                $parkAnimal->master_animal_id = $animal;
                                if ($animal) {
                                    $parkAnimal->animal_name =  GeneralModel::animaloption()[$animal];
                                }

                                $parkAnimal->save(false);
                            }
                        }

                        $rare_animals = $model->master_rare_animal_id;
                        if ($rare_animals) {
                            foreach ($rare_animals as $rare_animal) {
                                $parkrareAnimal = new SafariParkRareAnimal();
                                $parkrareAnimal->safari_park_id = $model->safari_park_model->id;
                                $parkrareAnimal->master_rare_animal_id = $rare_animal;
                                if ($rare_animal) {
                                    $parkrareAnimal->animal_name =  GeneralModel::rareanimaloption()[$rare_animal];
                                }
                                $parkrareAnimal->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safari_park_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $safari_park_model = $this->findModel($id);
        $model = new SafariParkForm($safari_park_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_model->save()) {
                        $model->uploadFile();
                        $safariaccomodation = $model->accomodation;
                        if ($safariaccomodation) {
                            SafariParkAccomodation::updateAll(['status' => 2], ['safari_park_id' => $id]);
                            foreach ($safariaccomodation as $safari_accomodation) {
                                $safariparkAccomodation = new SafariParkAccomodation();
                                $safariparkAccomodation->safari_park_id = $model->safari_park_model->id;
                                $safariparkAccomodation->master_accomodation_id = $safari_accomodation;
                                $safariparkAccomodation->save(false);
                            }
                        }

                        $sessions = $model->safari_session;
                        if ($sessions) {
                            SafariParkSession::updateAll(['status' => 2], ['safari_park_id' => $id]);
                            foreach ($sessions as $session) {
                                $safariparkSession = new SafariParkSession();
                                $safariparkSession->safari_park_id = $model->safari_park_model->id;
                                $safariparkSession->session_id = $session;
                                $safariparkSession->save(false);
                            }
                        }

                        $months = $model->month;
                        if ($months) {
                            SafariParkMonth::updateAll(['status' => 2], ['safari_park_id' => $id]);

                            foreach ($months as $safari_month) {
                                $safariparkMonth = new SafariParkMonth();
                                $safariparkMonth->safari_park_id = $model->safari_park_model->id;
                                $safariparkMonth->month_id = $safari_month;
                                $safariparkMonth->save(false);
                            }
                        }

                        $safarivehicles = $model->vehicle_id;
                        if ($safarivehicles) {
                            // SafariParkVehicle::updateAll(['status' => 2], ['safari_park_id' => $id]);
                            SafariParkVehicle::deleteAll(['safari_park_id' => $model->id]);

                            foreach ($safarivehicles as $safarivehicle) {
                                $safariparkVehicle = new SafariParkVehicle();
                                $safariparkVehicle->safari_park_id = $model->safari_park_model->id;
                                $safariparkVehicle->vehicle_id = $safarivehicle;
                                $safariparkVehicle->save(false);
                            }
                        }

                        $animals = $model->master_animal_id;
                        if ($animals) {
                            SafariParkAnimal::updateAll(['status' => 2], ['safari_park_id' => $id]);
                            foreach ($animals as $animal) {
                                $safariparkAnimal = new SafariParkAnimal();
                                $safariparkAnimal->safari_park_id = $model->safari_park_model->id;
                                $safariparkAnimal->master_animal_id = $animal;
                                $safariparkAnimal->save(false);
                            }
                        }


                        $rare_animals = $model->master_rare_animal_id;
                        if ($rare_animals) {
                            SafariParkRareAnimal::updateAll(['status' => 2], ['safari_park_id' => $id]);
                            foreach ($rare_animals as $rare_animal) {
                                $parkrareAnimal = new SafariParkRareAnimal();
                                $parkrareAnimal->safari_park_id = $model->safari_park_model->id;
                                $parkrareAnimal->master_rare_animal_id = $rare_animal;
                                if ($rare_animal) {
                                    $parkrareAnimal->animal_name =  GeneralModel::rareanimaloption()[$rare_animal];
                                }

                                $parkrareAnimal->save(false);
                            }
                        }


                        $bonusexperience = $model->master_bonus_experience_id;
                        if ($bonusexperience) {
                            SafariParkBonusExperience::updateAll(['status' => 2], ['safari_park_id' => $id]);
                            foreach ($bonusexperience as $bonus) {
                                $safariparkBonus = new SafariParkBonusExperience();
                                $safariparkBonus->safari_park_id = $model->safari_park_model->id;
                                $safariparkBonus->master_bonus_experience_id = $bonus;
                                $safariparkBonus->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->safari_park_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionView($safari_park_id)
    {
        $model = $this->findModel($safari_park_id);
        $first_month = SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->limit(1)->orderBy(['month_id' => SORT_ASC])->one();
        $last_month = SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->limit(1)->orderBy(['month_id' => SORT_DESC])->one();

        return $this->render('view', [
            'model' => $model,
            'first_month' => $first_month,
            'last_month' => $last_month,
        ]);
    }


    public function actionParkfromfile()
    {

        $model = new SafariParkForm();
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
                        $model = new SafariParkForm();
                        $model->scenario = 'create';
                        $model->safari_park_model->title = $value[0];
                        $model->safari_park_model->slug = $value[1];
                        $model->safari_park_model->status = 1;
                        $model->safari_park_model->save(false);
                    }
                    \Yii::$app->getSession()->setFlash('success', $rowcount . ' out of ' . $countsuccess . ' park Successfully Imported');
                    return $this->redirect(['/park/safari/default/index']);
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

        $safariparkVehicle = SafariParkVehicle::findAll(['safari_park_id' => $model->id]);
        if (!empty($safariparkVehicle)) {
            // ParkVehicle::deleteAll(['safari_park_id' => $model->id]);
            foreach ($safariparkVehicle as $safarivehicle) {
                $safarivehicle->status = StatusInterface::STATUS_DELETE;
                $safarivehicle->save();
            }
        }

        $safariparkAnimal = SafariParkAnimal::findAll(['safari_park_id' => $model->id]);
        if (!empty($safariparkAnimal)) {
            foreach ($safariparkAnimal as $animal) {
                $animal->status = StatusInterface::STATUS_DELETE;
                $animal->save();
            }
        }

        $safariparkBonus = SafariParkBonusExperience::findAll(['safari_park_id' => $model->id]);
        if (!empty($safariparkBonus)) {
            foreach ($safariparkBonus as $bonus) {
                $bonus->status = StatusInterface::STATUS_DELETE;
                $bonus->save();
            }
        }

        $model->title = $model->id . '_' . $model->title;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(['/park/safari/default/index']);
    }


    public function actionPublish($id)
    {
        $model = SafariPark::find()->where(['id' => $id])->limit(1)->one();
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
        $model = SafariPark::find()->where(['id' => $id])->limit(1)->one();
        $model->is_published = 2;
        $model->save(false);
        return $this->reSafariParkdirect(\Yii::$app->request->referrer);
    }


    public function actionActive($id)
    {
        $model = SafariPark::find()->where(['id' => $id])->limit(1)->one();
        $model->status = SafariPark::STATUS_ACTIVE;
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
        $model = SafariPark::find()->where(['id' => $id])->limit(1)->one();
        $model->status = SafariPark::STATUS_SUSPEND;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = SafariPark::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
