<?php

namespace backend\modules\park\controllers;

use common\interfaces\StatusInterface;
use common\models\park\form\ParkForm;
use common\models\park\Park;
use common\models\park\ParkAnimal;
use common\models\park\ParkBonusExperience;
use common\models\park\ParkSearch;
use common\models\park\ParkGallerySearch;
use common\models\park\ParkVehicle;
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
        $searchModel = new ParkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new ParkForm();
        $model->status = StatusInterface::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->park_model->save(false)) {
                        $vehicles = $model->vehicle_id;
                        if ($vehicles) {
                            foreach ($vehicles as $vehicle) {
                                $parkVehicle = new ParkVehicle();
                                $parkVehicle->park_id = $model->park_model->id;
                                $parkVehicle->vehicle_id = $vehicle;
                                $parkVehicle->save(false);
                            }
                        }

                        $animals = $model->master_animal_id;
                        if ($animals) {
                            foreach ($animals as $animal) {
                                $parkAnimal = new ParkAnimal();
                                $parkAnimal->park_id = $model->park_model->id;
                                $parkAnimal->master_animal_id = $animal;
                                $parkAnimal->save(false);
                            }
                        }

                        $bonusexperience = $model->master_bonus_experience_id;
                        if ($bonusexperience) {
                            foreach ($bonusexperience as $bonus) {
                                $parkBonus = new ParkBonusExperience();
                                $parkBonus->park_id = $model->park_model->id;
                                $parkBonus->master_bonus_experience_id = $bonus;
                                $parkBonus->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->park_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $park_model = $this->findModel($id);
        $model = new ParkForm($park_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->park_model->save()) {
                        $vehicles = $model->vehicle_id;
                        if ($vehicles) {
                            ParkVehicle::updateAll(['status' => 2], ['park_id' => $id]);
                            foreach ($vehicles as $vehicle) {
                                $parkVehicle = new ParkVehicle();
                                $parkVehicle->park_id = $model->park_model->id;
                                $parkVehicle->vehicle_id = $vehicle;
                                $parkVehicle->save(false);
                            }
                        }

                        $animals = $model->master_animal_id;
                        if ($animals) {
                            ParkAnimal::updateAll(['status' => 2], ['park_id' => $id]);
                            foreach ($animals as $animal) {
                                $parkAnimal = new ParkAnimal();
                                $parkAnimal->park_id = $model->park_model->id;
                                $parkAnimal->master_animal_id = $animal;
                                $parkAnimal->save(false);
                            }
                        }

                        $bonusexperience = $model->master_bonus_experience_id;
                        if ($bonusexperience) {
                            ParkBonusExperience::updateAll(['status' => 2], ['park_id' => $id]);
                            foreach ($bonusexperience as $bonus) {
                                $parkBonus = new ParkBonusExperience();
                                $parkBonus->park_id = $model->park_model->id;
                                $parkBonus->master_bonus_experience_id = $bonus;
                                $parkBonus->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->park_model->loadDefaultValues();
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

        $searchModel = new ParkGallerySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $parkVehicle = ParkVehicle::findAll(['park_id' => $model->id]);
        if (!empty($parkVehicle)) {
            // ParkVehicle::deleteAll(['park_id' => $model->id]);
            foreach ($parkVehicle as $vehicle) {
                $vehicle->status = StatusInterface::STATUS_DELETE;
                $vehicle->save();
            }
        }

        $parkAnimal = ParkAnimal::findAll(['park_id' => $model->id]);
        if (!empty($parkAnimal)) {
            foreach ($parkAnimal as $animal) {
                $animal->status = StatusInterface::STATUS_DELETE;
                $animal->save();
            }
        }

        $parkBonus = ParkBonusExperience::findAll(['park_id' => $model->id]);
        if (!empty($parkBonus)) {
            foreach ($parkBonus as $bonus) {
                $bonus->status = StatusInterface::STATUS_DELETE;
                $bonus->save();
            }
        }

        $model->title = $model->id . '_' . $model->title;
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Park::findOne(['id' => $id, 'status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
