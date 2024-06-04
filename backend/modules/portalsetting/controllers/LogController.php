<?php

namespace backend\modules\portalsetting\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class LogController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Allow only authenticated users
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'export' => ['GET'], // Allow GET request for export action
                    'clear' => ['POST'], // Allow POST request for clear action
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        // Path to your log file
        $logFile = Yii::getAlias('@runtime/logs/app.log');

        // Check if the log file exists
        if (!file_exists($logFile)) {
            throw new \yii\web\NotFoundHttpException('Log file does not exist.');
        }

        // Read the log file content
        $logs = file_get_contents($logFile);

        // Set response format to plain text
        // Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/plain');

        return $this->render('index', [
            'logs' => $logs
        ]);
    }



    public function actionExport()
    {
        $logFile = Yii::getAlias('@runtime/logs/app.log');

        if (!file_exists($logFile)) {
            throw new NotFoundHttpException('Log file does not exist.');
        }

        return Yii::$app->response->sendFile($logFile, 'app.log');
    }

    public function actionClear()
    {
        $logFile = Yii::getAlias('@runtime/logs/app.log');

        if (!file_exists($logFile)) {
            throw new NotFoundHttpException('Log file does not exist.');
        }

        // Debugging: log the file path and permissions
        Yii::info("Log file path: $logFile", __METHOD__);
        Yii::info("Log file permissions: " . substr(sprintf('%o', fileperms($logFile)), -4), __METHOD__);

        // Delete the log file
        if (unlink($logFile)) {
            // Recreate the log file and set permissions
            if (file_put_contents($logFile, '') !== false) {
                chmod($logFile, 0666); // Set read and write permissions for all users
                Yii::$app->session->setFlash('success', 'Log file has been cleared and recreated.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to recreate log file.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete log file.');
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }
}
