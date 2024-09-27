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
            Yii::$app->session->setFlash('success', 'Cache successfully cleared.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to clear cache.');
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

            Yii::$app->session->setFlash('success', 'Assets cleared successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Assets directory not found.');
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }
}
