<?php

namespace backend\modules\cms\controllers;

use common\models\cms\blog\Blog;
use yii\web\Response;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class FeatureBlogController extends Controller
{
    public $enableCsrfValidation = true;

    public function actionIndex()
    {
        // Fetch the current sequences
        //$sequences = Blog::find()->select(['sequence', 'id'])->where("blog.id IN (SELECT id FROM `blog` WHERE (`blog`.`status`=1) AND (is_schedule=0 OR DATE(publish_date_time)<='" . date('Y-m-d') . "') AND (`blog`.`status`=1) and user_type=3) OR blog.id IN (SELECT id FROM `blog` WHERE (`blog`.`status`=1) AND (is_schedule=0 OR DATE(publish_date_time)<='" . date('Y-m-d') . "') AND (`blog`.`status`=1) and is_approved=1 and user_type IN (1,2))")->indexBy('sequence')->column();
        // $sequences = Blog::find()
        //     ->select(['sequence', 'id'])
        //     ->where([
        //         'status' => 1,
        //         'is_approved' => 1,
        //     ])
        //     ->indexBy('sequence')
        //     ->column();

        // return $this->render('index', [
        //     'sequences' => $sequences,
        // ]);
    }


    /**
     * Save Sequence of Aniaml
     */
    public function actionSaveSequence()
    {
        // if (Yii::$app->request->isPost) {
        //     Blog::updateAll([
        //         'sequence' => NULL
        //     ]);
        //     if (isset(Yii::$app->request->bodyParams['BlogSequence'])) {
        //         foreach (Yii::$app->request->bodyParams['BlogSequence'] as $sequence => $blogid) {
        //             Blog::updateAll(['sequence' => $sequence], ['id' => $blogid]);
        //         }
        //     }
        //     Yii::$app->response->format = Response::FORMAT_JSON;
        //     return ['success' => true, 'message' => 'Data Saved'];
        // } else {
        //     throw new BadRequestHttpException('Invalid request');
        // }
    }
}
