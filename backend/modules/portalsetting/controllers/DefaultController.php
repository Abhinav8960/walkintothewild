<?php

namespace backend\modules\portalsetting\controllers;

use yii\web\Controller;
use Yii;
use yii\helpers\FileHelper;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionParams()
    {
        return $this->render('params');
    }


    public function actionClearCache()
    {
        // Clear Cache the log file
        if (Yii::$app->cache->flush()) {
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Cache Cleared']);
            \Yii::$app->session->setFlash('success', $message);
        } else {
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'cleared Cache']);
            \Yii::$app->session->setFlash('error', $message);
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionClearAssets($type = 'backend')
    {
        $assetsPath = Yii::getAlias("@$type/web/assets");

        // Check if the directory exists
        if (is_dir($assetsPath)) {
            // Get all files and folders within the assets directory
            $items = scandir($assetsPath);

            // Remove "." and ".." entries from the list
            $items = array_diff($items, ['.', '..']);

            // Loop through each item and delete it
            foreach ($items as $item) {
                $itemPath = $assetsPath . DIRECTORY_SEPARATOR . $item;

                // If the item is a directory, recursively delete it
                if (is_dir($itemPath)) {
                    FileHelper::removeDirectory($itemPath);
                } else {
                    unlink($itemPath); // Delete the file
                }
            }
            $message = Yii::$app->messageManager->getMessage('common.successfully', ['{var}' => 'Assets cleared']);
            \Yii::$app->session->setFlash('success', $message);
        } else {
            $message = Yii::$app->messageManager->getMessage('common.not_found', ['{var}' => 'Assets directory']);
            \Yii::$app->session->setFlash('error', $message);
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }
}
