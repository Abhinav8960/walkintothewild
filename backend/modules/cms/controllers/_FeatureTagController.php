<?php

namespace backend\modules\cms\controllers;

use common\models\cms\blog\MasterBlogTag;
use yii\web\Response;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class FeatureTagController extends Controller
{
    public $enableCsrfValidation = true;

    public function actionIndex()
    {
        // Fetch the current sequences
        $sequences = MasterBlogTag::find()->select(['sequence', 'id'])->indexBy('sequence')->column();

        return $this->render('index', [
            'sequences' => $sequences,
        ]);
    }


    public function actionSaveSequence()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $sequenceIndex = Yii::$app->request->post('sequenceIndex');
            $tagId = Yii::$app->request->post('tagId');

            // Debugging information
            Yii::info('Received sequenceIndex: ' . $sequenceIndex . ', tagId: ' . $tagId);

            // Find the existing record or create a new one
            $model = MasterBlogTag::findOne(['id' => $tagId]);
            if ($model === null) {
                Yii::error('Tag not found for ID: ' . $tagId);
                return ['success' => false, 'error' => 'Tag not found'];
            }


            MasterBlogTag::updateAll(['sequence' => NULL], ['sequence' => $sequenceIndex]);

            // Encode the updated sequence array back to JSON and save it
            $model->sequence = $sequenceIndex;

            if ($model->save()) {
                return ['success' => true];
            } else {
                Yii::error('Failed to save tag sequence: ' . print_r($model->getErrors(), true));
                return ['success' => false, 'errors' => $model->getErrors()];
            }
        }

        Yii::error('Invalid AJAX request');
        throw new BadRequestHttpException('Invalid request');
    }
}
