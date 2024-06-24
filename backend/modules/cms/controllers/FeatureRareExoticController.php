<?php

namespace backend\modules\cms\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use common\models\park\SafariPark;
use yii\web\BadRequestHttpException;
use common\models\master\animal\MasterRareAnimal;

class FeatureRareExoticController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $sequences = MasterRareAnimal::find()->select(['is_feature_sequence', 'id'])->indexBy('is_feature_sequence')->column();

        return $this->render('index', [
            'sequences' => $sequences,
        ]);
    }

    /**
     * Save Sequence of Aniaml
     */
    public function actionSaveSequence()
    {
        if (Yii::$app->request->isPost) {
            MasterRareAnimal::updateAll([
                'is_feature_sequence' => NULL
            ]);
            if (isset(Yii::$app->request->bodyParams['AnimalSequence'])) {
                foreach (Yii::$app->request->bodyParams['AnimalSequence'] as $is_feature_sequence => $animal_id) {
                    MasterRareAnimal::updateAll(['is_feature_sequence' => $is_feature_sequence], ['id' => $animal_id]);
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true, 'message' => 'Data Saved'];
        } else {
            throw new BadRequestHttpException('Invalid request');
        }
    }


    // public function actionSaveSequence()
    // {
    //     if (Yii::$app->request->isPost) {
    //         Yii::$app->response->format = Response::FORMAT_JSON;

    //         $sequenceIndex = Yii::$app->request->post('sequenceIndex');
    //         $parkId = Yii::$app->request->post('parkId');

    //         // Debugging information
    //         Yii::info('Received sequenceIndex: ' . $sequenceIndex . ', parkId: ' . $parkId);

    //         // Find the existing record or create a new one
    //         $model = SafariPark::findOne(['id' => $parkId]);
    //         if ($model === null) {
    //             // Handle the case where the park is not found
    //             Yii::error('Park not found for ID: ' . $parkId);
    //             return ['success' => false, 'error' => 'Park not found'];
    //         }


    //         SafariPark::updateAll(['animal_type_sequence' => NULL], ['animal_type_sequence' => $sequenceIndex]);

    //         // Encode the updated sequence array back to JSON and save it
    //         $model->animal_type_sequence = $sequenceIndex;

    //         if ($model->save()) {
    //             return ['success' => true];
    //         } else {
    //             Yii::error('Failed to save park animal sequence: ' . print_r($model->getErrors(), true));
    //             return ['success' => false, 'errors' => $model->getErrors()];
    //         }
    //     }

    //     Yii::error('Invalid AJAX request');
    //     throw new BadRequestHttpException('Invalid request');
    // }
}
