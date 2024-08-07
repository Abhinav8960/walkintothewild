<?php

namespace console\controllers;

use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;
use common\models\trierror\SitePages;
use common\models\GeneralModel;


/**
 * FrontendRequestLogController implements the CRUD actions for FrontendRequestLog model.
 */
class CreateSiteXmlController extends Controller
{
  public function actionIndex()
  {
    $start = microtime(true);

    $records = SitePages::find()->where(['status' => true])->all();
    if (count($records) > 0) {
      $xml_content = "<?xml version='1.0' encoding='UTF-8'?>";
      $xml_content .= "<sitemapindex xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
      foreach ($records as $rec) {
        $xml_content .= "<sitemap>";
        $xml_content .= "<loc>" . $base_url = Yii::$app->params['frontend_url'] . $rec->url . "</loc>";
        $xml_content .= "<lastmod>" . date('Y-m-d', strtotime($rec->last_update_at)) . "</lastmod>";
        $xml_content .= "</sitemap>";
      }
      $xml_content .= "</sitemapindex>";

      $myFile = Yii::$app->params['datapath'] . "/" . "sitemap/" . "sitemap.xml";
      $fh = fopen($myFile, 'w') or die("can't open file");
      fwrite($fh, $xml_content);
      fclose($fh);
    }

    $end = microtime(true);
    $executionTime = $end - $start;
    echo "Script execution time: " . $executionTime . " seconds";
  }

  public function actionSitePagesCounter()
  {
    $start = microtime(true);

    $records = SitePages::find()->where(['status' => true])->all();
    if (count($records) > 0) {
    }
  }
}
