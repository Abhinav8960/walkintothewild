<?php

namespace backend\modules\park\modules\safari\controllers;


use common\models\GeneralModel;
use common\models\master\animal\MasterAnimal;
use common\models\operator\SafariOperatorPark;
use common\models\park\form\ParkStayCategoryForm;
use common\models\park\form\SafariParkAnimalForm;
use common\models\park\form\SafariParkFloraFaunaForm;
use common\models\park\form\SafariParkForm;
use common\models\park\form\SafariParkGalleryForm;
use common\models\park\form\SafariParkVehicleForm;
use common\models\park\form\SafariParkZoneForm;
use common\models\park\ParkStayCategory;
use common\models\park\ParkStayCategorySearch;
use common\models\park\ParkAnimal;
use common\models\park\ParkVehicle;
use common\models\park\SafariPark;
use common\models\park\SafariParkAccomodation;
use common\models\park\SafariParkAnimal;
use common\models\park\SafariParkAnimalSearch;
use common\models\park\SafariParkBonusExperience;
use common\models\park\SafariParkFloraFauna;
use common\models\park\SafariParkFloraFaunaSearch;
use common\models\park\SafariParkGallery;
use common\models\park\SafariParkGallerySearch;
use common\models\park\SafariParkMonth;
use common\models\park\SafariParkRatingSearch;
use common\models\park\SafariParkSession;
use common\models\park\SafariParkVehicle;
use common\models\park\SafariParkVehicleSearch;
use common\models\park\SafariParkZone;
use common\models\park\SafariParkZoneSearch;
use common\models\suggestions\SafariSuggestions;
use common\models\suggestions\SafariSuggestionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * ProfileController implements the CRUD actions for Employee model.
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
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionIndex($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $model = new SafariParkForm($safari_model);
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
                        SafariParkAccomodation::updateAll(['status' => SafariParkAccomodation::STATUS_SUSPEND], ['safari_park_id' => $safari_park_id]);
                        if ($safariaccomodation) {
                            foreach ($safariaccomodation as $safari_accomodation) {
                                $safariparkAccomodation = new SafariParkAccomodation();
                                $safariparkAccomodation->safari_park_id = $model->safari_park_model->id;
                                $safariparkAccomodation->master_accomodation_id = $safari_accomodation;
                                $safariparkAccomodation->save(false);
                            }
                        }

                        $sessions = $model->safari_session;
                        SafariParkSession::updateAll(['status' => SafariParkSession::STATUS_SUSPEND], ['safari_park_id' => $safari_park_id]);
                        if ($sessions) {
                            foreach ($sessions as $session) {
                                $safariparkSession = new SafariParkSession();
                                $safariparkSession->safari_park_id = $model->safari_park_model->id;
                                $safariparkSession->session_id = $session;
                                $safariparkSession->save(false);
                            }
                        }

                        $months = $model->month;
                        SafariParkMonth::updateAll(['status' => SafariParkMonth::STATUS_SUSPEND], ['safari_park_id' => $safari_park_id]);
                        if ($months) {

                            foreach ($months as $safari_month) {
                                $safariparkMonth = new SafariParkMonth();
                                $safariparkMonth->safari_park_id = $model->safari_park_model->id;
                                $safariparkMonth->month_id = $safari_month;
                                $safariparkMonth->save(false);
                            }
                        }


                        $bonusexperience = $model->master_bonus_experience_id;
                        SafariParkBonusExperience::updateAll(['status' => SafariParkBonusExperience::STATUS_SUSPEND], ['safari_park_id' => $safari_park_id]);
                        if ($bonusexperience) {
                            foreach ($bonusexperience as $bonus) {
                                $safariparkBonus = new SafariParkBonusExperience();
                                $safariparkBonus->safari_park_id = $model->safari_park_model->id;
                                $safariparkBonus->master_bonus_experience_id = $bonus;
                                $safariparkBonus->save(false);
                            }
                        }


                        $vehicles = $model->vehicle_id;
                        SafariParkVehicle::deleteAll(['safari_park_id' => $model->safari_park_model->id]);
                        if ($vehicles) {
                            // SafariParkVehicle::updateAll(['status' => 2], ['safari_park_id' => $safari_park_id]);

                            foreach ($vehicles as $vehicle) {
                                $parkVehicle = new SafariParkVehicle();
                                $parkVehicle->safari_park_id = $model->safari_park_model->id;
                                $parkVehicle->vehicle_id = $vehicle;
                                $parkVehicle->save(false);
                            }
                        }

                        $animals = $model->master_animal_id;
                        SafariParkAnimal::updateAll(['status' => SafariParkAnimal::STATUS_SUSPEND], ['safari_park_id' => $safari_park_id]);
                        if ($animals) {
                            foreach ($animals as $animal) {
                                $parkAnimal = new SafariParkAnimal();
                                $parkAnimal->safari_park_id = $model->safari_park_model->id;
                                $parkAnimal->master_animal_id = $animal;
                                $parkAnimal->save(false);
                            }
                        }


                        $rare_animals = $model->master_rare_animal_id;
                        if ($rare_animals) {
                            foreach ($rare_animals as $rare_animal) {
                                $parkrareAnimal = new SafariParkAnimal();
                                $parkrareAnimal->safari_park_id = $model->safari_park_model->id;
                                $parkrareAnimal->master_animal_id = $rare_animal;
                                $parkrareAnimal->save(false);
                            }
                        }
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    /**
     * Update Basic Detail
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionMedia($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $model = new SafariParkForm($safari_model);
        $model->scenario = 'media';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->logo = UploadedFile::getInstance($model, 'logo');
                $model->feature_image = UploadedFile::getInstance($model, 'feature_image');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_model->save()) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/media?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('media', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }

    /**
     * Update Basic Detail
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionFloraFauna($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $model = new SafariParkForm($safari_model);
        $model->scenario = 'florafauna';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/flora-fauna?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('_flora_fauna', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }



    /**
     * Update How to reach Detail
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionHowToReach($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $model = new SafariParkForm($safari_model);
        $model->scenario = 'howtoreach';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/how-to-reach?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('howtoreach', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }




    /**
     * Gallery View
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionGallery($safari_park_id)
    {
        $searchModel = new SafariParkGallerySearch();
        $searchModel->safari_park_id = $safari_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('gallery', [
            'safari_model' => $this->findModel($safari_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreategallery($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);

        $model = new SafariParkGalleryForm();
        $model->safari_park_id = $safari_park_id;
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_gallery_model->save()) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/gallery?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('creategallery', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    public function actionUpdategallery($safari_park_id, $id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $gallery_model = $this->findGalleryModel($id);

        $model = new SafariParkGalleryForm($gallery_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');

                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_gallery_model->save()) {
                        $model->uploadFile();
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/gallery?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('creategallery', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    public function actionDeletegallery($id)
    {
        $model = $this->findGalleryModel($id);
        $model->status = SafariParkGallery::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    /**
     * Zone View
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionZone($safari_park_id)
    {
        $searchModel = new SafariParkZoneSearch();
        $searchModel->safari_park_id = $safari_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('zone', [
            'safari_model' => $this->findModel($safari_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }





    public function actionCreatezone($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);

        $model = new SafariParkZoneForm();
        $model->safari_park_id = $safari_park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_zone_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/zone?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createzone', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    public function actionUpdatezone($safari_park_id, $id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $florafauna_model = $this->findZoneModel($id);

        $model = new SafariParkZoneForm($florafauna_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_zone_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/zone?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createzone', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    public function actionDeletezone($id)
    {
        $model = $this->findZoneModel($id);
        $model->zone_name = $model->id . '_' . $model->zone_name;
        $model->status = SafariParkZone::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }




    /**
     * Vehicle View
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionVehicle($safari_park_id)
    {
        $searchModel = new SafariParkVehicleSearch();
        $searchModel->safari_park_id = $safari_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('vehicle', [
            'safari_model' => $this->findModel($safari_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreatevehicle($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);

        $model = new SafariParkVehicleForm();
        $model->safari_park_id = $safari_park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_vehicle_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/vehicle?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createvehicle', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    public function actionUpdatevehicle($safari_park_id, $id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $vehicle_model = $this->findVehicleModel($id);

        $model = new SafariParkVehicleForm($vehicle_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_vehicle_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/vehicle?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createvehicle', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    public function actionDeletevehicle($id)
    {
        $model = $this->findVehicleModel($id);
        $model->status = SafariParkVehicle::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }




    /**
     * Map View
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionMap($safari_park_id)
    {
        $map_safari_model = $this->findModel($safari_park_id);
        $model = new SafariParkForm($map_safari_model);
        $model->scenario = 'map';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/map?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('map', [
            'map_model' => $this->findModel($safari_park_id),
            'model' => $model
        ]);
    }

    /**
     * Meta View
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionMeta($safari_park_id)
    {
        $map_safari_model = $this->findModel($safari_park_id);
        $model = new SafariParkForm($map_safari_model);
        $model->scenario = 'meta';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/meta?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('_meta', [
            'meta_model' => $this->findModel($safari_park_id),
            'model' => $model
        ]);
    }

    /**
     * Animal View
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionAnimal($safari_park_id)
    {
        $searchModel = new SafariParkAnimalSearch();
        $searchModel->safari_park_id = $safari_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('animal', [
            'safari_model' => $this->findModel($safari_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateanimal($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);

        $model = new SafariParkAnimalForm();
        $model->safari_park_id = $safari_park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_animal_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/animal?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createanimal', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    public function actionUpdateanimal($safari_park_id, $id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $animal_model = $this->findAnimalModel($id);

        $model = new SafariParkAnimalForm($animal_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->safari_park_animal_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['/park/safari/profile/animal?safari_park_id=' . $safari_park_id . '']);
                    }
                }
            }
        }

        return $this->render('createanimal', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }


    public function actionDeleteanimal($id)
    {
        $model = $this->findAnimalModel($id);
        $model->status = SafariParkAnimal::STATUS_DELETE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }



    /**
     * Suggestion View
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionSuggestions($safari_park_id)
    {
        $searchModel = new SafariSuggestionsSearch();
        $searchModel->park_id = $safari_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('suggestions', [
            'safari_model' => $this->findModel($safari_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Suggestion View
     *
     * @param [type] $safari_park_id
     * @return void
     */
    public function actionReviews($safari_park_id)
    {
        $searchModel = new SafariParkRatingSearch();
        $searchModel->safari_park_id = $safari_park_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('reviews', [
            'safari_model' => $this->findModel($safari_park_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionDisapprove($id)
    {
        $model = SafariSuggestions::find()->where(['id' => $id])->limit(1)->one();
        $model->is_approved = 0;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Suggestion disapprove Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionApprove($id)
    {
        $model = SafariSuggestions::find()->where(['id' => $id])->limit(1)->one();
        $model->is_approved = SafariSuggestions::STATUS_ACTIVE;
        $model->save();
        \Yii::$app->session->setFlash('success', 'Suggestion approved Successfully');
        return $this->redirect(\Yii::$app->request->referrer);
    }


    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $safari_park_id ID
     * @return SafariPark the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($safari_park_id)
    {
        if (($model = SafariPark::find()->where(['status' => [SafariPark::STATUS_ACTIVE, SafariPark::STATUS_SUSPEND], 'id' => $safari_park_id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findGalleryModel($id)
    {
        if (($model = SafariParkGallery::find()->where(['status' => [SafariParkGallery::STATUS_ACTIVE, SafariParkGallery::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findAnimalModel($id)
    {
        if (($model = SafariParkAnimal::find()->where(['status' => [SafariParkAnimal::STATUS_ACTIVE, SafariParkAnimal::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findVehicleModel($id)
    {
        if (($model = SafariParkVehicle::find()->where(['status' => [SafariParkVehicle::STATUS_ACTIVE, SafariParkVehicle::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findFlorafaunaModel($id)
    {
        if (($model = SafariParkFloraFauna::find()->where(['status' => [SafariParkFloraFauna::STATUS_ACTIVE, SafariParkFloraFauna::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findZoneModel($id)
    {
        if (($model = SafariParkZone::find()->where(['status' => [SafariParkZone::STATUS_ACTIVE, SafariParkZone::STATUS_SUSPEND], 'id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionOperatorlist($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);
        // $operator_list = SafariOperatorPark::find()->where(['park_id' => $safari_park_id, 'safari_operator_park.status' => SafariOperatorPark::STATUS_ACTIVE])->joinWith(['operator'])->andWhere(['safari_operator.category_id' => 1]);
        $operator_list = SafariOperatorPark::find()
            ->where(['safari_operator_park.park_id' => $safari_park_id, 'safari_operator_park.status' => SafariOperatorPark::STATUS_ACTIVE])
            ->joinWith(['operator' => function ($query) {
                $query->where(['safari_operator.category_id' => 1, 'safari_operator.status' => 1]);
            }]);
        $dataProvider = new ActiveDataProvider([
            'query' => $operator_list,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('_operator_list', ['safari_model' => $safari_model, 'dataProvider' => $dataProvider]);
    }

    public function actionShowoperatorfront($id)
    {
        $safari_operator_park_model = SafariOperatorPark::find()->where(['id' => $id])->limit(1)->one();

        if ($safari_operator_park_model) {
            if ($safari_operator_park_model->show_in_front == 1) {
                $safari_operator_park_model->show_in_front = 0;
                $safari_operator_park_model->save();
                \Yii::$app->getSession()->setFlash('success', 'Remove from front Successfully!!!');
            } else {

                $safari_operator_park_model->show_in_front = 1;
                $safari_operator_park_model->save();
                \Yii::$app->getSession()->setFlash('success', 'Add in front Successfully!!!');
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionParkStayList($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);
        $searchModel = new ParkStayCategorySearch();
        $searchModel->safari_park_id = $safari_park_id;
        $searchModel->status = ParkStayCategory::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('park_stay_category', [
            'safari_model' => $safari_model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddParkStay($safari_park_id)
    {
        $safari_model = $this->findModel($safari_park_id);

        $model = new ParkStayCategoryForm();
        $model->safari_park_id = $safari_park_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->park_stay_categories) {
                        foreach ($model->park_stay_categories as $stay) {
                            $park_stay_category = new ParkStayCategory();
                            $park_stay_category->safari_park_id = $model->safari_park_id;
                            $park_stay_category->meta_stay_category_id = $stay;
                            $park_stay_category->save();
                        }
                    }

                    \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                    return $this->redirect(Url::toRoute(['/park/safari/profile/park-stay-list', 'safari_park_id' => $safari_park_id]));
                }
            }
        }

        return $this->renderAjax('_park_stay_category_form', [
            'model' => $model,
            'safari_model' => $safari_model
        ]);
    }

    public function actionRemoveAccomodationCategory($safari_park_id, $id)
    {
        $park_accomodation_category_model = ParkStayCategory::find()->where(['id' => $id, 'safari_park_id' => $safari_park_id])->limit(1)->one();
        if (!$park_accomodation_category_model) {
            \Yii::$app->session->setFlash('success', 'Not Found!!!');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $park_accomodation_category_model->status = ParkStayCategory::STATUS_SUSPEND;
        if ($park_accomodation_category_model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Remove Successfully!!!');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
}
