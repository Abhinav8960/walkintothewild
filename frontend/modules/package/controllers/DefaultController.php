<?php

namespace frontend\modules\package\controllers;

use common\interfaces\StatusInterface;
use common\models\package\form\PackageForm;
use common\models\package\Package;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use Yii;
use yii\web\UploadedFile;
use common\models\package\PackageSafariPark;
use common\models\package\PackageSearch;
use frontend\controllers\FrontendBaseController;
use frontend\models\PackageCommentForm;
use frontend\models\PackageReplyForm;
use yii\web\NotFoundHttpException;

/**
 * DefaultController.
 */
class DefaultController extends FrontendBaseController
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $models = $dataProvider->getModels();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'models' => $models,
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
        $model->scenario = 'create';

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


                        $package_park = $model->package_park;
                        if ($package_park) {
                            PackageSafariPark::deleteAll(['package_id' => $model->package_model->id]);
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
     * Renders the index view for the module
     * @return string
     */
    public function actionView($slug)
    {
        $package = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'package_slug' => $slug])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();


        $model = new PackageCommentForm();
        $replymodel = new PackageReplyForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->comment($package)) {
            Yii::$app->session->setFlash('success', 'Comment Successfully submitted');
            return $this->redirect(\yii\helpers\Url::toRoute(['/package/' . $package->package_slug . '']));
        }


        if ($replymodel->load(Yii::$app->request->post()) && $replymodel->validate() && $replymodel->reply($package)) {
            Yii::$app->session->setFlash('success', 'Reply Successfully submitted');
            return $this->redirect(['/package/' . $package->package_slug . '']);
        }

        return $this->render(
            'view',
            [
                'package' => $package,
                'faqs' => $faqs,
                'model' => $model,
                'replymodel' => $replymodel,
            ]
        );
    }
}
