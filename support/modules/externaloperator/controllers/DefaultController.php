<?php

namespace support\modules\externaloperator\controllers;

use common\models\externaloperator\form\ExternalOperatorForm;
use common\models\externaloperator\ExternalOperator;
use common\models\externaloperator\ExternalOperatorParks;
use common\models\externaloperator\ExternalOperatorSearch;
use common\models\GeneralModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

/**
 * DefaultController for the `sightings` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ExternalOperatorSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new ExternalOperatorForm();
        $model->status = ExternalOperator::STATUS_ACTIVE;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->externaloperator_model->save(false)) {
                        $selectedParkIds = $model->park_list ?? [];
                        $this->ExternalOperatorParks($selectedParkIds, $model->externaloperator_model->id);
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->externaloperator_model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $externaoperator_model = $this->findModel($id);
        $model = new ExternalOperatorForm($externaoperator_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->externaloperator_model->save(false)) {
                        $selectedParkIds = $model->park_list ?? [];
                        $this->ExternalOperatorParks($selectedParkIds, $model->externaloperator_model->id);
                        \Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->externaloperator_model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ExternalOperator::findOne(['id' => $id, 'status' => [ExternalOperator::STATUS_ACTIVE]])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function ExternalOperatorParks($selectedParkIds, $id)
    {
        $existingParks = ExternalOperatorParks::find()
            ->where(['external_operator_id' => $id])
            ->indexBy('park_id')
            ->all();

        foreach ($existingParks as $parkId => $park) {
            if (!in_array($parkId, $selectedParkIds)) {
                $park->status = -1;
                $park->save(false);
            }
        }

        foreach ($selectedParkIds as $parkId) {
            if (isset($existingParks[$parkId])) {
                $existingParks[$parkId]->status = 1;
                $existingParks[$parkId]->save(false);
            } else {
                $newPark = new ExternalOperatorParks();
                $newPark->external_operator_id = $id;
                $newPark->park_id = $parkId;
                $newPark->status = 1;
                $newPark->save(false);
            }
        }

        $operated_parks = ExternalOperatorParks::find()
            ->select('park_id')
            ->where([
                'external_operator_id' => $id,
                'status' => 1
            ])
            ->column();
        return $operated_parks;
    }

    public function actionCallDone($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Call status updated successfully.');
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('_call_done', ['model' => $model]);
    }

    public function actionEmailSend($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Email status updated successfully.');
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('_email_send', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -1;
        if ($model->save()) {
            \Yii::$app->session->setFlash('success', 'Deleted Successfully');
        }
        return $this->redirect(['index']);
    }
}
