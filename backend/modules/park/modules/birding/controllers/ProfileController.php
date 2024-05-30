<?php

namespace backend\modules\park\modules\birding\controllers;

use common\interfaces\StatusInterface;
use common\models\park\form\BirdingParkAnimalForm;
use common\models\park\form\BirdingParkFloraFaunaForm;
use common\models\park\form\BirdingParkForm;
use common\models\park\form\BirdingParkGalleryForm;
use common\models\park\form\BirdingParkVehicleForm;
use common\models\park\form\BirdingParkZoneForm;
use common\models\park\BirdingPark;
use common\models\park\BirdingParkAccomodation;
use common\models\park\BirdingParkAnimal;
use common\models\park\BirdingParkAnimalSearch;
use common\models\park\BirdingParkBonusExperience;
use common\models\park\BirdingParkFloraFauna;
use common\models\park\BirdingParkFloraFaunaSearch;
use common\models\park\BirdingParkGallery;
use common\models\park\BirdingParkGallerySearch;
use common\models\park\BirdingParkMonth;
use common\models\park\BirdingParkSession;
use common\models\park\BirdingParkVehicle;
use common\models\park\BirdingParkVehicleSearch;
use common\models\park\BirdingParkZone;
use common\models\park\BirdingParkZoneSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Employee model.
 */
