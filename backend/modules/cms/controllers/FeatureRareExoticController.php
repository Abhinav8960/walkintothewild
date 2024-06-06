<?php

namespace backend\modules\cms\controllers;

use yii\web\Response;
use common\models\park\SafariPark;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class FeatureRareExoticController extends Controller
{
    public $enableCsrfValidation = true;

    public function actionIndex()
    {
        $sequences = SafariPark::find()->select(['animal_type_sequence', 'id'])->indexBy('animal_type_sequence')->column();

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


            SafariPark::updateAll(['animal_type_sequence' => NULL], ['animal_type_sequence' => $sequenceIndex]);

            // Encode the updated sequence array back to JSON and save it
            $model->animal_type_sequence = $sequenceIndex;

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
}
