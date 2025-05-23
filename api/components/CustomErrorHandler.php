<?php
namespace api\components;

use Yii;
use yii\web\ErrorHandler;
use yii\web\Response;
use yii\db\Exception as DbException;

class CustomErrorHandler extends ErrorHandler
{
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            $response->isSent = false;
            $response->stream = null;
            $response->data = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        $response->setStatusCodeByException($exception);

        // Handle database exceptions
        if ($exception instanceof DbException) {
            $response->data = [
                'name' => 'Database Error',
                'message' => 'An error occurred while processing your request. Please try again later.',
                'code' => $exception->getCode(),
            ];
        } else {
            // Handle other exceptions
            $response->data = [
                'name' => $exception->getName(),
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }

        $response->send();






        
    }
}