<?php

namespace backend\modules\package\controllers;

use common\interfaces\StatusInterface;
use common\models\package\form\PackageDeleteForm;
use common\models\package\form\PackageDiscountForm;
use common\models\package\form\PackageVersionForm;
use common\models\package\Package;
use common\models\package\PackageVersion;
use common\models\package\PackageComment;
use common\models\package\PackageCommentReport;
use common\models\package\PackageCommentSearch;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageFeature;
use common\models\package\PackageIncluded;
use common\models\package\PackageSafariPark;
use common\models\package\PackageVersionSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PreviewController.
 */
class PreviewController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($id)
    {
        $package = Package::find()->where(['id' => $id, 'status' => Package::STATUS_ACTIVE])->limit(1)->one();
        if (empty($package)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $package->id;
        $searchModel->version = $package->live_version;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        $commentsearchModel = new PackageCommentSearch();
        $commentsearchModel->package_id = $package->id;
        $commentsearchModel->version = $package->live_version;
        $commentProvider = $commentsearchModel->listingsearch($this->request->queryParams);
        $commentProvider->query->andWhere(['parent_id' => null]);

        return $this->render(
            'view',
            [
                'package' => $package,
                'faqs' => $faqs,
                'commentsearchModel' => $commentsearchModel,
                'commentProvider' => $commentProvider,
            ]
        );
    }


    public function actionUpdate($id)
    {
        $package_version_model = Package::find()->where(['status' => Package::STATUS_ACTIVE, 'id' => $id])->limit(1)->one();
        if (empty($package_version_model)) {
            return $this->redirect(['/package']);
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_version_model->popular_package = $model->popular_package;
                if ($model->package_version_model->save(false)) {
                    \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                    return $this->redirect(['index', 'id' => $package_version_model->id]);
                }
            }
        } else {
            $model->package_version_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'package_version_model' => $package_version_model,
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

    public function actionReplyview($id)
    {
        $review = PackageComment::find()->where(['parent_id' => $id]);
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>  $review,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('_replyview', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFlagview($id)
    {
        $review = PackageCommentReport::find()->where(['package_comment_id' => $id]);
        if (empty($review)) {
            \Yii::$app->session->setFlash('error', 'Invalid request');
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>  $review,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderAjax('_flagview', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        $package_delete_model = Package::find()->where(['id' => $id])->limit(1)->one();
        $model = new PackageDeleteForm($package_delete_model);
        $model->status = -1;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_delete_model->save(false)) {
                        \Yii::$app->session->setFlash('success', 'Successfully Deleted');
                        return $this->redirect(['/package/default/index']);
                    }
                }
            }
        } else {
            $model->package_delete_model->loadDefaultValues();
        }
        return $this->renderAjax('_delete_form', [
            'model' => $model,
        ]);
    }

    public function actionMarkAsPopular($id)
    {
        $model = Package::find()->where(['id' => $id])->limit(1)->one();
        $model->popular_package = 1;
        if ($model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Mark Popular Successfully!!!');
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionRemovePopular($id)
    {
        $model = Package::find()->where(['id' => $id])->limit(1)->one();
        $model->popular_package = 0;
        if ($model->save(false)) {
            \Yii::$app->session->setFlash('success', 'Remove From Successfully!!!');
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }


    public function actionPlatformDiscount($id)
    {
        $package = Package::find()->where(['id' => $id])->one();
        if (empty($package)) {
            Yii::$app->session->setFlash('error', 'Package not found.');
            return $this->redirect(['index']);
        }

        $model = new PackageDiscountForm($package);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_discount_model->save(false)) {
                        Yii::$app->session->setFlash('success', 'Platform Discount Save successfully.');
                        return $this->redirect(['index', 'id' => $id]);
                    }
                }
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_platform_discount', [
                'model' => $model,
            ]);
        }
    }
}
