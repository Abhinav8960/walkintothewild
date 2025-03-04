<?php

namespace console\controllers;

use common\models\moderation\form\ModerationForm;
use yii\console\Controller;

/**
 * Main Controller for YII Console
 */
class ModerationController extends Controller
{

    /**
     * Console Working Check
     *
     * @return void
     */
    public function actionImage($url = "https://images.unsplash.com/photo-1599470609787-113eac30917d?q=80&w=1990&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D")
    {
        $this->actionStoreImageFeedback(\Yii::$app->moderation->imageFeedback($url));

        // echo "<pre>";
        // $reponse = \Yii::$app->moderation->imageFeedback($url);
        // \Yii::info("ImageFeedBack: " . json_encode($reponse));
        // print_r($reponse);

        // die();
    }

    public function actionVideo($url = "https://d281t0xjcq032r.cloudfront.net/watchpost/762/media/762_media_1740725548.mp4")
    {
        $this->actionStoreVideoFeedback(\Yii::$app->moderation->videoFeedback($url));

        // echo "<pre>";
        // $reponse = \Yii::$app->moderation->videoFeedback($url);
        // \Yii::info("VideoFeedBack: " . json_encode($reponse));
        // print_r($reponse);
        // die();
    }

    public function actionText($text = "Seven five six nine six zero one 8 one 8 , chala jata hu kisi ki dhun me tadapde din ke tarane liye, http://localhost/phpmyadmin/index.php?route=/table/create&server=1&db=wildwalks")
    {
        $this->actionStoreTextFeedback(\Yii::$app->moderation->textFeedback($text));
        // echo "<pre>";
        // $reponse = \Yii::$app->moderation->textFeedback($text);
        // \Yii::info("TextFeedBack: " . json_encode($reponse));
        // print_r($reponse);
        // die();
    }

    public function actionStoreVideoFeedback($feedback = NULL)
    {
        if ($feedback == NULL) {

            $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/video.json");
        }
        $this->actionStore($feedback, ModerationForm::MODERATION_TYPE_VIDEO);
    }
    public function actionStoreImageFeedback($feedback = NULL)
    {
        if ($feedback == NULL) {

            $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/image.json");
        }
        $this->actionStore($feedback, ModerationForm::MODERATION_TYPE_IMAGE);
    }
    public function actionStoreTextFeedback($feedback = NULL)
    {
        if ($feedback == NULL) {

            $feedback = file_get_contents("/home/ak/project/walkintothewild/console/runtime/logs/text.json");
        }
        $this->actionStore($feedback, ModerationForm::MODERATION_TYPE_TEXT);
    }

    private function actionStore($feedback, $moderation_type)
    {
        $fb = json_decode($feedback, true);
        $model = new ModerationForm();
        $model->request_id = $fb['request']['id'];
        $model->request_timestamp = (string) $fb['request']['timestamp'];
        $model->moderation_type = $moderation_type;
        $model->feedback = $fb;
        $model->status = 1;
        if ($model->save()) {
            echo "Feedback Stored Successfully";
        } else {
            exit("Error: " . json_encode($model->errors));
        }
    }
}
