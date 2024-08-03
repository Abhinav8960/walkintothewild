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
        $sequences = Article::find()->select(['sequence', 'id'])->where("article.id IN (SELECT id FROM `article` WHERE (`article`.`status`=1) AND (is_schedule=0 OR DATE(publish_date_time)<='" . date('Y-m-d') . "') AND (`article`.`status`=1) and user_type=3) OR article.id IN (SELECT id FROM `article` WHERE (`article`.`status`=1) AND (is_schedule=0 OR DATE(publish_date_time)<='" . date('Y-m-d') . "') AND (`article`.`status`=1) and is_approved=1 and user_type IN (1,2))")->indexBy('sequence')->column();

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
            throw new BadRequestHttpException('Invalid request');
        }
    }
}
