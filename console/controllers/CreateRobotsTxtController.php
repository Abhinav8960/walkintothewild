<?php

namespace console\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;
use common\models\trierror\SitePages;
use common\models\trierror\SiteRobots;
use common\models\GeneralModel;
use common\models\trierror\FrontendRequestLog;
use common\models\trierror\SiteUntracedRequest;

/**
 * FrontendRequestLogController implements the CRUD actions for FrontendRequestLog model.
 */
class CreateRobotsTxtController extends Controller
{
  public function actionIndex()
  {
    $start = microtime(true);
    $end = microtime(true);
    $executionTime = $end - $start;

    //create robots.txt to make entry of sitemap_icdndex.xml
    $content = "Sitemap: " . Yii::$app->params['frontend_url'] . "storage/sitemap/sitemap.xml";
    $all_url = SiteRobots::find()->where(['status' => true])->all();
    if (count($all_url) > 0) {
      $content .= "\nUser-agent: *";
      foreach ($all_url as $row) {
        $content .= "\n" . "Disallow: : " . $row->url;
      }
    }

    $robots_actual_url = \Yii::$app->getBasePath(true);
    $robots_actual_url = str_replace("console", "frontend/web", $robots_actual_url);
    $fp = fopen($robots_actual_url . "/robots.txt", "w");
    fwrite($fp, $content);
    fclose($fp);

    echo "Script execution time: " . $executionTime . " seconds";
  }
}
