<?php

namespace backend\modules\packageapproval\controllers;

use common\models\package\Package;
use common\models\package\PackageFaqSearch;
use common\models\package\PackageSearch;
use common\models\package\PackageStates;
use Yii;
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
        $searchModel = new PackageSearch();
        $searchModel->status = 1;
        // $searchModel->status = [Package::APPROVED_AND_LIVE_STATUS,Package::SEND_FOR_status];
        $searchModel->status = Package::SEND_FOR_APPROVAL_STATUS;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $searchModel = new PackageFaqSearch();
        $searchModel->package_id = $model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $faqs = $dataProvider->getModels();

        return $this->render('view', [
            'package' => $model,
            'faqs' => $faqs,
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
        if (($model = Package::findOne(['id' => $id, 'status' => [Package::APPROVED_AND_LIVE_STATUS, Package::NOT_APPROVED_STATUS]])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApproved($uuid, $version)
    {
        $packagestate = PackageStates::find()->where(['uuid' => $uuid, 'pending_for_approval_version' => $version])->one();
        if (empty($packagestate)) {
            Yii::$app->session->setFlash('error', 'Package not found.');
            return $this->redirect(['index']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!empty($packagestate->live_version)) {
                $this->terminatePackage($uuid, $packagestate->live_version);
            }
            $packagestate->live_version = $version;
            $packagestate->pending_for_approval_version = null;
            $packagestate->save(false);

            $model = Package::find()->where(['uuid' => $uuid, 'version' => $version])->one();
            $model->status = Package::APPROVED_AND_LIVE_STATUS;
            $model->save(false);
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
            // echo "<pre>";
            // print_r($e->getMessage());
            // die();
            Yii::$app->session->setFlash('error', 'Failed to approve package.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $transaction->commit();


        Yii::$app->session->setFlash('success', 'Package approved and Live successfully.');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRejectview($uuid, $version)
    {
        $model = Package::find()->where(['uuid' => $uuid, 'version' => $version])->one();

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_rejection_form', [
                'uuid' => $uuid,
                'version' => $version,
                'model' => $model
            ]);
        }
    }

    public function actionReject($uuid, $version)
    {
        $packagestate = PackageStates::find()->where(['uuid' => $uuid, 'pending_for_approval_version' => $version])->one();
        if (empty($packagestate)) {
            Yii::$app->session->setFlash('error', 'Package not found.');
            return $this->redirect(['index']);
        }
        $model = Package::find()->where(['uuid' => $uuid, 'version' => $version])->one();
        $model->scenario = 'reject';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $packagestate->pending_for_approval_version = null;
                    $packagestate->save(false);

                    $model->status = Package::NOT_APPROVED_STATUS;
                    $model->cancellation_reason = \Yii::$app->request->post('Package')['cancellation_reason'] ?? NULL;
                    $model->status = Package::NOT_APPROVED_STATUS;
                    $model->save(false);
                } catch (\Exception $e) {
                    Yii::error($e->getMessage());
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'An error occurred while sending for approval: ' . $e->getMessage());
                    Yii::$app->session->setFlash('error', 'Failed to reject package.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Package rejected successfully.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_rejection_form', [
                'model' => $model,
            ]);
        }
    }


    private function terminatePackage($uuid, $version)
    {
        $model = Package::find()->where(['uuid' => $uuid, 'version' => $version])->one();
        if ($model) {
            $model->status = Package::TERMINATED_STATUS;
            $model->save(false);
            return true;
        }
        return false;
    }
}
