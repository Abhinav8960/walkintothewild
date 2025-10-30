<?php

namespace backend\modules\package\controllers;

use common\interfaces\StatusInterface;
use common\models\package\form\PackageDeleteForm;
use common\models\package\form\PackageDiscountForm;
use common\models\package\form\PackageTemplateForm;
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
        $package = $this->findModel($id);
        if (empty($package)) {
            return $this->redirect(['/package']);
            $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
            throw new NotFoundHttpException($message);
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
            $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
            throw new NotFoundHttpException($message);
        }

        $model = new PackageVersionForm($package_version_model);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->package_version_model->popular_package = $model->popular_package;
                if ($model->package_version_model->save(false)) {
                    $message = Yii::$app->messageManager->getMessage('common.updated', ['{var}' => 'Data']);
                    \Yii::$app->session->setFlash('success', $message);
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
        if (($model = Package::findOne(['id' => $id, 'status' => [Package::STATUS_ACTIVE, Package::STATUS_SUSPEND, Package::STATUS_BLOCKED]])) !== null) {
            return $model;
        }
        $message = Yii::$app->messageManager->getMessage('common.page_not_exist');
        throw new NotFoundHttpException($message);
    }

    public function actionReplyview($id)
    {
        $review = PackageComment::find()->where(['parent_id' => $id]);
        if (empty($review)) {
            $message = Yii::$app->messageManager->getMessage('common.invalid_request');
            \Yii::$app->session->setFlash('error', $message);
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
            $message = Yii::$app->messageManager->getMessage('common.invalid_request');
            \Yii::$app->session->setFlash('error', $message);
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
                        $message = Yii::$app->messageManager->getMessage('common.deleted');
                        \Yii::$app->session->setFlash('success', $message);
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
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Mark Popular']);
            \Yii::$app->session->setFlash('success', $message);
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    public function actionRemovePopular($id)
    {
        $model = Package::find()->where(['id' => $id])->limit(1)->one();
        $model->popular_package = 0;
        if ($model->save(false)) {
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Removed']);
            \Yii::$app->session->setFlash('success', $message);
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }


    public function actionPlatformDiscount($id)
    {
        $package = Package::find()->where(['id' => $id])->one();
        if (empty($package)) {
            $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            Yii::$app->session->setFlash('error', $message);
            return $this->redirect(['index']);
        }

        $model = new PackageDiscountForm($package);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_discount_model->save(false)) {
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Platform Discount Saved']);
                        Yii::$app->session->setFlash('success', $message);
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

    public function actionSetAsBestDeal($id)
    {
        $package = Package::find()->where(['id' => $id])->one();
        if (empty($package)) {
            $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Package']);
            Yii::$app->session->setFlash('error', $message);
            return $this->redirect(['index']);
        }

        $package->is_best_deal = 1;
        if ($package->save(false)) {
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Package set as Best Deal']);
            Yii::$app->session->setFlash('success', $message);
            return $this->redirect(['index', 'id' => $id]);
        }
    }

    public function actionSetTemplate($id)
    {
        $package_template_model = Package::find()->where(['id' => $id])->limit(1)->one();
        $model = new PackageTemplateForm($package_template_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->package_template_model->save(false)) {
                        $version = PackageVersion::find()->where(['package_id' => $package_template_model->id])->andWhere(['version' => $package_template_model->live_version])->limit(1)->one();
                        $version->template_code = $model->package_template_model->template_code;
                        $version->save(false);
                        $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Template']);
                        \Yii::$app->session->setFlash('success', $message);
                        return $this->redirect(['index', 'id' => $id]);
                    }
                }
            }
        } else {
            $model->package_template_model->loadDefaultValues();
        }
        return $this->renderAjax('_template_form', [
            'model' => $model,
        ]);
    }
}
