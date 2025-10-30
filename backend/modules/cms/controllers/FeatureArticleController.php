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
        $sequences = Article::find()->select(['sequence', 'id'])->where(['status' => Article::STATUS_ACTIVE])->indexBy('sequence')->column();
        $sequences = Article::find()
            ->select(['sequence', 'id'])
            ->where([
                'status' => 1
            ])
            ->indexBy('sequence')
            ->column();

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
            Article::updateAll([
                'sequence' => NULL
            ]);
            if (isset(Yii::$app->request->bodyParams['ArticleSequence'])) {
                foreach (Yii::$app->request->bodyParams['ArticleSequence'] as $sequence => $articleid) {
                    Article::updateAll(['sequence' => $sequence], ['id' => $articleid]);
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true, 'message' => 'Data Saved'];
        } else {
            $message = Yii::$app->messageManager->getMessage('invalid_request');
            throw new BadRequestHttpException($message);
        }
    }
}
