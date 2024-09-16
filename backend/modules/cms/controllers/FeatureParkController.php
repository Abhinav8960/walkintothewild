<?php

namespace backend\modules\cms\controllers;

use common\models\cms\banner\Banner;
use common\models\cms\banner\form\UpdateFeaturePageTitleForm;
use yii\web\Response;
use common\models\park\Park;
use common\models\park\SafariPark;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class FeatureParkController extends Controller
{
    public $enableCsrfValidation = true;

    public function actionIndex()
    {
        // Fetch the list of parks

        // Fetch the current sequences
        $sequences = SafariPark::find()->select(['sequence', 'id'])->indexBy('sequence')->column();

        return $this->render('index', [
            'sequences' => $sequences,
        ]);
    }


    public function actionSaveSequence()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $sequenceIndex = Yii::$app->request->post('sequenceIndex');
            $parkId = Yii::$app->request->post('parkId');

            // Debugging information
            Yii::info('Received sequenceIndex: ' . $sequenceIndex . ', parkId: ' . $parkId);

            // Find the existing record or create a new one
            $model = SafariPark::findOne(['id' => $parkId]);
            if ($model === null) {
                // Handle the case where the park is not found
                Yii::error('Park not found for ID: ' . $parkId);
                return ['success' => false, 'error' => 'Park not found'];
            }


            SafariPark::updateAll(['sequence' => NULL], ['sequence' => $sequenceIndex]);

            // Encode the updated sequence array back to JSON and save it
            $model->sequence = $sequenceIndex;

            if ($model->save()) {
                return ['success' => true];
            } else {
                Yii::error('Failed to save park sequence: ' . print_r($model->getErrors(), true));
                return ['success' => false, 'errors' => $model->getErrors()];
            }
        }

        Yii::error('Invalid AJAX request');
        throw new BadRequestHttpException('Invalid request');
    }

    public function actionFeatureParkTitle()
    {
        $feature_page_model = Banner::find()->where(['page_id' => 1, 'status' => [Banner::STATUS_ACTIVE, Banner::STATUS_SUSPEND]])->limit(1)->one();
        $model = new UpdateFeaturePageTitleForm($feature_page_model);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    $model->initializeForm();
                    if ($model->feature_page_model->save()) {
                        \Yii::$app->session->setFlash('success', 'Data Updated Successfully');
                        return $this->redirect(['index']);
                    }
                }
            }
        } else {
            $model->feature_page_model->loadDefaultValues();
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
}
