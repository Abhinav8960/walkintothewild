<?php

namespace console\controllers;


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
        echo "<pre>";
        $reponse = \Yii::$app->moderation->imageFeedback($url);
        \Yii::info("ImageFeedBack: " . json_encode($reponse));
        print_r($reponse);

        die();
    }

    public function actionVideo($url = "https://d281t0xjcq032r.cloudfront.net/watchpost/762/media/762_media_1740725548.mp4")
    {
        echo "<pre>";
        $reponse = \Yii::$app->moderation->videoFeedback($url);
        \Yii::info("VideoFeedBack: " .json_encode($reponse));
        print_r($reponse);
        die();
    }

    public function actionText($text = "Seven five six nine six zero one 8 one 8 , chala jata hu kisi ki dhun me tadapde din ke tarane liye")
    {
        echo "<pre>";
        $reponse = \Yii::$app->moderation->textFeedback($text);
        \Yii::info("TextFeedBack: " .json_encode($reponse));
        print_r($reponse);
        die();
    }
}