class ProfileController extends Controller
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
                        'verifiy' => ['POST'],
                    ],
                ],
            ]
        );
    }



    /**
     * Update Basic Detail
     *
     * @param [type] $birding_park_id
     * @return void
     */
    public function actionIndex($birding_park_id)
    {
        $birding_model = $this->findModel($birding_park_id);
        $model = new BirdingParkForm($birding_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_model->save()) {
                        $model->uploadFile();
                        $birdingaccomodation = $model->accomodation;
                        if ($birdingaccomodation) {
                            BirdingParkAccomodation::updateAll(['status' => 2], ['birding_park_id' => $birding_park_id]);
                            foreach ($birdingaccomodation as $birding_accomodation) {
                                $birdingparkAccomodation = new BirdingParkAccomodation();
                                $birdingparkAccomodation->birding_park_id = $model->birding_park_model->id;
                                $birdingparkAccomodation->master_accomodation_id = $birding_accomodation;
                                $birdingparkAccomodation->save(false);
                            }
                        }

                        $sessions = $model->birding_session;
                        if ($sessions) {
                            BirdingParkSession::updateAll(['status' => 2], ['birding_park_id' => $birding_park_id]);
                            foreach ($sessions as $session) {
                                $birdingparkSession = new BirdingParkSession();
                                $birdingparkSession->birding_park_id = $model->birding_park_model->id;
                                $birdingparkSession->session_id = $session;
                                $birdingparkSession->save(false);
                            }
                        }

                        $months = $model->month;
                        if ($months) {
                            BirdingParkMonth::updateAll(['status' => 2], ['birding_park_id' => $birding_park_id]);

                            foreach ($months as $birding_month) {
                                $birdingparkMonth = new BirdingParkMonth();
                                $birdingparkMonth->birding_park_id = $model->birding_park_model->id;
                                $birdingparkMonth->month_id = $birding_month;
                                $birdingparkMonth->save(false);
                            }
                        }

                        $birdingvehicles = $model->vehicle_id;
                        if ($birdingvehicles) {
                            BirdingParkVehicle::updateAll(['status' => 2], ['birding_park_id' => $birding_park_id]);
                            foreach ($birdingvehicles as $birdingvehicle) {
                                $birdingparkVehicle = new BirdingParkVehicle();
                                $birdingparkVehicle->birding_park_id = $model->birding_park_model->id;
                                $birdingparkVehicle->vehicle_id = $birdingvehicle;
                                $birdingparkVehicle->save(false);
                            }
                        }

                        $animals = $model->master_animal_id;
                        if ($animals) {
                            BirdingParkAnimal::updateAll(['status' => 2], ['birding_park_id' => $birding_park_id]);
                            foreach ($animals as $animal) {
                                $birdingparkAnimal = new BirdingParkAnimal();
                                $birdingparkAnimal->birding_park_id = $model->birding_park_model->id;
                                $birdingparkAnimal->master_animal_id = $animal;
                                $birdingparkAnimal->save(false);
                            }
                        }

                        $bonusexperience = $model->master_bonus_experience_id;
                        if ($bonusexperience) {
                            BirdingParkBonusExperience::updateAll(['status' => 2], ['birding_park_id' => $birding_park_id]);
                            foreach ($bonusexperience as $bonus) {
                                $birdingparkBonus = new BirdingParkBonusExperience();
                                $birdingparkBonus->birding_park_id = $model->birding_park_model->id;
                                $birdingparkBonus->master_bonus_experience_id = $bonus;
                                $birdingparkBonus->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    /**
     * Update How to reach Detail
     *
     * @param [type] $birding_park_id
     * @return void
     */
    public function actionHowToReach($birding_park_id)
    {
        $birding_model = $this->findModel($birding_park_id);
        $model = new BirdingParkForm($birding_model);
        $model->scenario = 'howtoreach';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/how-to-reach?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('howtoreach', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }




    /**
     * Education View
     *
     * @param [type] $birding_park_id
     * @return void
     */
    public function actionGallery($birding_park_id)
    {
        $searchModel = new BirdingParkGallerySearch();
        $searchModel->birding_park_id = $birding_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('gallery', [
            'birding_model' => $this->findModel($birding_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreategallery($birding_park_id)
    {
        $birding_model = $this->findModel($birding_park_id);

        $model = new BirdingParkGalleryForm();
        $model->birding_park_id = $birding_park_id;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_gallery_model->save()) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/gallery?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('creategallery', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionUpdategallery($birding_park_id, $id)
    {
        $birding_model = $this->findModel($birding_park_id);
        $gallery_model = $this->findGalleryModel($id);

        $model = new BirdingParkGalleryForm($gallery_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_gallery_model->save()) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/gallery?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('creategallery', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionDeletegallery($id)
    {
        $model = $this->findGalleryModel($id);
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    /**
     * Education View
     *
     * @param [type] $birding_park_id
     * @return void
     */
    public function actionZone($birding_park_id)
    {
        $searchModel = new BirdingParkZoneSearch();
        $searchModel->birding_park_id = $birding_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('zone', [
            'birding_model' => $this->findModel($birding_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }





    public function actionCreatezone($birding_park_id)
    {
        $birding_model = $this->findModel($birding_park_id);

        $model = new BirdingParkZoneForm();
        $model->birding_park_id = $birding_park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_zone_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/zone?birding_park_id=' . $birding_park_id . '']);
                    }
                } else {
                    print_r($model->errors);
                    die();
                }
            }
        }

        return $this->render('createzone', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionUpdatezone($birding_park_id, $id)
    {
        $birding_model = $this->findModel($birding_park_id);
        $florafauna_model = $this->findZoneModel($id);

        $model = new BirdingParkZoneForm($florafauna_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_zone_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/zone?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createzone', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionDeletezone($id)
    {
        $model = $this->findZoneModel($id);
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }




    /**
     * Education View
     *
     * @param [type] $birding_park_id
     * @return void
     */
    public function actionVehicle($birding_park_id)
    {
        $searchModel = new BirdingParkVehicleSearch();
        $searchModel->birding_park_id = $birding_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('vehicle', [
            'birding_model' => $this->findModel($birding_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreatevehicle($birding_park_id)
    {
        $birding_model = $this->findModel($birding_park_id);

        $model = new BirdingParkVehicleForm();
        $model->birding_park_id = $birding_park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_vehicle_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/vehicle?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createvehicle', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionUpdatevehicle($birding_park_id, $id)
    {
        $birding_model = $this->findModel($birding_park_id);
        $vehicle_model = $this->findVehicleModel($id);

        $model = new BirdingParkVehicleForm($vehicle_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_vehicle_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/vehicle?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createvehicle', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionDeletevehicle($id)
    {
        $model = $this->findVehicleModel($id);
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }




    /**
     * Education View
     *
     * @param [type] $birding_park_id
     * @return void
     */
    public function actionMap($birding_park_id)
    {
        return $this->render('map', [
            'model' => $this->findModel($birding_park_id)
        ]);
    }


    /**
     * Education View
     *
     * @param [type] $birding_park_id
     * @return void
     */
    public function actionAnimal($birding_park_id)
    {
        $searchModel = new BirdingParkAnimalSearch();
        $searchModel->birding_park_id = $birding_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('animal', [
            'birding_model' => $this->findModel($birding_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateanimal($birding_park_id)
    {
        $birding_model = $this->findModel($birding_park_id);

        $model = new BirdingParkAnimalForm();
        $model->birding_park_id = $birding_park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_animal_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/animal?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createanimal', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionUpdateanimal($birding_park_id, $id)
    {
        $birding_model = $this->findModel($birding_park_id);
        $animal_model = $this->findAnimalModel($id);

        $model = new BirdingParkAnimalForm($animal_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_animal_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/animal?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createanimal', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionDeleteanimal($id)
    {
        $model = $this->findAnimalModel($id);
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }



    /**
     * Education View
     *
     * @param [type] $birding_park_id
     * @return void
     */
    public function actionFloraFauna($birding_park_id)
    {
        $searchModel = new BirdingParkFloraFaunaSearch();
        $searchModel->birding_park_id = $birding_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('florafauna', [
            'birding_model' => $this->findModel($birding_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionCreateflorafauna($birding_park_id)
    {
        $birding_model = $this->findModel($birding_park_id);

        $model = new BirdingParkFloraFaunaForm();
        $model->birding_park_id = $birding_park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_florafauna_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/flora-fauna?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createflorafauna', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionUpdateflorafauna($birding_park_id, $id)
    {
        $birding_model = $this->findModel($birding_park_id);
        $florafauna_model = $this->findFlorafaunaModel($id);

        $model = new BirdingParkFloraFaunaForm($florafauna_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->birding_park_florafauna_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/birding/profile/flora-fauna?birding_park_id=' . $birding_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createflorafauna', [
            'model' => $model,
            'birding_model' => $birding_model
        ]);
    }


    public function actionDeleteflorafauna($id)
    {
        $model = $this->findFlorafaunaModel($id);
        $model->status = StatusInterface::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $birding_park_id ID
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($birding_park_id)
    {
        if (($model = BirdingPark::find()->where(['status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND], 'id' => $birding_park_id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findGalleryModel($id)
    {
        if (($model = BirdingParkGallery::find()->where(['status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findAnimalModel($id)
    {
        if (($model = BirdingParkAnimal::find()->where(['status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findVehicleModel($id)
    {
        if (($model = BirdingParkVehicle::find()->where(['status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findFlorafaunaModel($id)
    {
        if (($model = BirdingParkFloraFauna::find()->where(['status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findZoneModel($id)
    {
        if (($model = BirdingParkZone::find()->where(['status' => [StatusInterface::STATUS_ACTIVE, StatusInterface::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
