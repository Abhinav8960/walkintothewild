<?php

namespace backend\modules\package\controllers;


use common\models\package\Package;
use common\models\package\PackageVersion;
use common\models\package\PackageSearch;
use common\models\package\PackageVersionSearch;
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
        $searchModel->status = Package::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->query->andWhere("safari_operator_id IN (SELECT id from safari_operator WHERE status=1)");


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



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

    public function actionRejectList()
    {
        $searchModel = new PackageVersionSearch();
        $searchModel->status = PackageVersion::NOT_APPROVED_STATUS;
        $dataProvider = $searchModel->partnersearch(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['IS NOT', 'cancellation_reason', NULL]);

        return $this->render('_cancellation_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
