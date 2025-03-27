<?php
namespace api\components;

use Yii;
use yii\web\ErrorHandler;
use \yii\web\Response;

class CustomErrorHandler extends ErrorHandler
{
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            // reset parameters of response to avoid interference with partially created response data
            // in case the error occurred while sending the response.
            $response->isSent = false;
            $response->stream = null;
            $response->data = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        $response->setStatusCodeByException($exception);

        // $response->data = $this->convertExceptionToString($exception);

        $result = \Yii::$app->runAction($this->errorAction);
        // $response->data = $this->convertExceptionToArray($exception);
        // $response->data = json_decode($result);
        $response->data = $result;
        

        $response->send();






        
    }
}