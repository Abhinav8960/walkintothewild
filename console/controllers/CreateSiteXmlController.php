<?php

namespace console\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;
use common\models\GeneralModel;

class CreateSiteXmlController extends Controller
{

  public function actionDump_untraced_request()
  {
    $start = microtime(true);

    $connection = \Yii::$app->getDb();
    $command = $connection->createCommand("SELECT DISTINCT(request_full_url) FROM site_frontend_request WHERE is_reqeust_trace = 0 and request_url NOT IN (SELECT DISTINCT(url) AS url FROM site_pages where status = 1) AND request_url NOT IN (SELECT DISTINCT(url) AS url FROM site_untraced_request)");
    $un_traced_record = $command->queryAll();
    if (count($un_traced_record) > 0) {
      $temp_array = [];
      foreach ($un_traced_record as $record) {
        $temp_array[] = [
          'url' => $record['request_full_url']
        ];
      }

      //insert all records at once
      \Yii::$app->db->createCommand()->batchInsert('site_untraced_request', ['url'], $temp_array)->execute();
    }

    $command = \Yii::$app->db->createCommand(
      'UPDATE site_frontend_request SET is_reqeust_trace = 1 WHERE id <> 0'
    );
    $command->execute();

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }
}
