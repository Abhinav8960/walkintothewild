<?php

namespace backend\modules\cms\controllers;

use common\models\cms\article\Article;
use yii\web\Response;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class FeatureArticleController extends Controller
{
    public $enableCsrfValidation = true;

    public function actionIndex()
    {
        // Fetch the current sequences
        $sequences = Article::find()->select(['sequence', 'id'])->where("status=1 AND (user_type=3 OR is_approved=1)")->indexBy('sequence')->column();

        return $this->render('index', [
            'sequences' => $sequences,
        ]);
    }


    public function actionSaveSequence()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $sequenceIndex = Yii::$app->request->post('sequenceIndex');
            $articleId = Yii::$app->request->post('articleId');

            // Debugging information
            Yii::info('Received sequenceIndex: ' . $sequenceIndex . ', articleId: ' . $articleId);

            // Find the existing record or create a new one
            $model = Article::findOne(['id' => $articleId]);
            if ($model === null) {
                Yii::error('Article not found for ID: ' . $articleId);
                return ['success' => false, 'error' => 'Article not found'];
            }


            Article::updateAll(['sequence' => NULL], ['sequence' => $sequenceIndex]);

            // Encode the updated sequence array back to JSON and save it
            $model->sequence = $sequenceIndex;

            if ($model->save()) {
                return ['success' => true];
            } else {
                Yii::error('Failed to save article sequence: ' . print_r($model->getErrors(), true));
                return ['success' => false, 'errors' => $model->getErrors()];
            }
        }

        Yii::error('Invalid AJAX request');
        throw new BadRequestHttpException('Invalid request');
    }
}
