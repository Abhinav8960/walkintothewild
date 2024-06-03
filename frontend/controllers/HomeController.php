<?php

namespace frontend\controllers;

use common\models\RenderedContent;
use Yii;
use yii\web\Controller;

/**
 *  Home controller
 */
class HomeController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->view->on(\yii\web\View::EVENT_AFTER_RENDER, function ($event) {
            // Save rendered content and other details to the database
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $renderedContent = new RenderedContent();
                $renderedContent->created_at = date('Y-m-d H:i:s');
                $renderedContent->url = Yii::$app->request->absoluteUrl;
                $renderedContent->title = Yii::$app->view->title;
                $renderedContent->action_url = Yii::$app->request->url;

                // Save query parameters to a separate column
                $queryParams = Yii::$app->request->getQueryParams();
                $renderedContent->query_params = json_encode($queryParams); // Save query parameters as JSON

                // Add device info and IP address
                $renderedContent->user_agent = Yii::$app->request->userAgent;
                $renderedContent->ip_address = Yii::$app->request->userIP;

                if ($renderedContent->save()) {
                    $transaction->commit();
                } else {
                    Yii::error('Failed to save rendered content: ' . json_encode($renderedContent->errors));
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                Yii::error('Exception occurred while saving rendered content: ' . $e->getMessage());
                $transaction->rollBack();
            }
        });
    }

    /**
     * Displays profile Page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
