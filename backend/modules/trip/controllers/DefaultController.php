<?php

namespace backend\modules\trip\controllers;

use common\interfaces\StatusInterface;
use common\models\package\form\PackageForm;
use common\models\package\Package;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $model = new PackageForm();
        $model->status = StatusInterface::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_image = UploadedFile::getInstance($model, 'package_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_model->save(false)) {
                        $model->uploadFile();

                        $package_feature = $model->package_feature;
                        if ($package_feature) {
                            PackageFeature::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_feature as $feature) {
                                $packagefeature = new PackageFeature();
                                $packagefeature->package_id = $model->package_model->id;
                                $packagefeature->feature_id = $feature;
                                $packagefeature->save(false);
                            }
                        }

                        $package_included = $model->package_included;
                        if ($package_included) {
                            PackageIncluded::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_included as $include) {
                                $packageincluded = new PackageIncluded();
                                $packageincluded->package_id = $model->package_model->id;
                                $packageincluded->include_id = $include;
                                $packageincluded->save(false);
                            }
                        }


                        $package_park = $model->package_park;
                        if ($package_park) {
                            PackageIncluded::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_park as $park) {
                                $packagesafaripark = new PackageSafariPark();
                                $packagesafaripark->package_id = $model->package_model->id;
                                $packagesafaripark->park_id = $park;
                                $packagesafaripark->save(false);
                            }
                        }
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->package_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Package Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $package_model = $this->findModel($id);
        $model = new PackageForm($package_model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_image = UploadedFile::getInstance($model, 'package_image');
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_model->save(false)) {
                        $model->uploadFile();

                        $package_feature = $model->package_feature;
                        if ($package_feature) {
                            PackageFeature::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_feature as $feature) {
                                $packagefeature = new PackageFeature();
                                $packagefeature->package_id = $model->package_model->id;
                                $packagefeature->feature_id = $feature;
                                $packagefeature->save(false);
                            }
                        }

                        $package_included = $model->package_included;
                        if ($package_included) {
                            PackageIncluded::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_included as $include) {
                                $packageincluded = new PackageIncluded();
                                $packageincluded->package_id = $model->package_model->id;
                                $packageincluded->include_id = $include;
                                $packageincluded->save(false);
                            }
                        }


                        $package_park = $model->package_park;
                        if ($package_park) {
                            PackageIncluded::deleteAll(['package_id' => $model->package_model->id]);
                            foreach ($package_park as $park) {
                                $packagesafaripark = new PackageSafariPark();
                                $packagesafaripark->package_id = $model->package_model->id;
                                $packagesafaripark->park_id = $park;
                                $packagesafaripark->save(false);
                            }
                        }

                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->package_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Package model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Package the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Package::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
