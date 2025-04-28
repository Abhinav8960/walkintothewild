<?php

namespace backend\modules\package\controllers;

use common\interfaces\StatusInterface;
use common\models\package\form\PackageVersionForm;
use common\models\package\Package;
use common\models\package\PackageVersion;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageVersionSearch;
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
        $searchModel = new PackageVersionSearch();
        $searchModel->report_days = 'all';
        $searchModel->status = 1;
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
    // public function actionCreate()
    // {
    //     $model = new PackageVersionForm();
    //     $model->status = StatusInterface::STATUS_ACTIVE;
    //     $model->scenario = 'create';

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             $model->package_image = UploadedFile::getInstance($model, 'package_image');
    //             $model->package_banner_image = UploadedFile::getInstance($model, 'package_banner_image');
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->package_version_model->save()) {
    //                     $model->uploadFile();

    //                     $package_feature = $model->package_feature;
    //                     if ($package_feature) {
    //                         PackageFeature::deleteAll(['package_id' => $model->package_version_model->id]);
    //                         foreach ($package_feature as $feature) {
    //                             $packagefeature = new PackageFeature();
    //                             $packagefeature->package_id = $model->package_version_model->id;
    //                             $packagefeature->feature_id = $feature;
    //                             $packagefeature->save(false);
    //                         }
    //                     }


    //                     $package_park = $model->package_park;
    //                     if ($package_park) {
    //                         PackageSafariPark::deleteAll(['package_id' => $model->package_version_model->id]);
    //                         foreach ($package_park as $park) {
    //                             $packagesafaripark = new PackageSafariPark();
    //                             $packagesafaripark->package_id = $model->package_version_model->id;
    //                             $packagesafaripark->park_id = $park;
    //                             $packagesafaripark->save(false);
    //                         }
    //                     }
    //                     \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
    //                     return $this->redirect(['index']);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->package_version_model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }


    /**
     * Updates an existing Package Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $package_version_model = $this->findModel($id);
    //     $model = new PackageVersionForm($package_version_model);
    //     $model->scenario = 'update';

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post())) {
    //             $model->package_image = UploadedFile::getInstance($model, 'package_image');
    //             if ($model->validate()) {
    //                 $model->initializeForm();
    //                 if ($model->package_version_model->save(false)) {
    //                     $model->uploadFile();

    //                     $package_feature = $model->package_feature;
    //                     if ($package_feature) {
    //                         PackageFeature::deleteAll(['package_id' => $model->package_version_model->id]);
    //                         foreach ($package_feature as $feature) {
    //                             $packagefeature = new PackageFeature();
    //                             $packagefeature->package_id = $model->package_version_model->id;
    //                             $packagefeature->feature_id = $feature;
    //                             $packagefeature->save(false);
    //                         }
    //                     }

    //                     $package_included = $model->package_included;
    //                     if ($package_included) {
    //                         PackageIncluded::deleteAll(['package_id' => $model->package_version_model->id]);
    //                         foreach ($package_included as $include) {
    //                             $packageincluded = new PackageIncluded();
    //                             $packageincluded->package_id = $model->package_version_model->id;
    //                             $packageincluded->include_id = $include;
    //                             $packageincluded->save(false);
    //                         }
    //                     }


    //                     $package_park = $model->package_park;
    //                     if ($package_park) {
    //                         PackageSafariPark::deleteAll(['package_id' => $model->package_version_model->id]);
    //                         foreach ($package_park as $park) {
    //                             $packagesafaripark = new PackageSafariPark();
    //                             $packagesafaripark->package_id = $model->package_version_model->id;
    //                             $packagesafaripark->park_id = $park;
    //                             $packagesafaripark->save(false);
    //                         }
    //                     }

    //                     \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
    //                     return $this->redirect(['index']);
    //                 }
    //             }
    //         }
    //     } else {
    //         $model->package_version_model->loadDefaultValues();
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }


    public function actionView($package_id)
    {
        $model = $this->findModel($package_id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionActive($id)
    {
        $model = Package::find()->where(['id' => $id])->limit(1)->one();
        $model->status = PackageVersion::APPROVED_AND_LIVE_STATUS;
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
        $model = Package::find()->where(['id' => $id])->limit(1)->one();
        $model->status = Package::STATUS_ACTIVE;
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
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

    public function actionPublishOnApi($id)
    {
        $model = Package::find()->where(['id' => $id])->limit(1)->one();
        if ($model) {
            $model->is_published_on_api = !$model->is_published_on_api;
            $model->save(false);
            \Yii::$app->session->setFlash('success', 'Api Publish change Successfully');
        } else {
            \Yii::$app->session->setFlash('error', 'Facing technical problem Successfully');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPublishOnWeb($id)
    {
        $model = Package::find()->where(['id' => $id])->limit(1)->one();
        if ($model) {
            $model->is_published_on_web = !$model->is_published_on_web;
            $model->save(false);
            \Yii::$app->session->setFlash('success', 'Web Publish change Successfully');
        } else {
            \Yii::$app->session->setFlash('error', 'Facing technical problem Successfully');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
