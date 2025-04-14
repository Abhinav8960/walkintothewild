<?php

namespace backend\modules\paymentlinks\controllers;

use common\interfaces\StatusInterface;
use common\models\paymentgateway\payu\form\PaymentLinksForm;
use common\models\paymentgateway\payu\PaymentLinks;
use common\models\paymentgateway\payu\PaymentLinksSearch;
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
        $searchModel = new PaymentLinksSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }




    public function actionCreate($objective, $collection, $collection_id)
    {
        $model = new PaymentLinksForm();
        $model->objective = $objective;
        $model->collection = $collection;
        $model->collection_id = $collection_id;
        $model->status = StatusInterface::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->form_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }else{
                    \Yii::$app->session->setFlash('error', 'Data Not Submitted');
                    print_r($model->errors);
                    die();
                }
            }
        } else {
            $model->form_model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView($package_id)
    {
        $model = $this->findModel($package_id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }




    /**
     * Deleted Model
     *
     * @param [type] $id
     * @return void
     */
    public function actionDeleted($id)
    {
        $model = PaymentLinks::find()->where(['id' => $id])->limit(1)->one();
        $model->status = PaymentLinks::STATUS_DELETED;
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
        // if (($model = PaymentLinks::findOne(['id' => $id, 'status' => [PaymentLinks::STATUS_ACTIVE, Package::STATUS_DELETED]])) !== null) {
        if (($model = PaymentLinks::find()->where(['id' => $id])->andWhere(['!=', 'status', PaymentLinks::STATUS_DELETED])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
}
